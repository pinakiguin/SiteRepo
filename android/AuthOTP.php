<?php
require_once('../lib.inc.php');
 require_once('ga4php.php');

class AuthOTP extends  GoogleAuthenticator{

  /**
   * "select tokendata from users where username='$username'"
   *
   * @param $UserID
   *
   * @returns string $TokenData
   */
  function getData($UserID) {
    // TODO: Implement getData() method.
    $MySQLiDB=new MySQLiDBHelper();
    $Users=$MySQLiDB->where('Uid',$UserID)->get(MySQL_Pre.'SMS_Users');
    $_SESSION['TokenOTP']=$Users[0]['Password'];
    $TokenData=$_SESSION['TokenOTP'];
    return $TokenData;
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
    $MySQLiDB=new MySQLiDBHelper();
    $Data['Password']=$TokenData;
    $MySQLiDB->where('Uid',$UserID)->update(MySQL_Pre.'SMS_Users',$Data);
    $_SESSION['TokenOTP']=$TokenData;
    return true;
  }

  /**
   * Return all registered and activated users
   * i.e. an Array of user names only
   */
  function getUsers() {
    // TODO: Implement getUsers() method.
    $MySQLiDB=new MySQLiDBHelper();
    $UserIDs=$MySQLiDB->get(MySQL_Pre.'SMS_Users');
    return $UserIDs;
  }

} 