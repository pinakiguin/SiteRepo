<?php

session_start();
require_once __DIR__ . '/../lib.inc.php';
if (WebLib::GetVal($_SESSION, 'CheckAuth') === 'Valid') {

  $Data  = new MySQLiDBHelper();
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

  echo json_encode($DataResp);
  unset($Data);
}
?>