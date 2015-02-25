<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once(__DIR__ . '/../lib.inc.php');

$RT       = time();
$json     = file_get_contents('php://input');
$jsonData = json_decode($json);

$mAPI = new AndroidAPI($jsonData);
$mAPI->executeAPI();
exit();

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
class AndroidAPI {
  private $Req;
  private $Resp;
  private $Expiry;

  function __construct($jsonData) {
    $this->Resp['ET'] = time();
    $this->Req        = $jsonData;
    $this->Expiry     = null;
  }

  function __unset($name) {
    $this->sendResponse();
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
  public function setExpiry($Expiry) {
    $this->Expiry = $Expiry;
  }

  function __destruct() {
    $this->sendResponse();
  }

  public function executeAPI() {
    switch ($this->Req->API) {
      /**
       * User Schemes: Retrieve all the Schemes for the User
       *
       * Request:
       *   JSONObject={"API":"US",
       *               "MDN":"9876543210",
       *               "UID":"35",
       *               "OTP":"987654"}
       *
       * Response:
       *    JSONObject={"API":true,
       *               "DB":[{"GRP":"All BDOs"},{"GRP":"All SDOs"}],
       *               "MSG":"Total Groups: 2",
       *               "ET":2.0987,
       *               "ST":"Wed 20 Aug 08:31:23 PM"}
       */
      case 'US':
        $AuthUser = new AuthOTP();
        if ($AuthUser->authenticateUser($this->Req->MDN, $this->Req->OTP)) {
          $DB = new MySQLiDBHelper();
          $DB->where('UserMapID', $this->Req->UID);
          $Schemes           = $DB->get(MySQL_Pre . 'MPR_ViewWorkerSchemes');
          $this->Resp['DB']  = $Schemes;
          $this->Resp['API'] = true;
          $this->Resp['MSG'] = 'All Schemes Loaded';
          $this->setExpiry(3600);
          unset($DB);
          unset($Schemes);
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
       *               "DB": {"UserMapID":"35"},
       *               "MSG":"Profile Downloaded Successfully.",
       *               "ET":2.0987,
       *               "ST":"Wed 20 Aug 08:31:23 PM"}
       */
      case 'SP':
        $AuthUser = new AuthOTP(1);
        if ($AuthUser->authenticateUser($this->Req->MDN, $this->Req->OTP)) {
          $DB = new MySQLiDBHelper();
          $DB->where('MobileNo', $this->Req->MDN);
          $Profile          = $DB->query('Select UserMapID FROM ' . MySQL_Pre . 'Users');
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
    header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', $this->getExpiry()));
    echo $JsonResp;
  }

}