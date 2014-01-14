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
      case 'Submit':
        $Query = MySQL_Pre . 'PP_Personnel';

        $DataPP['EmpName'] = WebLib::GetVal($_POST, 'NameID', true);
        $DataPP['Desg'] = WebLib::GetVal($_POST, 'DesigID', true);
        $DataPP['Dob'] = WebLib::GetVal($_POST, 'DOB', true);
        $DataPP['Sex'] = WebLib::GetVal($_POST, 'SexID', true);
        $DataPP['ACNo'] = WebLib::GetVal($_POST, 'AcNo', true);
        $DataPP['PartNo'] = WebLib::GetVal($_POST, 'PartNo', true);
        $DataPP['SlNo'] = WebLib::GetVal($_POST, 'SLNo', true);
        $DataPP['EPICNo'] = WebLib::GetVal($_POST, 'EPIC', true);
        $DataPP['ScaleOfPay'] = WebLib::GetVal($_POST, 'PayScale', true);
        $DataPP['BasicPay'] = WebLib::GetVal($_POST, 'BasicPay', true);
        $DataPP['GradePay'] = WebLib::GetVal($_POST, 'GradePay', true);
        $DataPP['Posting'] = WebLib::GetVal($_POST, 'Posting', true);
        $DataPP['PreAddr1'] = WebLib::GetVal($_POST, 'PreAddr1', true);
        $DataPP['PreAddr2'] = WebLib::GetVal($_POST, 'PreAddr2', true);
        $DataPP['PerAddr1'] = WebLib::GetVal($_POST, 'PerAddr1', true);
        $DataPP['PerAddr2'] = WebLib::GetVal($_POST, 'PerAddr2', true);
        $DataPP['AcPreRes'] = WebLib::GetVal($_POST, 'AcPreRes', true);
        $DataPP['AcPerRes'] = WebLib::GetVal($_POST, 'AcPerRes', true);
        $DataPP['AcPosting'] = WebLib::GetVal($_POST, 'AcPosting', true);
        $DataPP['PcPreRes'] = WebLib::GetVal($_POST, 'PcPreRes', true);
        $DataPP['PcPerRes'] = WebLib::GetVal($_POST, 'PcPerRes', true);
        $DataPP['PcPosting'] = WebLib::GetVal($_POST, 'PcPosting', true);
        $DataPP['Qualification'] = WebLib::GetVal($_POST, 'Qualification', true);
        $DataPP['Language'] = WebLib::GetVal($_POST, 'Language', true);
        $DataPP['Phone'] = WebLib::GetVal($_POST, 'Phone', true);
        $DataPP['Mobile'] = WebLib::GetVal($_POST, 'Mobile', true);
        $DataPP['EMail'] = WebLib::GetVal($_POST, 'EMail', true);
        $DataPP['Remarks'] = WebLib::GetVal($_POST, 'Remarks', true);
        $DataPP['BankACNo'] = WebLib::GetVal($_POST, 'BankACNo', true);
        $DataPP['BankName'] = WebLib::GetVal($_POST, 'BankName', true);
        $DataPP['BranchName'] = WebLib::GetVal($_POST, 'BranchName', true);
        $DataPP['IFSCCode'] = WebLib::GetVal($_POST, 'IFSCCode', true);
        $DataPP['EDCPBIssued'] = WebLib::GetVal($_POST, 'EDCPBIssued', true);
        $DataPP['PBReturn'] = WebLib::GetVal($_POST, 'PBReturn', true);
        $_SESSION['Msg'] = 'Query: ' . $Query;

        if ($Query !== '') {
          $Inserted = $Data->insert($Query, $DataPP);
          if ($Inserted === false) {
            $_SESSION['Msg'] = 'Unable to ' . WebLib::GetVal($_POST, 'CmdSubmit') . '!';
          }
        }

        break;
        switch (WebLib::GetVal($_POST, 'CmdDelete')) {
          case 'Delete':
            $Query = MySQL_Pre . 'PP_Personnel';

            $_SESSION['Msg'] = 'Query: ' . $Query;
            if ($Query !== '') {
              $Data->where('PerSL', WebLib::GetVal($_POST, 'PerSL', true));
              $Deleted = $Data->delete($Query, $DataPP);
              if ($Inserted === false) {
                $_SESSION['Msg'] = 'Unable to ' . WebLib::GetVal($_POST, 'CmdDelete') . '!';
              }
            }
            break;
        }
        switch (WebLib::GetVal($_POST, 'CmdEdit')) {
          case 'Edit':
            $Query = MySQL_Pre . 'PP_Personnel';

            $DataPP['EmpName'] = WebLib::GetVal($_POST, 'NameID', true);
            $DataPP['Desg'] = WebLib::GetVal($_POST, 'DesigID', true);
            $DataPP['Dob'] = WebLib::GetVal($_POST, 'DOB', true);
            $DataPP['Sex'] = WebLib::GetVal($_POST, 'SexID', true);
            $DataPP['ACNo'] = WebLib::GetVal($_POST, 'AcNo', true);
            $DataPP['PartNo'] = WebLib::GetVal($_POST, 'PartNo', true);
            $DataPP['SlNo'] = WebLib::GetVal($_POST, 'SLNo', true);
            $DataPP['EPICNo'] = WebLib::GetVal($_POST, 'EPIC', true);
            $DataPP['ScaleOfPay'] = WebLib::GetVal($_POST, 'PayScale', true);
            $DataPP['BasicPay'] = WebLib::GetVal($_POST, 'BasicPay', true);
            $DataPP['GradePay'] = WebLib::GetVal($_POST, 'GradePay', true);
            $DataPP['Posting'] = WebLib::GetVal($_POST, 'Posting', true);
            $DataPP['PreAddr1'] = WebLib::GetVal($_POST, 'PreAddr1', true);
            $DataPP['PreAddr2'] = WebLib::GetVal($_POST, 'PreAddr2', true);
            $DataPP['PerAddr1'] = WebLib::GetVal($_POST, 'PerAddr1', true);
            $DataPP['PerAddr2'] = WebLib::GetVal($_POST, 'PerAddr2', true);
            $DataPP['AcPreRes'] = WebLib::GetVal($_POST, 'AcPreRes', true);
            $DataPP['AcPerRes'] = WebLib::GetVal($_POST, 'AcPerRes', true);
            $DataPP['AcPosting'] = WebLib::GetVal($_POST, 'AcPosting', true);
            $DataPP['PcPreRes'] = WebLib::GetVal($_POST, 'PcPreRes', true);
            $DataPP['PcPerRes'] = WebLib::GetVal($_POST, 'PcPerRes', true);
            $DataPP['PcPosting'] = WebLib::GetVal($_POST, 'PcPosting', true);
            $DataPP['Qualification'] = WebLib::GetVal($_POST, 'Qualification', true);
            $DataPP['Language'] = WebLib::GetVal($_POST, 'Language', true);
            $DataPP['Phone'] = WebLib::GetVal($_POST, 'Phone', true);
            $DataPP['Mobile'] = WebLib::GetVal($_POST, 'Mobile', true);
            $DataPP['EMail'] = WebLib::GetVal($_POST, 'EMail', true);
            $DataPP['Remarks'] = WebLib::GetVal($_POST, 'Remarks', true);
            $DataPP['BankACNo'] = WebLib::GetVal($_POST, 'BankACNo', true);
            $DataPP['BankName'] = WebLib::GetVal($_POST, 'BankName', true);
            $DataPP['BranchName'] = WebLib::GetVal($_POST, 'BranchName', true);
            $DataPP['IFSCCode'] = WebLib::GetVal($_POST, 'IFSCCode', true);
            $DataPP['EDCPBIssued'] = WebLib::GetVal($_POST, 'EDCPBIssued', true);
            $DataPP['PBReturn'] = WebLib::GetVal($_POST, 'PBReturn', true);

            $_SESSION['Msg'] = 'Query: ' . $Query;
            if ($Query !== '') {
              $Updated = $Data->update($Query, $DataPP);
              if ($Inserted === false) {
                $_SESSION['Msg'] = 'Unable to ' . WebLib::GetVal($_POST, 'CmdEditt') . '!';
              }
            }
            break;
        }
    }
  }
}
$_SESSION['FormToken'] = md5($_SERVER['REMOTE_ADDR'] . session_id() . microtime());
unset($DataPP);
unset($Data);
?>