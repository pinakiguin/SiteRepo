<?php

ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once(__DIR__ . '/AttendanceAPI.php');

$RT = time();
$json     = file_get_contents('php://input');
$jsonData = json_decode($json);

$mAPI = new AttendanceAPI($jsonData);
$mAPI();
exit();