<?php

session_start();
require_once __DIR__ . '/../lib.inc.php';
if (WebLib::GetVal($_SESSION, 'CheckAuth') === 'Valid') {

  $Data = new MySQLiDBHelper(HOST_Name, MySQL_User, MySQL_Pass, MySQL_DB);

  $Query = 'SELECT `OfficeSL` as `value`, `OfficeName` as `label` FROM `' . MySQL_Pre . 'PP_Offices` '
          . ' Where `OfficeName` like ? AND `UserMapID`=? Order by `OfficeName` limit 15';
  echo json_encode($Data->rawQuery($Query, array('%' . WebLib::GetVal($_REQUEST, 'term') . '%', WebLib::GetVal($_SESSION, 'UserMapID'))));

  unset($Data);
}
?>