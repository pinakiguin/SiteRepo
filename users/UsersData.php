<?php

/*
 * @ todo Fetch District AC and Parts Combo Data on seperate request via ajax
 * @todo Keep All District, AC, Parts available for parent users
 */

$DB = new MySQLiDBHelper();
$Inserted=0;
$RunQuery=true;
$_SESSION['action'] = 0;
$Query              = '';
if (WebLib::GetVal($_POST, 'FormToken') !== NULL) {
  if (WebLib::GetVal($_POST, 'FormToken') !==
      WebLib::GetVal($_SESSION, 'FormToken')) {
    $_SESSION['action'] = 1;
  } else {
    // Authenticated Inputs
    switch (WebLib::GetVal($_POST, 'CmdSubmit')) {
      case 'Create':
        if (strlen(WebLib::GetVal($_POST, 'UserName')) > 2) {
          $Query = 'Insert Into `' . MySQL_Pre . 'Users` '
              . '(`UserName`,`CtrlMapID`,`Registered`,`Activated`)'
              . ' Values(\'' . WebLib::GetVal($_POST, 'UserName', TRUE)
              . '\',' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE) . ',0,0)';
        } else {
          $Query           = '';
          $_SESSION['Msg'] = 'UserName must be at least 3 characters or more.';
        }
        break;

      case 'Impersonate':
        if (WebLib::GetVal($_POST, 'UserMapID') !== NULL) {
          if (WebLib::GetVal($_SESSION, 'ImpFromUserMapID') === NULL) {
            $_SESSION['ImpFromUserMapID'] = $_SESSION['UserMapID'];
            $_SESSION['ImpFromUserName']  = $_SESSION['UserName'];
          }
          $_SESSION['UserMapID']   = WebLib::GetVal($_POST, 'UserMapID');

          $User=$DB->where("UserMapID",$_SESSION['UserMapID'])->query('Select UserName '
                  . ' From `' . MySQL_Pre . 'Users`');
          $_SESSION['UserName']    = 'Impersonated-' . $User[0]['UserName'];
          $_SESSION['Msg']         = $_SESSION['UserName'];
          $_SESSION['ReloadMenus'] = true;
        } else {
          $_SESSION['Msg'] = 'Select the User to Impersonate!';
        }
        break;

      case 'Stop Impersonating':
        if (WebLib::GetVal($_SESSION, 'ImpFromUserMapID') !== NULL) {
          $_SESSION['UserMapID']   = $_SESSION['ImpFromUserMapID'];
          $_SESSION['UserName']    = $_SESSION['ImpFromUserName'];
          unset($_SESSION['ImpFromUserMapID']);
          unset($_SESSION['ImpFromUserName']);
          $_SESSION['ReloadMenus'] = true;
        }
        break;

      case 'Activate':
        $DB->where('Activated',0);
        $DB->where('CtrlMapID',WebLib::GetVal($_SESSION, 'UserMapID', TRUE));
        $DB->where('UserMapID',WebLib::GetVal($_POST, 'UserMapID'));
        $Inserted = $DB->update(MySQL_Pre . 'Users',array('Activated'=>1));

        $QueryUser = 'Select `UserName`,`UserID` '
            . ' FROM `' . MySQL_Pre . 'Users`';
        $DB->where('UserMapID',WebLib::GetVal($_POST, 'UserMapID'));
        $Rows      = $DB->query($QueryUser);
        $User=$Rows[0];
        unset($Rows);

        $Subject = 'User Account Activated';
        $Body    = '<span>Your UserID: <b>' . $User['UserID']
            . '</b> is now Activated</span>';

        $RunQuery=false;
        break;

      case 'De-Activate':
        $Query = 'Update `' . MySQL_Pre . 'Users` Set `Activated`=0'
            . ' Where `Activated`=1 AND `CtrlMapID`='
            . WebLib::GetVal($_SESSION, 'UserMapID', TRUE)
            . ' AND `UserMapID`=' . WebLib::GetVal($_POST, 'UserMapID');

        $QueryUser = 'Select CONCAT(`UserName`,\'|\',`UserID`) '
            . ' FROM `' . MySQL_Pre . 'Users`'
            . ' Where UserMapID=' . WebLib::GetVal($_POST, 'UserMapID');
        $User      = explode('|', $DB->do_max_query($QueryUser));

        $Subject = 'User Account De-Activated - SRER 2014';
        $Body    = '<span>Your UserID: <b>' . $User[1]
            . '</b> is now De-Activated</span>';
        break;

      case 'Un-Register':
        $Query = 'Update `' . MySQL_Pre . 'Users` '
            . ' Set `Registered`=0,`Activated`=0'
            . ' Where `Registered`=1 AND `CtrlMapID`='
            . WebLib::GetVal($_SESSION, 'UserMapID', TRUE)
            . ' AND `UserMapID`=' . WebLib::GetVal($_POST, 'UserMapID');

        $QueryUser = 'Select CONCAT(`UserName`,\'|\',`UserID`) '
            . ' FROM `' . MySQL_Pre . 'Users`'
            . ' Where UserMapID=' . WebLib::GetVal($_POST, 'UserMapID');
        $User      = explode('|', $DB->do_max_query($QueryUser));

        $Subject = 'User Account Un-Registered - SRER 2014';
        $Body    = '<span>Your UserID: <b>' . $User[1]
            . '</b> is now Un-Registered</span><br/>'
            . '<b>Please Register again to change EmailID and Password</b>';
        break;
    }
    if ($Query !== '') {
      if($RunQuery){
        $Inserted = $DB->ddlQuery($Query);
      }
      if ($Inserted > 0) {
        if (WebLib::GetVal($_POST, 'CmdSubmit') === 'Create') {
          $_SESSION['Msg'] = 'User Created Successfully!';
        } else if (WebLib::GetVal($User, 'UserID')) {
          $GmailResp = GMailSMTP($User['UserID'], $User['UserName'], $Subject, $Body);
          $Mail      = json_decode($GmailResp);
          if ($Mail->Sent) {
            if (WebLib::GetVal($_SESSION, 'Msg') === '') {
              $_SESSION['Msg'] = 'User '
                  . WebLib::GetVal($_POST, 'CmdSubmit') . 'd Successfully!';
            }
          } else {
            $_SESSION['Msg'] = 'Action completed Successfully!'
                . ' But Unable to Send eMail!';
          }
        }
      } else {
        $_SESSION['Msg'] = 'Unable to '
            . WebLib::GetVal($_POST, 'CmdSubmit') . '!';
      }
    }
  }
}
$_SESSION['FormToken'] = md5($_SERVER['REMOTE_ADDR']
    . session_id() . microtime());
unset($Mail);
unset($GmailResp);
unset($DB);
?>
