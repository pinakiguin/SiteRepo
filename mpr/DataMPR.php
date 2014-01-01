<?php

$Data = new MySQLiDBHelper();
$_SESSION['action'] = 0;
$Query = '';
if (WebLib::GetVal($_POST, 'FormToken') !== NULL) {
  if (WebLib::GetVal($_POST, 'FormToken') !== WebLib::GetVal($_SESSION, 'FormToken')) {
    $_SESSION['action'] = 1;
  } else {
    // Authenticated Inputs
    switch (WebLib::GetVal($_POST, 'CmdSubmit')) {
      case 'Create Department':
        $DataMPR['DeptName'] = WebLib::GetVal($_POST, 'DeptName', true);
        if (strlen($DataMPR['DeptName']) > 2) {
          $DataMPR['UserMapID'] = $_SESSION['UserMapID'];
          $Query = MySQL_Pre . 'MPR_Departments';
          $_SESSION['Msg'] = 'Department Created Successfully!';
        } else {
          $Query = '';
          $_SESSION['Msg'] = 'Department Name must be at least 3 characters or more.';
        }
        break;
      case 'Create Sector':
        $DataMPR['SectorName'] = WebLib::GetVal($_POST, 'SectorName');
        if (strlen($DataMPR['SectorName']) > 2) {
          $DataMPR['UserMapID'] = $_SESSION['UserMapID'];
          $Query = MySQL_Pre . 'MPR_Sectors';
          $_SESSION['Msg'] = 'Sector Created Successfully!';
        } else {
          $Query = '';
          $_SESSION['Msg'] = 'Sector Name must be at least 3 characters or more.';
        }
        break;
      case 'Create Scheme':
        $DataMPR['SchemeName'] = WebLib::GetVal($_POST, 'SchemeName');
        $DataMPR['DeptID'] = WebLib::GetVal($_POST, 'DeptID');
        $DataMPR['SectorID'] = WebLib::GetVal($_POST, 'SectorID');
        if ((strlen($DataMPR['SchemeName']) > 2) && ($DataMPR['DeptID'] !== null) && ($DataMPR['SectorID'] !== null)) {
          $DataMPR['UserMapID'] = $_SESSION['UserMapID'];
          $Query = MySQL_Pre . 'MPR_Schemes';
          $_SESSION['Msg'] = 'Scheme Created Successfully!';
        } else {
          $Query = '';
          $_SESSION['Msg'] = 'Scheme Name must be at least 3 characters or more.';
        }
        break;
    }
    if ($Query !== '') {
      $Inserted = $Data->insert($Query, $DataMPR);
      if ($Inserted === false) {
        $_SESSION['Msg'] = 'Unable to ' . WebLib::GetVal($_POST, 'CmdSubmit') . '!';
      }
    }
  }
}
$_SESSION['FormToken'] = md5($_SERVER['REMOTE_ADDR'] . session_id() . microtime());
unset($DataMPR);
unset($Data);
?>
