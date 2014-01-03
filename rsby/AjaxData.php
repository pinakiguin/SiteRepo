<?php

/**
 * API For Ajax Calls from a valid authenticated session.
 *
 *
 * The JSON Object will Contain Four Top Level Nodes
 * 1. $DataResp['AjaxToken'] => Token for preventing atacks like CSRF and Sesion Hijack
 * 2. $DataResp['Data']
 * 3. $DataResp['Msg']
 * 4. $DataResp['RT'] => Response Time of the Script
 *
 * @example ($_POST=array(
 *              'CallAPI'=>'GetData',
 *              'AjaxToken'=>'$$$$')
 *
 * @return json
 *
 */
require_once ( __DIR__ . '/../lib.inc.php');
if (!isset($_SESSION)) {
  session_start();
}

if (WebLib::GetVal($_POST, 'AjaxToken') === WebLib::GetVal($_SESSION, 'Token')) {
  $_SESSION['LifeTime'] = time();
  $_SESSION['RT'] = microtime(TRUE);
  $_SESSION['CheckAuth'] = 'Valid';
  $DataResp['Data'] = array();
  $DataResp['Msg'] = '';
  switch (WebLib::GetVal($_POST, 'CallAPI')) {

    case 'GetRSBYData':
      $_SESSION['POST'] = $_POST;
      $Query = 'Select `URN`, `EName`, `Father_HusbandName`,'
              . ' `RSBYType`, `CatCode`, `BPLCitizen`, `Minority`'
              . ' From `' . MySQL_Pre . 'RSBY_TxnEnrollment`'
              . ' Where `VillageCode`=?';
      doQuery($DataResp, $Query, array(WebLib::GetVal($_POST, 'VillageCode')));
      break;

    case 'GetComboData':
      $Query = 'Select `BlockCode`,`BlockName`'
              . ' FROM `' . MySQL_Pre . 'RSBY_MstBlock` ';
      $DataResp['Blocks'] = array();
      doQuery($DataResp['Blocks'], $Query);

      $Query = 'Select `Panchayat_TownCode`,`Panchayat_TownName`,`BlockCode`'
              . ' FROM `' . MySQL_Pre . 'RSBY_MstPanchayatTown` ';
      $DataResp['Panchayats'] = array();
      doQuery($DataResp['Panchayats'], $Query);

      $Query = 'Select `VillageCode`,`VillageName`,`Panchayat_TownCode`'
              . ' FROM `' . MySQL_Pre . 'RSBY_MstVillage`';
      $DataResp['Villages'] = array();
      doQuery($DataResp['Villages'], $Query);
      break;
  }
  $_SESSION['Token'] = md5($_SERVER['REMOTE_ADDR'] . session_id() . $_SESSION['ET']);
  $_SESSION['LifeTime'] = time();
  $DataResp['AjaxToken'] = $_SESSION['Token'];
  $DataResp['RT'] = '<b>Response Time:</b> '
          . round(microtime(TRUE) - WebLib::GetVal($_SESSION, 'RT'), 6) . ' Sec';
  //PHP 5.4+ is required for JSON_PRETTY_PRINT
  //@todo Remove PRETTY_PRINT for Production
  if (strnatcmp(phpversion(), '5.4') >= 0) {
    $AjaxResp = json_encode($DataResp, JSON_PRETTY_PRINT);
  } else {
    $AjaxResp = json_encode($DataResp); //WebLib::prettyPrint(json_encode($DataResp));
  }
  unset($DataResp);

  header('Content-Type: application/json');
  header('Content-Length: ' . strlen($AjaxResp));
  echo $AjaxResp;
  exit();
}
header("HTTP/1.1 404 Not Found");
exit();

/**
 * Perfroms Select Query to the database
 *
 * @param ref     $DataResp
 * @param string  $Query
 * @param array   $Params
 * @example GetData(&$DataResp, "Select a,b,c from Table Where c=? Order By b LIMIT ?,?", array('1',30,10))
 */
function doQuery(&$DataResp, $Query, $Params = NULL) {
  $Data = new MySQLiDBHelper();
  $Result = $Data->rawQuery($Query, $Params);
  $DataResp['Data'] = $Result;
  $DataResp['Msg'] = 'Total Rows: ' . count($Result);
  unset($Result);
  unset($Data);
}

?>