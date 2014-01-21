<?php

$Data               = new MySQLiDBHelper();
$_SESSION['action'] = 0;
$Query              = '';
$CmdAction          = WebLib::GetVal($_POST, 'CmdSubmit');
$FormToken          = WebLib::GetVal($_POST, 'FormToken');

if (isset($_SESSION['PostData']) === false) {
  $_SESSION['PostData'] = array();
} else {
  $_SESSION['PostData'] = $_POST; //$DataPP;
}

if ($FormToken !== NULL) {
  if ($FormToken !== WebLib::GetVal($_SESSION, 'FormToken')) {
    $_SESSION['action'] = 1;
  } else {
    // Authenticated Inputs
    switch ($CmdAction) {
      case 'Save':
        $Query    = MySQL_Pre . 'PP_Personnel';
        $PostData = GetPostDataPP();

        if ($Query !== '') {
          $QueryExecuted = $Data->insert($Query, $PostData);
        }
        break;
      case 'Update':
        $Query    = MySQL_Pre . 'PP_Personnel';
        $PostData = GetPostDataPP();

        if ($Query !== '') {
          $QueryExecuted = $Data->where('EmpSL', WebLib::GetVal($_POST, 'EmpSL'))
              ->update($Query, $PostData);
        }
        break;

      case 'Delete':
        $Query = MySQL_Pre . 'PP_Personnel';

        if ($Query !== '') {
          $QueryExecuted = $Data->where('EmpSL', WebLib::GetVal($_POST, 'EmpSL'))
              ->delete($Query);
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
  $DataPP['EmpName']       = WebLib::GetVal($_POST, 'EmpName');
  $DataPP['OfficeSL']      = WebLib::GetVal($_POST, 'OfficeSL');
  $DataPP['DesgID']        = WebLib::GetVal($_POST, 'DesgID');
  $DataPP['DOB']           = WebLib::ToDBDate(WebLib::GetVal($_POST, 'DOB'));
  $DataPP['SexId']         = WebLib::GetVal($_POST, 'SexId');
  $DataPP['AcNo']          = WebLib::GetVal($_POST, 'AcNo');
  $DataPP['PartNo']        = WebLib::GetVal($_POST, 'PartNo');
  $DataPP['SLNo']          = WebLib::GetVal($_POST, 'SLNo');
  $DataPP['EPIC']          = WebLib::GetVal($_POST, 'EPIC');
  $DataPP['PayScale']      = WebLib::GetVal($_POST, 'PayScale');
  $DataPP['BasicPay']      = WebLib::GetVal($_POST, 'BasicPay');
  $DataPP['GradePay']      = WebLib::GetVal($_POST, 'GradePay');
  $DataPP['PostingID']     = WebLib::GetVal($_POST, 'PostingID');
  $DataPP['DistHome']      = WebLib::GetVal($_POST, 'DistHome');
  $DataPP['HistPosting']   = WebLib::GetVal($_POST, 'HistPosting');
  $DataPP['PreAddr1']      = WebLib::GetVal($_POST, 'PreAddr1');
  $DataPP['PreAddr2']      = WebLib::GetVal($_POST, 'PreAddr2');
  $DataPP['PerAddr1']      = WebLib::GetVal($_POST, 'PerAddr1');
  $DataPP['PerAddr2']      = WebLib::GetVal($_POST, 'PerAddr2');
  $DataPP['AcPreRes']      = WebLib::GetVal($_POST, 'AcPreRes');
  $DataPP['AcPerRes']      = WebLib::GetVal($_POST, 'AcPerRes');
  $DataPP['AcPosting']     = WebLib::GetVal($_POST, 'AcPosting');
  $DataPP['PcPreRes']      = WebLib::GetVal($_POST, 'PcPreRes');
  $DataPP['PcPerRes']      = WebLib::GetVal($_POST, 'PcPerRes');
  $DataPP['PcPosting']     = WebLib::GetVal($_POST, 'PcPosting');
  $DataPP['Qualification'] = WebLib::GetVal($_POST, 'Qualification');
  $DataPP['Language']      = WebLib::GetVal($_POST, 'Language');
  $DataPP['ResPhone']      = WebLib::GetVal($_POST, 'ResPhone');
  $DataPP['Mobile']        = WebLib::GetVal($_POST, 'Mobile');
  $DataPP['EMail']         = WebLib::GetVal($_POST, 'EMail');
  $DataPP['Remarks']       = WebLib::GetVal($_POST, 'Remarks');
  $DataPP['BankACNo']      = WebLib::GetVal($_POST, 'BankACNo');
  $DataPP['BankName']      = WebLib::GetVal($_POST, 'BankName');
  $DataPP['BranchName']    = WebLib::GetVal($_POST, 'BranchName');
  $DataPP['IFSC']          = WebLib::GetVal($_POST, 'IFSC');
  $DataPP['EDCPBIssued']   = WebLib::GetVal($_POST, 'EDCPBIssued');
  $DataPP['PBReturn']      = WebLib::GetVal($_POST, 'PBReturn');
  return $DataPP;
}

?>
