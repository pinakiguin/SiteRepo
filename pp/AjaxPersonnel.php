<?php

session_start();
require_once __DIR__ . '/../lib.inc.php';
if (WebLib::GetVal($_SESSION, 'CheckAuth') === 'Valid') {

  $Data = new MySQLiDBHelper();

//  $Query = 'SELECT `OfficeSL`, `OfficeName` FROM `' . MySQL_Pre . 'PP_Offices` '
//    . ' Where `UserMapID`=? Order by `OfficeName`';
//  $DataResp['Offices'] = $Data->rawQuery($Query, array($_SESSION['UserMapID']));
  $Query                = 'SELECT `OfficeSL`, `OfficeName` FROM `' . MySQL_Pre . 'PP_Offices` '
      . 'Order by `OfficeSL`';
  $DataResp['OfficeSL'] = $Data->rawQuery($Query);


  $Query              = 'SELECT `ScaleCode`, `Scale`,`GradePay` FROM `'
      . MySQL_Pre . 'PP_PayScales` '
      . 'Order by `ScaleCode`';
  $DataResp['Scales'] = $Data->rawQuery($Query);

  echo json_encode($DataResp);

  unset($Data);
}
?>