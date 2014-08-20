<?php

require_once __DIR__ . '/../lib.inc.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Group
 *
 * @author Abu Salam
 */
class Group {

  protected $GroupID;

  public function __construct($GroupID = null) {
    if (isset($GroupID)) {
      //Retrieve the Group from database; 
    } else {
      //Create an Empty Group Structure;
    }
  }

  public function setGroup($Group) {
    $this->Group = $Group;
  }

  function CreateGroup($GName) {
    $DB = new MySQLiDBHelper();
    $insertData['GroupName'] = $GName;
    $GroupID = $DB->insert(MySQL_Pre . 'SMS_Groups', $insertData);
    return $GroupID;
  }
  function getAllGroups(){
    $DB = new MySQLiDBHelper();
    $Groups = $DB->get(MySQL_Pre . 'SMS_Groups');
    print_r($Groups);
    return $Groups;
  }
  //put your code here
}
