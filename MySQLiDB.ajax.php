<?php

/**
 * API For Ajax Calls from a valid authenticated session.
 * @example ($_POST['CallAPI']='GetData';$_POST['AjaxToken']='$$$$';
 * $_POST['TableName']='SRER_PartMap';$_POST['numRows']=10;)
 *
 * @return json
 *
 * The JSON Object will Contain Four Top Level Nodes
 * 1. $DataResp['AjaxToken']
 * 2. $DataResp['Data']
 * 3. $DataResp['Mail']
 * 4. $DataResp['Msg']
 */
require_once('lib.inc.php');
require_once('class.MySQLiDBHelper.php');
require_once 'php-mailer/GMail.lib.php';
if (!isset($_SESSION))
  session_start();
$CSRF = TRUE; //(WebLib::GetVal($_POST, 'AjaxToken') === WebLib::GetVal($_SESSION, 'Token'));
if ((WebLib::CheckAuth() === 'Valid') && $CSRF) {
  $_SESSION['LifeTime'] = time();
  $_SESSION['ET'] = microtime(TRUE);
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
      GetData($DataResp, WebLib::GetVal($_POST, 'TableName'), WebLib::GetVal($_POST, 'numRows'));
      break;
  }
  $AjaxResp = json_encode($DataResp);
  unset($DataResp);

  header('Content-Type: application/json');
  header('Content-Length: ' . strlen($AjaxResp));
  echo $AjaxResp;
  exit();
}
header("HTTP/1.1 404 Not Found");

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

function GetData(&$DataResp, $TableName, $numRows = 10) {
  $Data = new MySQLiDBHelper(HOST_Name, MySQL_User, MySQL_Pass, MySQL_DB);
  $Data->where('PartMapID', $_SESSION['UserMapID']);
  $Result = $Data->query('Select `PartNo`,`PartName` FROM `'
          . MySQL_Pre . $TableName . '`', $numRows);
  $DataResp['Data'] = $Result;
  $DataResp['Msg'] = 'Total Rows: ' . count($Result);
  unset($Result);
  unset($Data);
}
?>
