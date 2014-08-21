<?php
/**
 * Created by PhpStorm.
 * User: abu
 * Date: 20/8/14
 * Time: 11:08 PM
 */

ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once(__DIR__ . '/MessageAPI.php');

$RT = time();
WebLib::CreateDB();
$json = file_get_contents('php://input');
$jsonData = json_decode($json);

$mAPI=new MessageAPI($jsonData);
$mAPI->executeAPI();
exit();