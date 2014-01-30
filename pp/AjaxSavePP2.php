<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once __DIR__ . '/../lib.inc.php';
if (!isset($_SESSION)) {
  session_start();
}
if (WebLib::GetVal($_SESSION, 'CheckAuth') === 'Valid') {
  include __DIR__ . '/PersonnelData.php';
  $AjaxResp['FormToken'] = $_SESSION['FormToken'];
  $AjaxResp['Msg']       = $_SESSION['Msg'];
  $_SESSION['Msg']       = '';
  $AjaxResp['Done']      = count($_SESSION['PostData']);
  echo json_encode($AjaxResp);
  exit();
}
header("HTTP/1.1 404 Not Found");
?>
