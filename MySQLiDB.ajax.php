<?php

require_once('lib.inc.php');
require_once('class.MySQLiDBHelper.php');
require_once 'php-mailer/GMail.lib.php';
if (!isset($_SESSION))
  session_start();
$_SESSION['ET'] = microtime(TRUE);
$_SESSION['Debug'] = WebLib::GetVal($_SESSION, 'Debug') . "InSession_AUTH";
$SessRet = WebLib::CheckAuth();
$_SESSION['CheckAuth'] = $SessRet;
if ($SessRet === "Valid") {
  $Data = new MySQLiDBHelper(HOST_Name, MySQL_User, MySQL_Pass, MySQL_DB);
  $Pass = WebLib::GeneratePassword(10, 2, 2, 2);
  $Data->where('UserMapID', $_SESSION['UserMapID']);
  $Updated = $Data->update('`' . MySQL_Pre . 'Users`', array('UserPass' => md5($Pass)));
  if ($Updated) {
    $Data->where('UserMapID', $_SESSION['UserMapID']);
    $User = $Data->query('Select `UserName`,`UserID` FROM `' . MySQL_Pre . 'Users`');
    $Subject = 'Change User Passowrd - SRER 2014';
    $Body = '<span>Your new password for UserID: <b>' . $User[0]['UserID'] . '</b> is <b>' . $Pass . '</b></span>';
    $Mail = json_decode(GMailSMTP($User[0]['UserID'], $User[0]['UserName'], $Subject, $Body));
    if ($Mail->Sent === TRUE) {
      echo "Password Changed Successfully;";
    }
  }
}
echo '<pre>';
print_r($Mail);
print_r($User);
echo '</pre>';
?>
