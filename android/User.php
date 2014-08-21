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

  protected $MobileNo;
  protected $UserName;
  protected $Designation;
  protected $eMailID;

  function __construct($MobileNo) {
    $DB = new MySQLiDBHelper();
    $DB->where('MobileNo',$MobileNo);
    $Users=$DB->get(MySQL_Pre.'SMS_Users');
    $this->eMailID=$Users[0]['eMailID'];
    $this->UserName=$Users[0]['UserName'];
    $this->Designation=$Users[0]['Designation'];
    $this->MobileNo = $MobileNo;
  }

  /**
   * @return mixed
   */
  public function getDesignation() {
    return $this->Designation;
  }

  /**
   * @return mixed
   */
  public function getUserName() {
    return $this->UserName;
  }

  /**
   * @return mixed
   */
  public function getEMailID() {
    return $this->eMailID;
  }


  function getMobileNo() {
    return $this->MobileNo;
  }

  function isAuthUser() {
    return true;
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
