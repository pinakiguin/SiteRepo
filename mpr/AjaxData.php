<?php
require_once __DIR__ . '/../lib.inc.php';
WebLib::AuthSession();
$DB = new MySQLiDBHelper();
$DB->where('UserMapID', $_SESSION['UserMapID']);
$DB->where('SchemeID', WebLib::GetVal($_POST, 'Scheme'));
WebLib::ShowTable($DB->query('Select Year, SchemeName, Amount, OrderNo, Date from '. MySQL_Pre . 'MPR_UserSchemeAllotments'));
?>