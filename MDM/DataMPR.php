<?php

ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once ( __DIR__ . '/../lib.inc.php');

$Data               = new MySQLiDBHelper();
$_SESSION['action'] = 0;
$Query              = '';
if (WebLib::GetVal($_POST, 'FormToken') !== NULL) {
  if (WebLib::GetVal($_POST, 'FormToken') !==
      WebLib::GetVal($_SESSION, 'FormToken')) {
    $_SESSION['action'] = 1;
  } else {

// Authenticated Inputs
    switch (WebLib::GetVal($_POST, 'CmdSubmit')) {
      case 'Create Department':
        $DataMDM['DeptName']    = WebLib::GetVal($_POST, 'DeptName');
        $DataMDM['HODName']     = WebLib::GetVal($_POST, 'HODName');
        $DataMDM['HODMobile']   = WebLib::GetVal($_POST, 'HODMobile');
        $DataMDM['HODEmail']    = WebLib::GetVal($_POST, 'HODEmail');
        $DataMDM['DeptNumber']  = WebLib::GetVal($_POST, 'DeptNumber');
        $DataMDM['Strength']    = WebLib::GetVal($_POST, 'Strength');
        $DataMDM['DeptAddress'] = WebLib::GetVal($_POST, 'DeptAddress');

        if (strlen($DataMDM['DeptName']) > 2) {
          $DataMDM['UserMapID'] = $_SESSION['UserMapID'];
          $Query                = MySQL_Pre . 'MDM_AddNew';
          $_SESSION['Msg']      = 'Department Created Successfully!';
        } else {
          $Query           = '';
          $_SESSION['Msg'] = 'Department Name must be at least 3 characters or more.';
        }
    }
  }
}
//$_SESSION['OldFormToken'] = $_SESSION['FormToken'];
$_SESSION['FormToken'] = md5($_SERVER['REMOTE_ADDR'] . session_id() . microtime());
unset($DataMDM);
unset($Data);

/**
 * Perfroms Select Query to the database
 *
 * @param ref     $DataResp
 * @param string  $Query
 * @param array   $Params
 * @example GetData(&$DataResp, "Select a,b,c from Table Where c=? Order By b LIMIT ?,?", array('1',30,10))
 */
function doQuery(&$DataResp,
                 $Query,
                 $Params = NULL) {
  $Data             = new MySQLiDBHelper();
  $Result           = $Data->rawQuery($Query, $Params);
  $DataResp['Data'] = $Result;
  $DataResp['Msg']  = 'Total Rows: ' . count($Result);
  unset($Result);
  unset($Data);
}

?>
