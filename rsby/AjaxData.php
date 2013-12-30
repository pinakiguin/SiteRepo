<?php

require_once('../lib.inc.php');
session_start();

if (WebLib::GetVal($_SESSION, 'RSBY_VillageCode') !== null) {
  $Data = new MySQLiDBHelper();
//$AjaxResp['draw'] = 1;
//$AjaxResp['recordsTotal'] = 57;
//$AjaxResp['recordsFiltered'] = 57;
  $AjaxResp['data'] = $Data
          ->where('VillageCode', WebLib::GetVal($_SESSION, 'RSBY_VillageCode'))
          ->query('Select `URN`, `EName`, `Father_HusbandName`,'
          . ' `RSBYType`, `CatCode`, `BPLCitizen`, `Minority`'
          . ' From `' . MySQL_Pre . 'RSBY_TxnEnrollment` ');
  echo json_encode($AjaxResp);
  unset($Data);
  unset($AjaxResp);
}
?>