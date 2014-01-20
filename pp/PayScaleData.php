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
        $Query    = MySQL_Pre . 'PP_Scales';
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
  $DataPP['ScaleType'] = WebLib::GetVal($_POST, 'ScaleType');
  $DataPP['Scale']     = WebLib::GetVal($_POST, 'Scale');
  $DataPP['GradePay']  = WebLib::GetVal($_POST, 'GradePay');
  return $DataPP;
}

?>
