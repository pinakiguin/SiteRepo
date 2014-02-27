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
      case 'Add Data':
        $DataMDM['SubDivID']   = WebLib::GetVal($_POST, 'SubDivID');
        $DataMDM['BlockID']    = WebLib::GetVal($_POST, 'BlockID');
        $DataMDM['Schoolname'] = WebLib::GetVal($_POST, 'Schoolname');
        $DataMDM['TypeID']     = WebLib::GetVal($_POST, 'TypeID');
        if (strlen($DataMDM['Schoolname']) > 2) {
          $DataMDM['UserMapID'] = $_SESSION['UserMapID'];
          $Query                = MySQL_Pre . 'MDM_Newdata';
          $_SESSION['Msg']      = 'Registered Successfully!';
        } else {
          $Query           = '';
          $_SESSION['Msg'] = 'School Name must be at least 3 characters or more.';
        }
        if ($Query !== '') {
          $Inserted = $Data->insert($Query, $DataMDM);
          if ($Inserted === false) {
            $_SESSION['CheckVal'] = 'false';
            $_SESSION['Msg']      = 'Unable to '
                . WebLib::GetVal($_POST, 'CmdSubmit')
                . '! Inserted data already present';
          }
        }

        break;

      case 'Insert Data':
        $DataMDM['SchoolID']     = WebLib::GetVal($_POST, 'SchoolID');
        $DataMDM['TotalStudent'] = WebLib::GetVal($_POST, 'TotalStudent');
        $DataMDM['Meal']         = WebLib::GetVal($_POST, 'Meal');
        $DataMDM['ReportDate']   = WebLib::GetVal($_POST, 'ReportDate');

        if (($DataMDM['SchoolID']) > 0) {
          $DataMDM['UserMapID'] = $_SESSION['UserMapID'];
          $Query                = MySQL_Pre . 'MDM_MealData';
          $_SESSION['Msg']      = 'Inserted Successfully!';
        } else {
          $Query           = '';
          $_SESSION['Msg'] = 'Select School Name First.';
        }
        if ($Query !== '') {
          $Inserted = $Data->insert($Query, $DataMDM);
          if ($Inserted === false) {
            $_SESSION['CheckVal'] = 'false';
            $_SESSION['Msg']      = 'Unable to '
                . WebLib::GetVal($_POST, 'CmdSubmit')
                . '! Inserted data already present';
          }
        }

        break;

      case 'Save Data':
        $DataMDM['NameID']       = WebLib::GetVal($_POST, 'NameID');
        $DataMDM['Mobile']       = WebLib::GetVal($_POST, 'Mobile');
        $DataMDM['DesigID']      = WebLib::GetVal($_POST, 'DesigID');
        $DataMDM['TotalStudent'] = WebLib::GetVal($_POST, 'TotalStudent');
        $DataMDM['RegDate']      = WebLib::GetVal($_POST, 'RegDate');

        if (strlen($DataMDM['NameID']) > 2) {
          $DataMDM['UserMapID'] = $_SESSION['UserMapID'];
          $Query                = MySQL_Pre . 'MDM_Newdata';
          $_SESSION['Msg']      = 'Updated Successfully!';
        } else {
          $Query           = '';
          $_SESSION['Msg'] = 'Teacher Name must be at least 3 characters or more.';
        }
        if ($Query !== '') {
          $Updated = $Data
              ->where('SchoolID', WebLib::GetVal($_POST, 'SchoolID'))
              ->update($Query, $DataMDM);
          if ($Updated === false) {
            $_SESSION['Msg'] = 'Unable to '
                . WebLib::GetVal($_POST, 'CmdSubmit')
                . '! updated data already present';
          }
        }
        break;
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
