<?php

session_start();
require_once __DIR__ . '/../lib.inc.php';
if (WebLib::GetVal($_SESSION, 'CheckAuth') === 'Valid') {

  $Data                 = new MySQLiDBHelper();
  $Query                = 'SELECT `OfficeSL`, `OfficeName` '
      . ' FROM `' . MySQL_Pre . 'PP_Offices` '
      . ' Where `UserMapID`=?'
      . ' Order by `OfficeSL`';
  $DataResp['OfficeSL'] = $Data->rawQuery($Query, array($_SESSION['UserMapID']));

  $Query              = 'SELECT `DesgID` as `value`,`DesgID` as `label`'
      . ' FROM `' . MySQL_Pre . 'PP_Personnel`'
      . ' Group by `DesgID`';
  $DataResp['DesgID'] = $Data->query($Query);

  $Query              = 'SELECT `ScaleCode`, `Scale`,`GradePay` FROM `'
      . MySQL_Pre . 'PP_PayScales` '
      . 'Order by `ScaleCode`';
  $DataResp['Scales'] = $Data->rawQuery($Query);

  $Query                = 'SELECT `BankSL`, `BankName` '
      . ' FROM `' . MySQL_Pre . 'PP_Banks` '
      . ' Order by `BankName`';
  $DataResp['BankName'] = $Data->rawQuery($Query);

  unset($Data);

  echo json_encode($DataResp);
}
?>