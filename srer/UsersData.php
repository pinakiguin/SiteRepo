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
    switch (WebLib::GetVal($_POST, 'CmdSubmit')) {
      /**
       * @todo User will be assigned a District only if user is Activated
       */
      case 'Assign Whole District':
        $Query = 'Update `' . MySQL_Pre . 'SRER_Districts` Set `UserMapID`=' . WebLib::GetVal($_POST, 'UserMapID')
                . ' Where `DistCode`=\'' . WebLib::GetVal($_POST, 'DistCode', TRUE) . '\'';
        $Updated = $Data->do_ins_query($Query);
        if ($Updated > 0) {
          $Query = 'Update `' . MySQL_Pre . 'SRER_ACs` Set `UserMapID`=' . WebLib::GetVal($_POST, 'UserMapID')
                  . ' Where `DistCode`=\'' . WebLib::GetVal($_POST, 'DistCode', TRUE) . '\'';
        }
        $User = explode('|', $Data->do_max_query('Select CONCAT(`UserName`,\'|\',`UserID`) FROM `' . MySQL_Pre . 'Users`'
                        . ' Where UserMapID=' . WebLib::GetVal($_POST, 'UserMapID')));
        $Subject = 'User Account Changed - SRER 2014';
        $Body = '<span>A New District is now assigned to Your UserID: <b>' . $User[1] . '</b></span><br/>'
                . '<b>Please Login to check it out.</b>';
        $_SESSION['Msg'] = 'Whole District Assigned Successfully!';
        break;

      /**
       * @todo User will be assigned an AC only if user is Activated
       */
      case 'Assign Whole AC':
        $Query = 'Update `' . MySQL_Pre . 'SRER_ACs` Set `UserMapID`=' . WebLib::GetVal($_POST, 'UserMapID')
                . ' Where `ACNo`=\'' . WebLib::GetVal($_POST, 'ACNo', TRUE) . '\'';
        $Updated = $Data->do_ins_query($Query);
        if ($Updated > 0) {
          $Query = 'Update `' . MySQL_Pre . 'SRER_PartMap` Set `UserMapID`=' . WebLib::GetVal($_POST, 'UserMapID')
                  . ' Where `ACNo`=\'' . WebLib::GetVal($_POST, 'ACNo', TRUE) . '\'';
        }
        $User = explode('|', $Data->do_max_query('Select CONCAT(`UserName`,\'|\',`UserID`) FROM `' . MySQL_Pre . 'Users`'
                        . ' Where UserMapID=' . WebLib::GetVal($_POST, 'UserMapID')));
        $Subject = 'User Account Changed - SRER 2014';
        $Body = '<span>A New Assembly Constituency is now assigned to Your UserID: <b>' . $User[1] . '</b></span><br/>'
                . '<b>Please Login to check it out.</b>';
        $_SESSION['Msg'] = 'Whole AC Assigned Successfully!';
        break;

      /**
       * @todo User will be assigned a Part only if user is Activated
       */
      case 'Assign Part':
        $Parts = implode(',', $_POST['PartID']);
        $Query = 'Update `' . MySQL_Pre . 'SRER_PartMap` Set `UserMapID`=' . WebLib::GetVal($_POST, 'UserMapID')
                . ' Where `PartID` IN(' . $Data->SqlSafe($Parts) . ');';
        $User = explode('|', $Data->do_max_query('Select CONCAT(`UserName`,\'|\',`UserID`) FROM `' . MySQL_Pre . 'Users`'
                        . ' Where UserMapID=' . WebLib::GetVal($_POST, 'UserMapID')));
        $Subject = 'User Account Changed - SRER 2014';
        $Body = '<span>New Part(s) is now assigned to Your UserID: <b>' . $User[1] . '</b></span><br/>'
                . '<b>Please Login to check it out.</b>';
        $_SESSION['Msg'] = 'Part Assigned Successfully!';
        break;
    }
    if ($Query !== '') {
      $Inserted = $Data->do_ins_query($Query);
      if ($Inserted > 0) {
        if (WebLib::GetVal($User, 1)) {
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
