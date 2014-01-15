<?php

$Data               = new MySQLiDBHelper();
$_SESSION['action'] = 0;
$Query              = '';
$CmdAction          = WebLib::GetVal($_POST, 'CmdSubmit');
$FormToken          = WebLib::GetVal($_POST, 'FormToken');

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
          $Inserted = $Data->insert($Query, $PostData);
          if ($Inserted === false) {
            $_SESSION['Msg'] = 'Unable to ' . $CmdAction . '!';
          }
        }
        break;
      case 'Update':
        $Query    = MySQL_Pre . 'PP_Personnel';
        $PostData = GetPostDataPP();

        if ($Query !== '') {
          $Updated = $Data->where('PerSL', WebLib::GetVal($_POST, 'PerSL'))
              ->update($Query, $PostData);
          if ($Updated === false) {
            $_SESSION['Msg'] = 'Unable to ' . $CmdAction . '!';
          }
        }
        break;
      case 'Delete':
        $Query = MySQL_Pre . 'PP_Personnel';

        if ($Query !== '') {
          $Deleted = $Data->where('PerSL', WebLib::GetVal($_POST, 'PerSL'))
              ->delete($Query);
          if ($Deleted === false) {
            $_SESSION['Msg'] = 'Unable to ' . $CmdAction . '!';
          }
        }
        break;
    }
  }
}
$_SESSION['FormToken'] = md5($_SERVER['REMOTE_ADDR'] . session_id() . microtime());
unset($PostData);
unset($Data);

function GetPostDataPP() {
  $DataPP['EmpName']       = WebLib::GetVal($_POST, 'NameID');
  $DataPP['Desg']          = WebLib::GetVal($_POST, 'DesigID');
  $DataPP['Dob']           = WebLib::GetVal($_POST, 'DOB');
  $DataPP['Sex']           = WebLib::GetVal($_POST, 'SexID');
  $DataPP['ACNo']          = WebLib::GetVal($_POST, 'AcNo');
  $DataPP['PartNo']        = WebLib::GetVal($_POST, 'PartNo');
  $DataPP['SlNo']          = WebLib::GetVal($_POST, 'SLNo');
  $DataPP['EPICNo']        = WebLib::GetVal($_POST, 'EPIC');
  $DataPP['ScaleOfPay']    = WebLib::GetVal($_POST, 'PayScale');
  $DataPP['BasicPay']      = WebLib::GetVal($_POST, 'BasicPay');
  $DataPP['GradePay']      = WebLib::GetVal($_POST, 'GradePay');
  $DataPP['Posting']       = WebLib::GetVal($_POST, 'Posting');
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
  $DataPP['Phone']         = WebLib::GetVal($_POST, 'Phone');
  $DataPP['Mobile']        = WebLib::GetVal($_POST, 'Mobile');
  $DataPP['EMail']         = WebLib::GetVal($_POST, 'EMail');
  $DataPP['Remarks']       = WebLib::GetVal($_POST, 'Remarks');
  $DataPP['BankACNo']      = WebLib::GetVal($_POST, 'BankACNo');
  $DataPP['BankName']      = WebLib::GetVal($_POST, 'BankName');
  $DataPP['BranchName']    = WebLib::GetVal($_POST, 'BranchName');
  $DataPP['IFSCCode']      = WebLib::GetVal($_POST, 'IFSCCode');
  $DataPP['EDCPBIssued']   = WebLib::GetVal($_POST, 'EDCPBIssued');
  $DataPP['PBReturn']      = WebLib::GetVal($_POST, 'PBReturn');
  return $DataPP;
}
?>