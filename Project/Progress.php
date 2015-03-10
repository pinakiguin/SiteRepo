<?php

ini_set('display_errors','1');
error_reporting(E_ALL);
require_once __DIR__ . '/../lib.inc.php';
require_once(__DIR__ . '/Scheme.php');
require_once(__DIR__ . '/Work.php');

/**
 * Created by PhpStorm.
 * User: nic
 * Date: 19/2/15
 * Time: 5:25 AM
 */

class Progress
{
    protected $ProgressID;
    protected $WorksID;

    function Progress()
    {
        $DB = new MySQLiDBHelper;
        $Progresses = $DB->get(MySQL_Pre . 'MPR_Progress');
      //  print_r($Progresses);
      //  return $Progresses;
        foreach ($Progresses as $ProgressID) {
            echo '<option value="' . $ProgressID['ProgressID'] . '">' . $ProgressID['Progress'] . '</option>';
        }
        $this->ProgressID     = $Progresses[0]['ProgressID'];
        $this->WorksID    = $Progresses[0]['WorkID'];
    }

}
$object1=new Progress();
//$object2=new getWorksID();

