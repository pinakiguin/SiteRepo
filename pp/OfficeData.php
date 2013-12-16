<?php

/*
 * @ todo Fetch District AC and Parts Combo Data on seperate request via ajax
 * @todo Keep All District, AC, Parts available for parent users
 */

$Data = new MySQLiDB();
$_SESSION['action'] = 0;
$Query = '';
if (WebLib::GetVal($_POST, 'FormToken') !== NULL) {
  if (WebLib::GetVal($_POST, 'FormToken') !== WebLib::GetVal($_SESSION, 'FormToken')) {
    $_SESSION['action'] = 1;
  } else {
    // Authenticated Inputs
    switch (WebLib::GetVal($_POST, 'CmdAction')) {

      case 'Save':
        if (strlen(WebLib::GetVal($_POST, 'UserName')) > 2) {
          $Query = 'Insert Into `' . MySQL_Pre . 'PP_Offices` (`UserName`,`CtrlMapID`,`Registered`,`Activated`)'
                  . ' Values(\'' . WebLib::GetVal($_POST, 'UserName', TRUE) . '\',' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE) . ',0,0)';
        } else {
          $Query = '';
          $_SESSION['Msg'] = 'UserName must be at least 3 characters or more.';
        }
        break;

      case 'Update':
        $Query = 'Update `' . MySQL_Pre . 'PP_Offices` Set `Activated`=1'
                . ' Where `Activated`=0 AND `CtrlMapID`=' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE)
                . ' AND `UserMapID`=' . WebLib::GetVal($_POST, 'UserMapID');
        $User = explode('|', $Data->do_max_query('Select CONCAT(`UserName`,\'|\',`UserID`) FROM `' . MySQL_Pre . 'Users`'
                        . ' Where UserMapID=\'' . WebLib::GetVal($_POST, 'UserMapID') . '\''));
        $Subject = 'User Account Activated - SRER 2014';
        $Body = '<span>Your UserID: <b>' . $User[1] . '</b> is now Activated</span>';
        break;

      case 'Delete':
        $Query = 'Update `' . MySQL_Pre . 'PP_Offices` Set `Activated`=0'
                . ' Where `Activated`=1 AND `CtrlMapID`=' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE)
                . ' AND `UserMapID`=' . WebLib::GetVal($_POST, 'UserMapID');
        $User = explode('|', $User = $Data->do_max_query('Select CONCAT(`UserName`,\'|\',`UserID`) FROM `' . MySQL_Pre . 'Users`'
                . ' Where UserMapID=\'' . WebLib::GetVal($_POST, 'UserMapID') . '\''));
        $Subject = 'User Account De-Activated - SRER 2014';
        $Body = '<span>Your UserID: <b>' . $User[1] . '</b> is now De-Activated</span>';
        break;
    }
    if ($Query !== '') {
      $Inserted = $Data->do_ins_query($Query);
      if ($Inserted > 0) {
        if (WebLib::GetVal($_POST, 'CmdSubmit') === 'Save') {
          $_SESSION['Msg'] = 'Office Created Successfully!';
        } else if (WebLib::GetVal($User, 1)) {
          $GmailResp = GMailSMTP($User[1], $User[0], $Subject, $Body);
          $Mail = json_decode($GmailResp);
          if ($Mail->Sent) {
            if (WebLib::GetVal($_SESSION, 'Msg') === '') {
              $_SESSION['Msg'] = 'User ' . WebLib::GetVal($_POST, 'CmdSubmit') . 'd Successfully!';
            }
          } else {
            $_SESSION['Msg'] = 'Action completed Successfully! But Unable to Send eMail!';
          }
        }
      } else {
        $_SESSION['Msg'] = 'Unable to ' . WebLib::GetVal($_POST, 'CmdSubmit') . '!';
      }
    }
  }
}
$_SESSION['FormToken'] = md5($_SERVER['REMOTE_ADDR'] . session_id() . microtime());
$Data->do_close();
unset($Mail);
unset($GmailResp);
unset($Data);
?>
