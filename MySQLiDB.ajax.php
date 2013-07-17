<?php

/**
 * API For Ajax Calls from a valid authenticated session.
 *
 * The JSON Object will Contain Four Top Level Nodes
 * 1. $DataResp['AjaxToken'] => Token for preventing atacks like CSRF and Sesion Hijack
 * 2. $DataResp['Data']
 * 3. $DataResp['Mail']
 * 4. $DataResp['Msg']
 * 5. $DataResp['RT'] => Response Time of the Script
 *
 * * @example ($_POST=array(
 *              'CallAPI'=>'GetData',
 *              'AjaxToken'=>'$$$$')
 *
 * @return json
 *

 */
require_once('lib.inc.php');
require_once('class.MySQLiDBHelper.php');
require_once 'php-mailer/GMail.lib.php';
if (!isset($_SESSION))
  session_start();
$CSRF = TRUE; //(WebLib::GetVal($_POST, 'AjaxToken') === WebLib::GetVal($_SESSION, 'Token'));
if ((WebLib::CheckAuth() === 'Valid') && $CSRF) {
  $_SESSION['LifeTime'] = time();
  $_SESSION['RT'] = microtime(TRUE);
  $_SESSION['CheckAuth'] = 'Valid';
  $_SESSION['Token'] = md5($_SERVER['REMOTE_ADDR'] . session_id() . $_SESSION['ET']);
  $DataResp['AjaxToken'] = $_SESSION['Token'];
  $DataResp['Data'] = array();
  $DataResp['Mail'] = array();
  $DataResp['Msg'] = '';
  switch (WebLib::GetVal($_POST, 'CallAPI')) {
    case 'ChgPwd':
      ChangePassword($DataResp, WebLib::GetVal($_POST, 'OldPass'));
      break;
    case 'GetData':
      $Query = 'Select ' . WebLib::GetVal($_POST, 'Fields')
              . ' FROM `' . MySQL_Pre . WebLib::GetVal($_POST, 'TableName') . '`'
              . ' ' . WebLib::GetVal($_POST, 'Criteria');
      doQuery($DataResp, $Query, WebLib::GetVal($_POST, 'Params', FALSE, FALSE));
      break;
  }
  $DataResp['RT'] = '<b>Response Time:</b> '
          . round(microtime(TRUE) - WebLib::GetVal($_SESSION, 'RT'), 6) . ' Sec';
  $AjaxResp = json_encode($DataResp);
  unset($DataResp);

  header('Content-Type: application/json');
  header('Content-Length: ' . strlen($AjaxResp));
  echo $AjaxResp;
  exit();
}
header("HTTP/1.1 404 Not Found");
exit();

/**
 * Changes the password of current user
 * @todo Verify the Salting method
 * @param type $DataResp
 * @param string $OldPass Salted MD5 String as MD5(PassWord.MD5(Salt))
 */
function ChangePassword(&$DataResp, $OldPass) {
  $Pass = WebLib::GeneratePassword(10, 2, 2, 2);
  $UserMapID = $_SESSION['UserMapID'];
  $Data = new MySQLiDBHelper(HOST_Name, MySQL_User, MySQL_Pass, MySQL_DB);
  $Data->where('UserMapID', $UserMapID);
  $Data->where('UserPass', $OldPass);

  $Updated = $Data->update('`' . MySQL_Pre . 'Users`', array('UserPass' => md5($Pass)));
  if ($Updated) {
    $Data->where('UserMapID', $UserMapID);
    $Result = $Data->query('Select `UserName`,`UserID` FROM `' . MySQL_Pre . 'Users`');
    $Subject = 'Change User Passowrd - SRER 2014';
    $Body = '<span>Your new password for UserID: <b>'
            . $Result[0]['UserID'] . '</b> is <b>' . $Pass . '</b></span>';
    $Mail = json_decode(GMailSMTP($Result[0]['UserID'], $Result[0]['UserName'], $Subject, $Body));
    if ($Mail->Sent === TRUE) {
      $DataResp['Msg'] = 'Password Changed Successfully!';
    }
  } else {
    $DataResp['Msg'] = 'Unable to Change Password!';
  }
  unset($Result);
  unset($Data);
}

/**
 * Perfroms Select Query to the database
 *
 * @param ref     $DataResp
 * @param string  $Query
 * @param array   $Params
 * @example GetData(&$DataResp, "Select a,b,c from Table Where c=? Order By b LIMIT ?,?", array('1',30,10))
 */
function doQuery(&$DataResp, $Query, $Params) {
  $Data = new MySQLiDBHelper(HOST_Name, MySQL_User, MySQL_Pass, MySQL_DB);
  $Result = $Data->rawQuery($Query, $Params);
  $DataResp['Data'] = $Result;
  $DataResp['Msg'] = 'Total Rows: ' . count($Result);
  unset($Result);
  unset($Data);
}

?>
