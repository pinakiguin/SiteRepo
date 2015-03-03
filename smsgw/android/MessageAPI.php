<?php
require_once(__DIR__ . '/../../android/AndroidAPI.php');
require_once(__DIR__ . '/Message.php');
require_once(__DIR__ . '/Group.php');
require_once(__DIR__ . '/Contact.php');
require_once(__DIR__ . '/User.php');

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
class MessageAPI extends AndroidAPI {

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
  protected function AG() {
    $this->Resp['DB']  = Group::getAllGroups();
    $this->Resp['API'] = true;
    $this->Resp['MSG'] = 'All Groups Loaded';
    //$this->Expiry=3600; // 60 Minutes
  }

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
  protected function SM() {
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
  }

}