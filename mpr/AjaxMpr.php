<?php

session_start();
require_once __DIR__ . '/../lib.inc.php';
if (WebLib::GetVal($_SESSION, 'CheckAuth') === 'Valid') {

  $Data                  = new MySQLiDBHelper();
  $Query                 = 'SELECT `DeptID`,`DeptName`'
      . ' FROM `' . MySQL_Pre . 'MPR_Departments`'
      . ' Order by `DeptID`';
  $DataResp['DeptID']    = $Data->rawQuery($Query);
  $Query                 = 'SELECT `SectorID`,`SectorName`'
      . ' FROM `' . MySQL_Pre . 'MPR_Sectors`'
      . ' Order by `SectorID`';
  $DataResp['SectorID']  = $Data->rawQuery($Query);
  $Query                 = 'SELECT `SchemeID`,`SchemeName`'
      . ' FROM `' . MySQL_Pre . 'MPR_Schemes`'
      . ' Order by `SchemeID`';
  $DataResp['SchemeID']  = $Data->rawQuery($Query);
  $Query                 = 'SELECT `ProjectID`,`ProjectName`'
      . ' FROM `' . MySQL_Pre . 'MPR_Projects`'
      . ' Order by `ProjectID`';
  $DataResp['ProjectID'] = $Data->rawQuery($Query);

  echo json_encode($DataResp);
  unset($Data);
}
?>