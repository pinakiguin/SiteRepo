<?php
/**
 * API Calls from a valid user from an Android System.
 *
 *
 * The Response JSONObject will Contain the following Top Level Nodes
 *
 * 1. $Resp['API'] => boolean Status of the API Call
 * 2. $Resp['DB'] => Data to be sent depending upon the Called API
 * 3. $Resp['MSG'] => Message to be displayed after API Call
 * 4. $Resp['ET'] => Execution Time of the Script in Seconds
 * 5. $Resp['ST'] => Server Time of during the API Call
 *
 * @example Sample API Call
 *
 * Request:
 *   JSONObject={"API":"AG",
 *               "MDN":"9876543210",
 *               "OTP":"987654"}
 *
 * Response:
 *    JSONObject={"API":true,
 *               "DB":[{"GRP":"All BDOs"},{"GRP":"All SDOs"}],
 *               "MSG":"Total Groups: 2",
 *               "ET":2.0987,
 *               "ST":"Wed 20 Aug 08:31:23 PM"}
 *
 */

require_once(__DIR__ . '/AuthOTP.php');

class AndroidAPI {
  protected $Req;
  protected $Resp;
  private $Expiry;

  function __construct($jsonData) {
    $this->Resp['ET'] = time();
    $this->Expiry     = null;
    $this->Req        = $jsonData;
  }

  function __invoke() {
    $this->setCallAPI($this->Req->API);
  }

  /**
   * @param mixed $CallAPI
   */
  private function setCallAPI($CallAPI) {
    if (method_exists($this, $CallAPI)) {
      $this->$CallAPI();
    } else {
      /**
       * Unknown API Call
       */
      $this->Resp['API'] = false;
      $this->Resp['MSG'] = 'Invalid API';
    }
  }

  function __unset($name) {
    $this->sendResponse();
  }

  protected function sendResponse() {
    //$this->Resp['json'] = $this->Req; //TODO: Remove for Production
    $this->Resp['ET'] = time() - $this->Resp['ET'];
    $DateFormat       = 'D d M g:i:s A';
    $this->Resp['ST'] = date($DateFormat, time());

    $JsonResp = json_encode($this->Resp);

    header('Content-Type: application/json');
    header('Content-Length: ' . strlen($JsonResp));
    header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', $this->getExpiry()));
    echo $JsonResp;
  }

  /**
   * @return null
   */
  public function getExpiry() {
    /**
     * Important: Tells volley not to cache the response
     */
    if ($this->Expiry == null) {
      $Expires = time() - 3600;
    } else {
      $Expires = time() + $this->Expiry;
    }

    return $Expires;
  }

  /**
   * @param null $Expiry
   */
  protected function setExpiry($Expiry) {
    $this->Expiry = $Expiry;
  }

  function __destruct() {
    $this->sendResponse();
  }

  /**
   * Register User: Register User with Mobile No. to get the Secret Key for HOTP
   *
   * TODO Important: Store New Credentials in an Alternate field for validation against OTP
   *
   * Request:
   *   JSONObject={"API":"RU",
   *               "MDN":"9876543210"}
   *
   * Response:
   *    JSONObject={"API":true,
   *               "DB": // Unused till now
   *               "MSG":"Key Sent to Mobile No. 9876543210",
   *               "ET":2.0987,
   *               "ST":"Wed 20 Aug 08:31:23 PM"}
   *
   */
  protected function RU() {
    $DB               = new MySQLiDBHelper();
    $Data['MobileNo'] = $this->Req->MDN;
    $DB->where('MobileNo', $Data['MobileNo']);
    $Profile = $DB->query('Select UserName, Designation, eMailID FROM ' . MySQL_Pre . 'APP_Users');
    if (count($Profile) == 0) {
      $DB->insert(MySQL_Pre . 'APP_Users', $Data);
    }
    $AuthUser = new AuthOTP(1);
    $AuthUser->deleteUser($this->Req->MDN);
    $SecretKey = $AuthUser->setUser($this->Req->MDN, "HOTP");
    SMSGW::SendSMS('Activation Key: ' . $SecretKey, $this->Req->MDN);
    $this->Resp['MSG']     = "Please enter the Activation Key Sent to Mobile No. " . $this->Req->MDN;
    $this->Resp['API']     = true;
    $fieldData['MobileNo'] = $this->Req->MDN;
    $DB->insert(MySQL_Pre . 'APP_Register', $fieldData);
  }

