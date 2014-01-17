<?php

session_start();
require_once __DIR__ . '/../lib.inc.php';
if (WebLib::GetVal($_SESSION, 'CheckAuth') === 'Valid') {

  $Data = new MySQLiDBHelper();

//  $Query = 'SELECT `OfficeSL`, `OfficeName` FROM `' . MySQL_Pre . 'PP_Offices` '
//    . ' Where `UserMapID`=? Order by `OfficeName`';
//  $DataResp['Offices'] = $Data->rawQuery($Query, array($_SESSION['UserMapID']));
  $Query = 'SELECT `OfficeSL`, `OfficeName` '
      . ' FROM `' . MySQL_Pre . 'PP_Offices` '
      . ' Where `UserMapID`=?'
      . ' Order by `OfficeSL`';

  $DataResp['OfficeSL'] = $Data->rawQuery($Query, array($_SESSION['UserMapID']));

  $Query = 'SELECT `ScaleCode`, `Scale`,`GradePay` FROM `'
      . MySQL_Pre . 'PP_PayScales` '
      . 'Order by `ScaleCode`';

  $DataResp['Scales'] = $Data->rawQuery($Query);

  $Query = 'SELECT `BankSL`, `BankName` '
      . ' FROM `' . MySQL_Pre . 'PP_Banks` '
      . ' Order by `BankName`';

  $DataResp['BankName'] = $Data->rawQuery($Query);

  $Query                  = 'SELECT `BranchSL`,`BankSL`,`BranchName`,`IFSC`'
      . ' FROM `' . MySQL_Pre . 'PP_Branches`'
      . ' Order by `BranchName`';
  $DataResp['BranchName'] = $Data->rawQuery($Query);

//  $Query               = 'SELECT `EmpName`'
//      . ' FROM `' . MySQL_Pre . 'PP_Personnel` '
//      . ' Where `UserMapID`=?'
//      . ' Order by `EmpName`';
//  $DataResp['EmpName'] = $Data->rawQuery($Query, array($_SESSION['UserMapID']));
////  $Query               = 'SELECT `PerSL`,`PerCode`,`EmpName`,`DesgID`,`Dob`,`Sex`,
//    `ACNo`,`PartNo`,`SlNo`,`EPICNo`,`ScaleOfPay`,`BasicPay`,`GradePay`,`Posting`,`HistPosting`,
//    `DistHome`,`PreAddr1`,`PreAddr2`,`PerAddr1`,`PerAddr2`,`AcPreRes`,`AcPerRes`,`AcPosting`,`PcPreRes`,`PcPerRes`,`PcPosting`,`Qualification`,`Language`,`Phone`,`Mobile`,`EMail`,`Remarks`,
//    `BankACNo`,`BankName`,`BranchName`,`IFSCCode`,`EDCPBIssued`,`PBReturn`'
//      . ' FROM `' . MySQL_Pre . 'PP_Personnel` '
//      . ' Order by `OfficeSL`';
//  $DataResp['EmpName'] = $Data->rawQuery($Query);

  $Query = 'SELECT `DesgID` as `value` FROM `' . MySQL_Pre . 'PP_Personnel` '
      . ' Where `DesgID` like ? Group by `DesgID`';
  echo json_encode($Data->rawQuery($Query,
                                   array('%' . WebLib::GetVal($_REQUEST, 'term') . '%')));

  echo json_encode($DataResp);
  unset($Data);
}
?>