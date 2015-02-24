<?php
ini_set('display_errors','1');
error_reporting(E_ALL);
require_once __DIR__ . '/../lib.inc.php';
/**
 * Created by PhpStorm.
 * User: nic
 * Date: 19/2/15
 * Time: 4:35 AM
 */

class Scheme
{
    //protected $SchemeID;
    function Scheme()
    {
        $DB = new MySQLiDBHelper;
        // $Schemes = $DB->get( MySQL_Pre . 'MPR_Schemes');
        //print_r($Schemes);
        $Schemes =$DB->query('Select SchemeName FROM '. MySQL_Pre .'MPR_Schemes');
        // return $Schemes;
        //$this->SchemeID=$Schemes[0]['SchemeID'];
        //$this->SchemeName=$Schemes[0]['SchemeName'];
        print_r($Schemes);
        return ($Schemes);


        /* foreach ($Schemes as $SchemeID) {
            echo '<option value="' . $SchemeID['SchemeID'] . '">' . $SchemeID['SchemeName'] . '</option>';
         }
         foreach($Schemes as $SchemeName) {
           echo '<option value="' . $SchemeName['SchemeName'] . '">' . $SchemeName['SchemeID'] . '</option>';
         }
            }*/
    }
  public function view()
   {

       echo "This is my first Page";
   }

}
$Sc= new Scheme();


