<?php

require_once __DIR__ . '/../lib.inc.php';
require_once __DIR__ . '/User.php';
require_once __DIR__ . '/Contact.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Message
 *
 * @author Abu Salam
 */
class Message {

  protected $User;
  protected $MsgID;
  protected $Msg;
  
  public function setUser($User) {
    $this->User = $User;
  }
 public function getUser() {
   return $this->User;
  }
  public function setMsg($Msg) {
    $this->Msg = $Msg;
  }

  public function getMsg() {
    return $this->Msg;
  }

  //put your code here
  function createSMS($Message,$Gid) {
      $DB = new MySQLiDBHelper();
      $insertData['UserID'] = $this->getUser();
      $insertData['GroupID'] = $Gid;
      $insertData['Text'] = $Message;
      $insertData['SentTime'] ='10';
      $MessageID = $DB->insert(MySQL_Pre . 'SMS_Messages', $insertData);
      $getCon=new Contact();
      $Cont=$getCon->getContactByGroup($Gid);
      //print_r($Cont);
      foreach ($Cont as $ContactID) {
        $this->sendSMS($Message,$ContactID['MobileNo']);
  }
      
      $this->Msg = $Message;
      $this->MsgID = $MessageID;
      return true;
  }
  function sendSMS($MobileNo,$Message){
//      $DB = new MySQLiDBHelper();
//      $insertData['Mid'] = $mid;
//      $insertData['Cid'] =$cid;
//      $Sid = $DB->insert(MySQL_Pre . 'SMS_Status', $insertData);
    echo "To: ".$MobileNo." "."Message: ".$Message."\n";
  }
  function getAllSMS(){
    $DB=new MySQLiDBHelper();
    $SMS=$DB->get(MySQL_Pre. 'SMS_Messages');
    return $SMS;
  }
  function getSMSByUser(){
    $DB=new MySQLiDBHelper();
    $Uid=$this->getUser();
    $DB->where('UserID', $Uid);
    $SMS=$DB->get(MySQL_Pre. 'SMS_Messages');
    print_r($SMS);
    return $SMS;
  }
}

?>