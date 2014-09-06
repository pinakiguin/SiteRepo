<?php
require_once __DIR__ . '/../lib.inc.php';
WebLib::AuthSession();
switch(WebLib::GetVal($_POST,'CallAPI')){

  case 'Users_GetUserData':
    $DB = new MySQLiDBHelper();
    $DB->where('CtrlMapID', $_SESSION['UserMapID']);
    WebLib::ShowTable($DB->query('Select `UserName` AS `Scheme Users`'
      .'from '. MySQL_Pre . 'MPR_MappedUsers'));
    unset($DB);
    break;

  case 'Schemes_GetSchemeTable':
    $DB = new MySQLiDBHelper();
    $DB->where('UserMapID', $_SESSION['UserMapID']);
    $DB->where('SchemeID', WebLib::GetVal($_POST, 'Scheme'));
    WebLib::ShowTable($DB->query('Select Year, SchemeName, Amount, OrderNo, '
      .'Date as `Order Date(YYYY-MM-DD)` '
      .'from '. MySQL_Pre . 'MPR_UserSchemeAllotments'));
    unset($DB);
    break;
}
?>
