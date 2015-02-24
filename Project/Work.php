<?php
ini_set('display_errors','1');
error_reporting(E_ALL);
require_once __DIR__ . '/../lib.inc.php';
/**
 * Created by PhpStorm.
 * User: nic
 * Date: 19/2/15
 * Time: 3:57 AM
 */

class Work
{
   function Work() {
        $DB       = new MySQLiDBHelper();
        $Works = $DB->get(MySQL_Pre . 'MPR_Works');
       // print_r($Works);
        //return $Works;
       foreach ($Works as $WorkID) {
           echo '<option value="' . $WorkID['WorkID'] . '">' . $WorkID['WorkDescription'] . '</option>';
       }
       foreach ($Works as $WorkDescription) {
           echo '<option value="' . $WorkDescription['WorkDescription'] . '">' . $WorkDescription['WorkID'] . '</option>';
       }

}



}
$WO=new Work();