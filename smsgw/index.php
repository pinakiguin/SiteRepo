<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');
if (version_compare(phpversion(), '5.3.0', 'ge')) {
  $MySQLi = extension_loaded('mysqli');
  $MySQL = extension_loaded('mysql');
  if (($MySQLi === true) && ($MySQL === true)) {
    include_once __DIR__ . '/../lib.inc.php';
    //WebLib::CreateDB();
  } else {
    die('Required PHP Extensions: mysql and mysqli  <br/>'
        . ' But you have: ' . implode(', ', get_loaded_extensions()));
  }
} else {
  die('Required PHP Version: 5.3 or later. <br/>'
      . ' You have: ' . phpversion());
}

//$Query = 'Select `code`, `code_display`'
//   . ' From `' . MySQL_Pre . 'CaptchaCodes`';
$Query='Select * from `'.MySQL_Pre.'Visits`';
doQuery($DataResp, $Query);

$DataResp['AjaxToken'] = md5(session_id() . time());;
//PHP 5.4+ is required for JSON_PRETTY_PRINT
//@todo Remove PRETTY_PRINT for Production
if (strnatcmp(phpversion(), '5.4') >= 0) {
  $AjaxResp = json_encode($DataResp, JSON_PRETTY_PRINT);
} else {
  $AjaxResp = json_encode($DataResp); //WebLib::prettyPrint(json_encode($DataResp));
}
//unset($DataResp);

header('Content-Type: application/json');
header('Content-Length: ' . strlen($AjaxResp));
//sleep(5);
//print_r($DataResp);
echo $AjaxResp;
exit();

/**
 * Perfroms Select Query to the database
 *
 * @param ref $DataResp
 * @param string $Query
 * @param array $Params
 * @example GetData(&$DataResp, "Select a,b,c from Table Where c=? Order By b LIMIT ?,?", array('1',30,10))
 */
function doQuery(&$DataResp,
                 $Query,
                 $Params = NULL) {
  $Data = new MySQLiDBHelper();
  $Result = $Data->rawQuery($Query, $Params);
  $DataResp['Data'] = $Result;
  $DataResp['Msg'] = 'Total Rows: ' . count($Result);
  $DataResp['SentOn']=date('l d F Y g:i:s A',time());
  unset($Result);
  unset($Data);
}

?>
