<?php

require_once('../lib.inc.php');
require_once '../class.MySQLiDBHelper.php';

if (!isset($_SESSION))
  session_start();

$CSRF = (WebLib::GetVal($_POST, 'AjaxToken') === WebLib::GetVal($_SESSION, 'Token'));
if ((WebLib::CheckAuth() === 'Valid') && $CSRF) {
  $_SESSION['LifeTime'] = time();
  $_SESSION['RT'] = microtime(TRUE);
  $_SESSION['CheckAuth'] = 'Valid';
  $DataResp['Data'] = array();
  $DataResp['Msg'] = '';
  switch (WebLib::GetVal($_POST, 'CallAPI')) {
    case 'GetRequiredCP':
      $Data = new MySQLiDBHelper(HOST_Name, MySQL_User, MySQL_Pass, MySQL_DB);
      $CountingTablesQry = 'Select BlockName,Assembly,Tables from `' . MySQL_Pre . 'CP_CountingTables` T'
              . ' JOIN `' . MySQL_Pre . 'CP_Blocks` B ON (T.Assembly=B.BlockCode)';
      $DataResp['Data'] = $Data->query($CountingTablesQry);
      $DataResp['Msg'] = 'Total Records: ' . count($DataResp['Data']);
      break;
    case 'MakeGroupCP':
      $Params = WebLib::GetVal($_POST, 'Params', false, false);
      $Posts = WebLib::GetVal($_POST, 'Posts', false, false);
      $DataResp['Data']['Status'] = MakeGroupCP($Params, $Posts);
      $DataResp['Msg'] = 'Finished: ' . $Params['BlockName'];
      break;
    default:
      break;
  }
  $_SESSION['Token'] = md5($_SERVER['REMOTE_ADDR'] . session_id() . $_SESSION['ET']);
  $DataResp['AjaxToken'] = $_SESSION['Token'];
  $DataResp['RT'] = '<b>Response Time:</b> '
          . round(microtime(TRUE) - WebLib::GetVal($_SESSION, 'RT'), 6) . ' Sec';
  //PHP 5.4+ is required for JSON_PRETTY_PRINT
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

function MakeGroupCP($Block, $Posts) {
  $Data = new MySQLiDBHelper(HOST_Name, MySQL_User, MySQL_Pass, MySQL_DB);
  $CountTotal = 'Done';
  foreach ($Posts as $Post) {
    $CP_PoolQry = 'Select PersSL from ' . MySQL_Pre . 'CP_Pool';
    $Data->where('AssemblyCode', $Block['Assembly']);
    $Data->where('`Post`', (($Post === '3') ? '2' : $Post));
    $GroupCP = $Data->query($CP_PoolQry);
    shuffle($GroupCP);
    $GroupID = 0;
    $Reserve = '';
    foreach ($GroupCP as $PersCP) {
      $GroupID++;
      if ($GroupID > $Block['Tables']) {
        $Reserve = 'R';
        if (((count($GroupCP) / 2) < $GroupID) && ($Post === '2')) {
          $GroupID--;
          break;
        }
      }
      $RandCP['PersSL'] = $PersCP['PersSL'];
      $RandCP['GroupID'] = $Reserve . str_pad($GroupID, 3, '0', STR_PAD_LEFT);
      $RandCP['AssemblyCode'] = $Block['Assembly'];
      $Data->insert(MySQL_Pre . 'CP_Groups', $RandCP);
    }
    if ($GroupID > 0) {
      $CountTotal.=': ' . $GroupID;
    } elseif ($CountTotal === 'Done') {
      $CountTotal = 'Already Randomized';
    }
  }
  return $CountTotal;
}

?>
