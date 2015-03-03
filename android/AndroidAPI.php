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
  private $Req;
  private $Resp;
  private $Expiry;

  function __construct($jsonData) {
    $this->Resp['ET'] = time();
    $this->Expiry     = null;
    $this->Req        = $jsonData;
  }

  function __unset($name) {
    $this->sendResponse();
  }

  function __destruct() {
    $this->sendResponse();
  }

  public function executeAPI() {
    switch ($this->Req->API) {
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
      case 'RU':
        $DB = new MySQLiDBHelper();
        $Data['MobileNo']=$this->Req->MDN;
        $DB->where('MobileNo', $Data['MobileNo']);
        $Profile = $DB->query('Select UserName, Designation, eMailID FROM ' . MySQL_Pre . 'APP_Users');
        if (count($Profile) == 0) {
          $DB->insert(MySQL_Pre . 'APP_Users',$Data);
        }
        $AuthUser = new AuthOTP(1);
        $AuthUser->deleteUser($this->Req->MDN);
        $SecretKey = $AuthUser->setUser($this->Req->MDN, "HOTP");
        SMSGW::SendSMS('Activation Key: ' . $SecretKey, $this->Req->MDN);
        $this->Resp['MSG'] = "Please enter the Activation Key Sent to Mobile No. " . $this->Req->MDN;
        $this->Resp['API'] = true;
        $fieldData['MobileNo'] = $this->Req->MDN;
        $DB->insert(MySQL_Pre . 'APP_Register', $fieldData);
        break;

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
      case 'OT':
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
        break;

      /**
       * All Groups: Retrieve All Groups
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
       */
      case 'AG':
        $this->Resp['DB']  = Group::getAllGroups();
        $this->Resp['API'] = true;
        $this->Resp['MSG'] = 'All Groups Loaded';
        //$this->Expiry=3600; // 60 Minutes
        break;

      /**
       * Send SMS To a Group.
       *
       * Request:
       *   JSONObject={"API":"SM",
       *               "MDN":"9876543210",
       *               "TXT":"Hello",
       *               "GRP":"BDO"}
       *
       * Response:
       *   JSONObject={"API":true,
       *               "DB":"Return Message ID".
       *               "MSG":"Message Sent",
       *               "ET":2.0987,
       *               "ST":"Wed 20 Aug 08:31:23 PM"}
       */
      case 'SM':
        $AuthUser = new AuthOTP();
        if ($AuthUser->authenticateUser($this->Req->MDN, $this->Req->OTP)) {
          $Msg               = new Message();
          $User              = new User($this->Req->MDN);
          $Mid               = $Msg->createSMS($User, $this->Req->TXT, $this->Req->GRP);
          $Contact           = new Contact();
          $count             = $Contact->CountContactByGroup($this->Req->GRP);
          $this->Resp['DB']  = $Mid;
          $this->Resp['API'] = true;
          $this->Resp['MSG'] = 'Message Sent to ' . $count
            . ' Contacts of ' . $this->Req->GRP . ' Group';
        } else {
          $this->Resp['API'] = false;
          $this->Resp['MSG'] = 'Invalid OTP ' . $this->Req->OTP;
        }
        break;

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
      case 'SP':
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
        break;

      /**
       * Unknown API Call
       */
      default :
        $this->Resp['API'] = false;
        $this->Resp['MSG'] = 'Invalid API';
        break;
    }
  }

  protected function sendResponse() {
    //$this->Resp['json'] = $this->Req; //TODO: Remove for Production
    $this->Resp['ET'] = time() - $this->Resp['ET'];
    $DateFormat       = 'D d M g:i:s A';
    $this->Resp['ST'] = date($DateFormat, time());

    $JsonResp = json_encode($this->Resp);

    header('Content-Type: application/json');
    header('Content-Length: ' . strlen($JsonResp));
    /**
     * Important: Tells volley not to cache the response
     */
    if ($this->Expiry == null) {
      $Expires = time() - 3600;
    } else {
      $Expires = time() + $this->Expiry;
    }
    header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', $Expires));
    echo $JsonResp;
  }

}