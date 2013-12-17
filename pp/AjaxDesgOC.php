<?php

session_start();
require_once __DIR__ . '/../lib.inc.php';
if (WebLib::GetVal($_SESSION, 'CheckAuth') === 'Valid') {

  $Data = new MySQLiDBHelper(HOST_Name, MySQL_User, MySQL_Pass, MySQL_DB);

  $Query = 'SELECT `DesgOC` as `value` FROM `' . MySQL_Pre . 'PP_Offices` '
          . ' Where `DesgOC` like ? Group by `DesgOC`';
  echo json_encode($Data->rawQuery($Query, array('%' . WebLib::GetVal($_REQUEST, 'term') . '%')));

  unset($Data);
}
?>