<?php

session_start();
require_once __DIR__ . '/../lib.inc.php';
if (WebLib::GetVal($_SESSION, 'CheckAuth') === 'Valid') {

  $Data = new MySQLiDBHelper(HOST_Name, MySQL_User, MySQL_Pass, MySQL_DB);

  $Query = 'SELECT `DesgID` as `value` FROM `' . MySQL_Pre . 'PP_Personnel` '
      . ' Where `DesgID` like ? Group by `DesgID`';
  echo json_encode($Data->rawQuery($Query,
                                   array('%' . WebLib::GetVal($_REQUEST, 'term') . '%')));

  unset($Data);
}
?>
