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
      case 'Save':
        $DataPP['DeptName'] = WebLib::GetVal($_POST, 'DeptName', true);
        if (strlen($DataPP['DeptName']) > 2) {
          $DataPP['UserMapID'] = $_SESSION['UserMapID'];
          
          $Query = MySQL_Pre . 'PP_Personnel';
          $_SESSION['Msg'] = 'Department Created Successfully!';
        } else {
          $Query = '';
          $_SESSION['Msg'] = 'Department Name must be at least 3 characters or more.';
        }
        break;
    }
    if ($Query !== '') {
      $Inserted = $Data->insert($Query, $DataPP);
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
