<?php

/**
 * Show the Preview of the SMS and Saves the Template
 * @todo Needs to be implemented on ClientSide using jQuery
 */
ini_set("zlib.output_compression", 4096);

require_once __DIR__ . '/../lib.inc.php';
session_start();

$CSRF           = WebLib::CheckAuth();
$ValidAjaxToken = WebLib::GetVal($_POST, 'AjaxToken') ===
    WebLib::GetVal($_SESSION, 'AjaxToken');

if (($CSRF === 'Valid') && $ValidAjaxToken) {
  switch (WebLib::GetVal($_POST, 'CallAPI')) {

    case 'SaveTmpl':
      $TxtSMS               = WebLib::GetVal($_POST, 'Tmpl');
      $_SESSION['TxtSMS']   = $TxtSMS;
      $_SESSION['TmplName'] = WebLib::GetVal($_POST, 'TmplName');
      ShowSMS($TxtSMS);
      break;

    case 'ShowOnly':
      $TxtSMS = WebLib::GetVal($_SESSION, 'TxtSMS');
      ShowSMS($TxtSMS);
      break;

    default :
      $DataResp['Msg'] = 'Invalid API Call!';
      break;
  }
} else {
  $DataResp['Msg'] = $CSRF . ' Invalid Token: ' . $ValidAjaxToken;
}

$DataResp['TxtSMS'] = $TxtSMS;
$AjaxResp           = json_encode($DataResp);
header('Content-Type: application/json');
header('Content-Length: ' . strlen($TxtSMS));
echo $AjaxResp;
exit();

/**
 * Creates a Preview from the Supplied Template and Contacts
 *
 * @param ref $TxtSMS
 */
function ShowSMS(&$TxtTmplSMS) {
  $Data = WebLib::GetVal($_SESSION, 'ExcelData', false, false);
  if (is_array($Data)) {
    foreach ($Data as $RowIndex => $Row) {
      if ($RowIndex === 2) {
        foreach ($Row as $ColIndex => $Value) {
          $TxtTmplSMS = str_replace('{' . $ColIndex . '}', $Value, $TxtTmplSMS);
        }
        break;
      }
    }
  } else {
    $TxtTmplSMS = 'Template/Contacts Not Available!';
  }
}

?>