  /**
   * OTP Test: Test User OTP against Registration Data
   * and if found valid update user credentials with new data
   *
   * Request:
   *   JSONObject={"API":"OT",
   *               "MDN":"9876543210",
   *               "OTP":"123456"}
   *
   * Response:
   *    JSONObject={"API":true,
   *               "DB": {'KeyUpdated':1,
   *                      "USER":{"UserName":"John Smith", TODO Send User Profile Data available at server.
   *                              "Designation":"Operator",
   *                              "eMailID":"jsmith@gmail.com"}
   *                      }
   *               "MSG":"Mobile No. 9876543210 is Registered Successfully.",
   *               "ET":2.0987,
   *               "ST":"Wed 20 Aug 08:31:23 PM"}
   */
  protected function OT() {
    $AuthUser = new AuthOTP(1);
    if ($AuthUser->authenticateUser($this->Req->MDN, $this->Req->OTP)) {
      $DB = new MySQLiDBHelper();

      $this->Resp['DB']['KeyUpdated'] = $DB->where('MobileNo', $this->Req->MDN)
        ->ddlQuery('Update ' . MySQL_Pre . 'SMS_Users Set UserData=TempData');

      $DB->where('MobileNo', $this->Req->MDN);
      $Profile                  = $DB->query('Select UserName, Designation, eMailID FROM ' . MySQL_Pre . 'SMS_Users');
      $this->Resp['DB']['USER'] = $Profile[0];

      $this->Resp['API'] = true;
      $this->Resp['MSG'] = 'Mobile No. ' . $this->Req->MDN . ' is Registered Successfully!'
        . ' Now you can start using NIC SMS Gateway for sending Group Messages.';
    } else {
      //$this->Resp['URL'] = $AuthUser->createURL($this->Req->MDN);
      $this->Resp['DB']  = "Key: Not For Production"; //. $AuthUser->oath_hotp($AuthUser->getKey($this->Req->MDN), $this->Req->TC);
      $this->Resp['API'] = false;
      $this->Resp['MSG'] = 'Invalid OTP';
    }
  }

  /**
   * Sync Profile: Sync User Profile from Registration Data on Server
   *
   * Request:
   *   JSONObject={"API":"SP",
   *               "MDN":"9876543210",
   *               "OTP":"123456"}
   *
   * Response:
   *    JSONObject={"API":true,
   *               "DB": {"UserName":"John Smith",
   *                      "Designation":"Operator",
   *                      "eMailID":"jsmith@gmail.com"
   *                     }
   *
   *               "MSG":"Profile Downloaded Successfully.",
   *               "ET":2.0987,
   *               "ST":"Wed 20 Aug 08:31:23 PM"}
   */
  protected function SP() {
    $AuthUser = new AuthOTP(1);
    if ($AuthUser->authenticateUser($this->Req->MDN, $this->Req->OTP)) {
      $DB = new MySQLiDBHelper();
      $DB->where('MobileNo', $this->Req->MDN);
      $Profile          = $DB->query('Select UserName, Designation, eMailID FROM ' . MySQL_Pre . 'SMS_Users');
      $this->Resp['DB'] = $Profile[0];

      $this->Resp['API'] = true;
      $this->Resp['MSG'] = 'Profile Downloaded Successfully.';
    } else {
      //$this->Resp['URL'] = $AuthUser->createURL($this->Req->MDN);
      $this->Resp['DB']  = "Key: Not For Production"; //. $AuthUser->oath_hotp($AuthUser->getKey($this->Req->MDN), $this->Req->TC);
      $this->Resp['API'] = false;
      $this->Resp['MSG'] = 'Invalid OTP';
    }
  }

}