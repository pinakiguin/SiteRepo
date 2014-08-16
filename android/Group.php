<?php
/**
 * Created by PhpStorm.
 * User: nic
 * Date: 14/8/14
 * Time: 12:08 PM
 */

class Group {

  protected $GroupName;
  protected $GroupID;

  /**
   * @param mixed $GroupName
   */
  public function setGroupName($GroupName) {
    $this->GroupName = $GroupName;
  }

  /**
   * @return mixed
   */
  public function getGroupName() {
    return $this->GroupName;
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