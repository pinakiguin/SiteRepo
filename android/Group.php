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

  public function setGroup($GroupName) {
    $DB = new MySQLiDBHelper();
    $DB->where('GroupName', $GroupName);
    $Group=$DB->get(MySQL_Pre. 'SMS_Groups');
    $this->GroupID =$Group[0]['GroupID'];
  }
  public function getGroupID() {
    return $this->GroupID;
  }

  function CreateGroup($GName) {
    $DB = new MySQLiDBHelper();
    $insertData['GroupName'] = $GName;
    $GroupID = $DB->insert(MySQL_Pre . 'SMS_Groups', $insertData);
    return $GroupID;
  }
  static function getAllGroups(){
    $DB = new MySQLiDBHelper();
    $Groups = $DB->query('Select GroupName FROM '.MySQL_Pre.'SMS_Groups');
    return $Groups;
  }
  //put your code here
}
