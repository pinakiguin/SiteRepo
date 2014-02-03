<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once __DIR__ . '/../lib.inc.php';
session_start();
echo json_encode(WebLib::GetVal($_SESSION, 'ExcelData', false, false), 128);
?>
