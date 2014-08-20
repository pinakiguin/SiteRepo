<?php
require_once __DIR__.'/../lib.inc.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Contact
 *
 * @author Abu Salam
 */
class Contact {
    
   
    function CreateContact($Mobile,$Name,$Gid){
        $DB=new MySQLiDBHelper();
        $insertData['GroupID']=$Gid;
        $insertData['Name']=$Name;
        $insertData['MobileNo']=$Mobile;
        $ContactID=$DB->insert(MySQL_Pre. 'SMS_Contacts', $insertData);
        return true;
    }
    function getAllContacts(){
      $DB=new MySQLiDBHelper();
      $Contacts=$DB->get(MySQL_Pre. 'SMS_Contacts');
      print_r($Contacts);
      return $Contacts;
    }
    function getContactByGroup($Gid){
      $DB=new MySQLiDBHelper();
      $DB->where('GroupID', $Gid);
      $Contacts=$DB->get(MySQL_Pre. 'SMS_Contacts');
      print_r($Contacts);
      return $Contacts;
    }
    //put your code here
}
