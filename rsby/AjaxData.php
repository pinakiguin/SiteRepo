<?php

require_once('../lib.inc.php');

$Data = new MySQLiDBHelper();
//$AjaxResp['draw'] = 1;
//$AjaxResp['recordsTotal'] = 57;
//$AjaxResp['recordsFiltered'] = 57;
$AjaxResp['data'] = $Data->query('Select `URN`, `EName`, `Father_HusbandName`,'
        . ' `Door_HouseNo`, `VillageCode`, `Panchayat_TownCode`, `BlockCode`'
        . ' From `' . MySQL_Pre . 'RSBY_TxnEnrollment`');
echo json_encode($AjaxResp);
unset($Data);
unset($AjaxResp);
?>