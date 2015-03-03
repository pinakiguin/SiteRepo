<?php
require_once(__DIR__ . '/../../android/AuthOTP.php');
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
class MprAPI {
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
       *               "UID":"35"}
       *
       * Response:
       *    JSONObject={"API":true,
       *               "DB":[{"SN":"BRGF","ID":"1"},{"SN":"MPLADS","ID":"5"}],
       *               "MSG":"All Schemes Loaded",
       *               "ET":2.0987,
       *               "ST":"Wed 20 Aug 08:31:23 PM"}
       */
      case 'US':
          $DB = new MySQLiDBHelper();
          $DB->where('UserMapID', $this->Req->UID);
          $Schemes           = $DB->query('Select `SchemeName` as `SN`, `SchemeID` as `ID` FROM '
            . MySQL_Pre . 'MPR_ViewWorkerSchemes');
          $this->Resp['DB']  = $Schemes;
          $this->Resp['API'] = true;
          $this->Resp['MSG'] = 'All Schemes Loaded';
          //$this->setExpiry(3600);
          unset($DB);
          unset($Schemes);
        break;

      /**
       * User Works: Retrieve all the Works for the User for a particular Scheme
       *
       * Request:
       *   JSONObject={"API":"UW",
       *               "UID":"35",
       *               "SID":"5"}
       *
       * Response:
       *    JSONObject={"API":true,
       *               "DB":[{"SN":"BRGF","ID":"1"},{"SN":"MPLADS","ID":"5"}],
       *               "MSG":"All Schemes Loaded",
       *               "ET":2.0987,
       *               "ST":"Wed 20 Aug 08:31:23 PM"}
       */
      case 'UW':
        $DB = new MySQLiDBHelper();
        $DB->where('UserMapID', $this->Req->UID);
        $DB->where('SchemeID', $this->Req->SID);
        $UserWorks = $DB->get(MySQL_Pre . 'MPR_ViewUserWorks');
        $this->Resp['DB']  = $UserWorks;
        $this->Resp['API'] = true;
        $this->Resp['MSG'] = 'Total Works : ' . count($UserWorks);
        //$this->setExpiry(3600);
        unset($DB);
        unset($UserWorks);
        break;

      /**
       * Update Progress: Update Progress of Works for the User for a particular Work
       *
       * Request:
       *   JSONObject={"API":"UP",
       *               "UID":"35",
       *               "WID":"5",
       *               "EA":"35",
       *               "P":"10",
       *               "B":"10029792",
       *               "R":"Some Remarks"}
       *
       * Response:
       *    JSONObject={"API":true,
       *               "DB":298,
       *               "MSG":"Updated Successfully!",
       *               "ET":2.0987,
       *               "ST":"Wed 20 Aug 08:31:23 PM"}
       */
      case 'UP':
        $DB = new MySQLiDBHelper();
        //$DB->where('UserMapID', $this->Req->UID); TODO: Validate User against WorkID before updating
        //$DB->where('WorkID', $this->Req->WID); TODO: Authenticate User Before Update

        $tableData['WorkID'] = $this->Req->WID;
        $tableData['ExpenditureAmount'] = $this->Req->EA;
        $tableData['Progress'] = $this->Req->P;
        $tableData['Balance'] = $this->Req->B;
        $tableData['ReportDate'] = date("Y-m-d",time());
        $tableData['Remarks'] = $this->Req->R;
        $ProgressID = $DB->insert(MySQL_Pre . 'MPR_Progress', $tableData);

        $this->Resp['DB']  = $ProgressID;
        $this->Resp['API'] = true;
        $this->Resp['MSG'] = 'Updated Successfully!';
        //$this->setExpiry(3600);
        unset($DB);
        unset($tableData);
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
        $AuthUser = new AuthOTP();
        if ($AuthUser->authenticateUser($this->Req->MDN, $this->Req->OTP)) {
          $DB = new MySQLiDBHelper();
          $DB->where('MobileNo', $this->Req->MDN);
          $Profile          = $DB->query('Select UserMapID FROM ' . MySQL_Pre . 'Users');
          $this->Resp['DB'] = $Profile;

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