<?php
/**
 * Created by PhpStorm.
 * User: nic
 * Date: 14/8/14
 * Time: 11:32 AM
 */

class Contact {

  protected $UserID;
  protected $UserName;
  protected $Designation;
  protected $eMailID;
  protected $MobileNo;
  protected $GroupID;

  /**
   * @param mixed $UserID
   */
  public function setUserID($UserID) {
    $this->UserID = $UserID;
  }

  /**
   * @return mixed
   */
  public function getUserID() {
    return $this->UserID;
  }

  /**
   * @param mixed $UserName
   */
  public function setUserName($UserName) {
    $this->UserName = $UserName;
  }

  /**
   * @return mixed
   */
  public function getUserName() {
    return $this->UserName;
  }

  /**
   * @param mixed $Designation
   */
  public function setDesignation($Designation) {
    $this->Designation = $Designation;
  }

  /**
   * @return mixed
   */
  public function getDesignation() {
    return $this->Designation;
  }

  /**
   * @param mixed $eMailID
   */
  public function setEMailID($eMailID) {
    $this->eMailID = $eMailID;
  }

  /**
   * @return mixed
   */
  public function getEMailID() {
    return $this->eMailID;
  }

  /**
   * @param mixed $MobileNo
   */
  public function setMobileNo($MobileNo) {
    $this->MobileNo = $MobileNo;
  }

  /**
   * @return mixed
   */
  public function getMobileNo() {
    return $this->MobileNo;
  }

  /**
   * @param mixed $GroupID
   */
  public function setGroupID($GroupID) {
    $this->GroupID = $GroupID;
  }

  /**
   * @return mixed
   */
  public function getGroupID() {
    return $this->GroupID;
  }


}