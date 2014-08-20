<?php
require_once __DIR__ . '/../lib.inc.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Abu Salam
 */
class User {

  //put your code here
  protected $UserID;
  protected $MobileNo;
  protected $UserName;
  protected $Password;

  function setPass($Pass) {
    $this->Password = $Pass;
  }

  function setUserID($UserID) {
    $this->UserID = $UserID;
  }

  function getUserID() {
    return $this->UserID;
  }

  function setMobileNo($MobileNo) {
    $this->MobileNo = $MobileNo;
  }

  function getMobileNo() {
    return $this->MobileNo;
  }

  function isAuthUser() {
    return true;
  }

  //put your code here
  function SendSMS($Group, $Message) {
    if ($this->isAuthUser()) {
      $Contacts=$Group->getContacts();
      foreach ($Contacts as $Contact) {
        
      }
      return true;
    } else {
      return false;
    }
  }
  function createUser($UserName,$Password){
      $DB = new MySQLiDBHelper();
      $Pass=md5($Password);
      $insertData['UserName'] = $UserName;
      $insertData['Password'] =$Pass;
      $insertData['Status'] ='off';
      $UserID = $DB->insert(MySQL_Pre . 'SMS_Users', $insertData);
      return true;
      
  }
}
