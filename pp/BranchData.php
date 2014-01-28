<?php

$Data               = new MySQLiDBHelper();
$_SESSION['action'] = 0;
$Query              = '';
$CmdAction          = WebLib::GetVal($_POST, 'CmdSubmit');
$FormToken          = WebLib::GetVal($_POST, 'FormToken');

if (isset($_SESSION['PostData']) === false) {
  $_SESSION['PostData'] = array();
} else {
  $_SESSION['PostData'] = $_POST;
}

if ($FormToken !== NULL) {
  if ($FormToken !== WebLib::GetVal($_SESSION, 'FormToken')) {
    $_SESSION['action'] = 1;
  } else {
    switch ($CmdAction) {
      case 'Save':
        $Query    = MySQL_Pre . 'PP_Branches';
        $PostData = GetPostDataPP();
        if ($Query !== '') {
          $QueryExecuted = $Data->insert($Query, $PostData);
        }
        break;
    }
    if ($QueryExecuted === false) {
      $_SESSION['Msg'] = 'Unable to ' . $CmdAction . '!';
    } else {
      $_SESSION['Msg']      = 'Successfully ' . $CmdAction . 'd!';
      $_SESSION['PostData'] = array();
    }
  }
}
$_SESSION['FormToken'] = md5($_SERVER['REMOTE_ADDR'] . session_id() . microtime());
unset($PostData);
unset($Data);

function GetPostDataPP() {
  $DataPP['IFSC']       = WebLib::GetVal($_POST, 'IFSC');
  $DataPP['BankSL']     = WebLib::GetVal($_POST, 'BankSL');
  $DataPP['BranchName'] = WebLib::GetVal($_POST, 'BranchName');
  $DataPP['MICR']       = WebLib::GetVal($_SESSION, 'UserMapID');
  return $DataPP;
}

?>
