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

if (WebLib::GetVal($_POST, 'AjaxToken') ===
    WebLib::GetVal($_SESSION, 'Token')) {
  $_SESSION['LifeTime']  = time();
  $_SESSION['RT']        = microtime(TRUE);
  $_SESSION['CheckAuth'] = 'Valid';
  $DataResp['Data']      = array();
  $DataResp['Msg']       = '';
  switch (WebLib::GetVal($_POST, 'CallAPI')) {

    case 'GetChosenData':

      $Query                = 'Select `SubDivID`,`SubDivName`'
          . ' FROM `' . MySQL_Pre . 'MDM_SubDivision`'
          . ' Order by `SubDivID`';
      $DataResp['SubDivID'] = array();
      doQuery($DataResp['SubDivID'], $Query);

      $Query               = 'Select `BlockID`,`BlockName`,`SubDivID`'
          . ' FROM `' . MySQL_Pre . 'MDM_Blocks`'
          . ' Order by `BlockID`';
      $DataResp['BlockID'] = array();
      doQuery($DataResp['Blocks'], $Query);
      break;
    case 'GetSchoolData':
      $Query               = 'Select S.SchoolID,S.Schoolname,S.Mobile,'
          . 'S.DesigID,S.TotalStudent,S.NameID,'
          . 'S.RegDate,B.BlockName,'
          . 'D.SubdivName FROM ' . MySQL_Pre . 'MDM_Newdata S '
          . 'INNER JOIN ' . MySQL_Pre . 'MDM_Blocks B '
          . 'ON S.BlockID=B.BlockID '
          . 'INNER JOIN ' . MySQL_Pre . 'MDM_SubDivision D '
          . 'ON B.SubDivID=D.SubDivID '
          . 'Order by S.SchoolID';

      doQuery($DataResp, $Query, array(WebLib::GetVal($_POST, 'Schools')));
      break;
    case 'GetMealData':
      $Query = 'Select S.SchoolID,S.Schoolname,'
          . 'S.TotalStudent,M.Meal,M.ReportDate,'
          . 'B.BlockName,'
          . 'D.SubdivName FROM ' . MySQL_Pre . 'MDM_Newdata S '
          . 'INNER JOIN ' . MySQL_Pre . 'MDM_MealData M '
          . 'ON S.SchoolID=M.SchoolID '
          . 'INNER JOIN ' . MySQL_Pre . 'MDM_Blocks B '
          . 'ON S.BlockID=B.BlockID '
          . 'INNER JOIN ' . MySQL_Pre . 'MDM_SubDivision D '
          . 'ON B.SubDivID=D.SubDivID '
          . 'Order by S.SchoolID';

      doQuery($DataResp, $Query, array(WebLib::GetVal($_POST, 'Meals')));
      break;

    default :
      $DataResp['Msg'] = 'Invalid API Call';
    /*
     * Select S.SchoolID,S.Schoolname,S.Mobile,S.DesigID,S.TotalStudent,S.NameID,S.RegDate,B.BlockName,D.SubdivName FROM WebSite_MDM_Newdata S INNER JOIN WebSite_MDM_Blocks B ON S.BlockID=B.BlockID INNER JOIN WebSite_MDM_SubDivision D ON B.SubDivID=D.SubDivID

     *
     * ' . MySQL_Pre . ' */




    default :
      $DataResp['Msg'] = 'Invalid API Call';
      break;
  }

  $_SESSION['LifeTime'] = time();

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
} else {
  $_SESSION['LifeTime'] = time();
  $DataResp['Msg']      = 'Invalid Ajax Token';
  $DataResp['RT']       = '<b>Response Time:</b> '
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
function doQuery(&$DataResp,
                 $Query,
                 $Params = NULL) {
  $Data             = new MySQLiDBHelper();
  $Result           = $Data->rawQuery($Query, $Params);
  $DataResp['Data'] = $Result;
  $DataResp['Msg']  = 'Total Rows: ' . count($Result);
  unset($Result);
  unset($Data);
}

?>