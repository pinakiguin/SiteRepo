<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once __DIR__ . '/../lib.inc.php';
session_start();
$TmplSMS = WebLib::GetVal($_POST, 'Tmpl');
$Data    = WebLib::GetVal($_SESSION, 'ExcelData', false, false);
foreach ($Data as $RowIndex => $Row) {
  if ($RowIndex === 2) {
    foreach ($Row as $ColIndex => $Value) {
      $TmplSMS = str_replace('{' . $ColIndex . '}', $Value, $TmplSMS);
    }
  }
}
echo $TmplSMS;
?>
