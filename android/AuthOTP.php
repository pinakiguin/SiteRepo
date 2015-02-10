<?php
require_once(__DIR__ . '/../lib.inc.php');
require_once(__DIR__ . '/ga4php.php');

class AuthOTP extends GoogleAuthenticator {

  private $Mode;

  function __construct($Mode = 0) {
    /**
     * Important: Key Skew and Hunt values needs to be set.
     */
    parent::__construct();
    $this->Mode = $Mode;
  }

  /**
   * "select tokendata from users where username='$username'"
   *
   * @param $UserID
   *
   * @returns string $TokenData
   */
  function getData($UserID) {
    // TODO: Implement getData() method.
    $MySQLiDB = new MySQLiDBHelper();
    $User = $MySQLiDB->where('MobileNo', $UserID)->get(MySQL_Pre . 'SMS_Users');
    if (count($User) > 0) {
      if ($this->Mode == 0) {
        return $User[0]['UserData'];
      } else {
        return $User[0]['TempData'];
      }
    }
  }

  /**
   * "update users set tokendata='$data' where username='$username'"
   *
   * This function returns true if updated otherwise false
   *
   * @param $UserID
   * @param $TokenData
   *
   * @return boolean
   */
  function putData($UserID, $TokenData) {
    // TODO: Implement putData() method.
    $MySQLiDB = new MySQLiDBHelper();
    if ($this->Mode == 0) {
      $Data['UserData'] = $TokenData;
    } else {
      $Data['TempData'] = $TokenData;
    }
    if ($MySQLiDB->where('MobileNo', $UserID)->update(MySQL_Pre . 'SMS_Users', $Data) == 0) {
      $MySQLiDB->insert(MySQL_Pre . 'SMS_Users', $Data);
    }
    $_SESSION['TokenOTP'] = $TokenData;
    return true;
  }

  /**
   * Return all registered and activated users
   * i.e. an Array of user names only
   */
  function getUsers() {
    // TODO: Implement getUsers() method.
    $MySQLiDB = new MySQLiDBHelper();
    $UserIDs = $MySQLiDB->query('Select MobileNo from ' . MySQL_Pre . 'SMS_Users');
    return $UserIDs;
  }

} 