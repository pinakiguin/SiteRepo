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
require_once(__DIR__ . '/Message.php');
require_once(__DIR__ . '/Group.php');
require_once(__DIR__ . '/Contact.php');
require_once(__DIR__ . '/../smsgw/smsgw.inc.php');

class MessageAPI {
  private $Req;
  private $Resp;

  function __construct($jsonData) {
    $this->Resp['ET']=time();
    $this->Req=$jsonData;
  }

  function __unset($name) {
    $this->sendResponse();
  }

  function __destruct() {
    $this->sendResponse();
  }

  public function executeAPI(){
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
       *               "DB": TODO Send User Profile Data available at server.
       *               "MSG":"Key Sent to Mobile No. 9876543210",
       *               "ET":2.0987,
       *               "ST":"Wed 20 Aug 08:31:23 PM"}
       *
       */
      case 'RU':
        $DB=new MySQLiDBHelper();
        $DB->where('MobileNo',$this->Req->MDN);
        $Profile=$DB->query('Select UserName, Designation, eMailID, MobileNo FROM '.MySQL_Pre.'SMS_Users');
        if(count($Profile)>0){
          $AuthUser = new AuthOTP(1);
          $AuthUser->deleteUser($this->Req->MDN);
          $SecretKey = $AuthUser->setUser($this->Req->MDN);
          SMSGW::SendSMS('Activation Key: '.$SecretKey,$this->Req->MDN);
          $this->Resp['MSG']="Please enter the Activation Key Sent to Mobile No. ".$this->Req->MDN;
          $this->Resp['API']=true;
          $this->Resp['DB']=$Profile[0];
        } else {
          $this->Resp['API']=false;
          $this->Resp['MSG']='Mobile No.'.$this->Req->MDN.' is not allowed to register!';
        }
        break;

      /**
       * OTP Test: Test User OTP against Registration Data
       * and if found valid update user credentials with new data
       *
       * Request:
       *   JSONObject={"API":"RU",
       *               "MDN":"9876543210"}
       *
       * Response:
       *    JSONObject={"API":true,
       *               "DB": TODO Send User Profile Data available at server.
       *               "MSG":"Key Sent to Mobile No. 9876543210",
       *               "ET":2.0987,
       *               "ST":"Wed 20 Aug 08:31:23 PM"}
       */
      case 'OT':
        $AuthUser = new AuthOTP(1);
        if($AuthUser->authenticateUser($this->Req->MDN,$this->Req->OTP)){
          $DB=new MySQLiDBHelper();
          $DB->where('MobileNo',$this->Req->MDN);
          $this->Resp['DB']=$DB->query('Update '.MySQL_Pre.'SMS_Users Set UserData=TempData');
          $this->Resp['API']=true;
          $this->Resp['MSG']='Registered Successfully!';
        }else{
          $this->Resp['API']=false;
          $this->Resp['MSG']='Invalid OTP';
        }
        break;

      /**
       * All Groups: Retrieve All Groups
       */
      case 'AG':
        $AuthUser = new AuthOTP();
        if($AuthUser->authenticateUser($this->Req->MDN,$this->Req->OTP)){
          $DB=new MySQLiDBHelper();
          $DB->where('MobileNo',$this->Req->MDN);
          $this->Resp['DB']=$DB->query('Select GroupName FROM '.MySQL_Pre.'SMS_Groups');
          $this->Resp['API']=true;
          $this->Resp['MSG']='All Groups Loaded';
        }else{
          $this->Resp['API']=false;
          $this->Resp['MSG']='Invalid OTP';
        }
        break;

      /**
       * Unknown API Call
       */
      default :
        $Resp['API'] = false;
        $Resp['MSG'] = 'Invalid API';
        break;
    }
  }

  protected function sendResponse(){
    $this->Resp['json']=$this->Req; //TODO: Remove for Production
    $this->Resp['ET'] = time() - $this->Resp['ET'];
    $DateFormat = 'D d M g:i:s A';
    $this->Resp['ST'] = date($DateFormat, time());

    $JsonResp = json_encode($this->Resp);

    header('Content-Type: application/json');
    header('Content-Length: ' . strlen($JsonResp));
    echo $JsonResp;
  }

}