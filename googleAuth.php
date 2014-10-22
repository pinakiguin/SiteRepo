<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/google-api-php-client/autoload.php';
require_once __DIR__ . '/lib.inc.php';
if (!isset($_SESSION)) {
  session_start();
}
$client = new Google_Client();
$client->setClientId(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->setRedirectUri(WebLib::GetVal($_SESSION, 'BaseURL') . 'googleAuth.php');
$client->addScope("email");

if (isset($_GET['code'])) {
  try {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
  } catch (Google_Auth_Exception $gAuthResp) {
    echo $gAuthResp->getMessage();
  }
}
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
  try {
    $token_data = $client->verifyIdToken()->getAttributes();
    $_SESSION['email']          = $token_data['payload']['email'];
    $_SESSION['email_verified'] = $token_data['payload']['email_verified'];
  } catch (Google_IO_Exception $gAuthError) {
    $_SESSION['Msg'] = $gAuthError->getMessage();
  }

  if (WebLib::GetVal($_SESSION, 'email_verified') == 1) {

    $_SESSION['ET'] = microtime(true);
    $Data           = new MySQLiDBHelper();
    $ID             = WebLib::GetVal($_SESSION, 'ID');
    $_SESSION['ID'] = session_id();
    if (WebLib::GetVal($_SESSION, 'LifeTime') === null) {
      $_SESSION['LifeTime'] = time();
    }
    $QueryLogin = "Select UserMapID,UserName from `" . TABLE_PREFIX . "Users` "
        . " Where `UserID`=? AND Activated";
    $filter[]   = WebLib::GetVal($_SESSION, 'email', true);

    $rows = $Data->rawQuery($QueryLogin, $filter);

    if (count($rows) > 0) {
      session_regenerate_id();
      $Row                     = $rows[0];
      $_SESSION['CheckAuth']   = "Valid";
      $_SESSION['UserName']    = $Row['UserName'];
      $_SESSION['UserMapID']   = $Row['UserMapID'];
      $_SESSION['ID']          = session_id();
      $_SESSION['FingerPrint'] =
          md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . "KeyLeft");
      $_SESSION['REFERER1']    = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
      $action                  = "JustLoggedIn";
      $_SESSION['Msg']         = 'Welcome ' . $Row['UserName'];

      $Data->ddlQuery(
          "Update " . TABLE_PREFIX . "Users Set LoginCount=LoginCount+1"
          . " Where `UserID`='" . WebLib::GetVal($_POST, 'UserID', true) . "'"
          . " AND MD5(concat(`UserPass`,MD5('"
          . WebLib::GetVal($_POST, 'LoginToken', true) . "')))='"
          . WebLib::GetVal($_POST, 'UserPass', true) . "'"
      );

      $QueryData['SessionID'] = WebLib::GetVal($_SESSION, 'ID');
      $QueryData['IP']        = $_SERVER['REMOTE_ADDR'];
      $QueryData['Referrer']  = $Data->escape($_SERVER["HTTP_REFERER"]);
      $QueryData['UserAgent'] = $_SERVER['HTTP_USER_AGENT'];
      $QueryData['UserID']    = WebLib::GetVal($_SESSION, 'UserMapID');
      $QueryData['URL']       = $Data->escape($_SERVER['PHP_SELF']);
      $QueryData['Action']    = 'Login: Success';
      $QueryData['Method']    = $Data->escape($_SERVER['REQUEST_METHOD']);
      $QueryData['URI']       = $Data->escape($_SERVER['REQUEST_URI']);

      $Data->insert(TABLE_PREFIX . 'Logs', $QueryData);
      unset($QueryData);
      $redirect = 'index.php';
    } else {
      $action          = "NoAccess";
      $_SESSION['Msg'] = "Sorry! Access Denied!";

      $QueryData['SessionID'] = WebLib::GetVal($_SESSION, 'ID');
      $QueryData['IP']        = $_SERVER['REMOTE_ADDR'];
      $QueryData['Referrer']  = $Data->escape($_SERVER["HTTP_REFERER"]);
      $QueryData['UserAgent'] = $_SERVER['HTTP_USER_AGENT'];
      $QueryData['UserID']    = WebLib::GetVal($_SESSION, 'UserMapID');
      $QueryData['URL']       = $Data->escape($_SERVER['PHP_SELF']);
      $QueryData['Action']    = 'Login: Failed[' . WebLib::GetVal($_POST, 'UserID', true) . ']';
      $QueryData['Method']    = $Data->escape($_SERVER['REQUEST_METHOD']);
      $QueryData['URI']       = $Data->escape($_SERVER['REQUEST_URI']);

      $Data->insert(TABLE_PREFIX . 'Logs', $QueryData);
      unset($QueryData);
      unset($_SESSION['access_token']);
      $redirect = 'login.php';
    }
  } else {
    echo 'Unverified Email:' . WebLib::GetVal($_SESSION, 'email');
    exit();
  }
  $redirect = WebLib::GetVal($_SESSION, 'BaseURL') . $redirect;
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
} else {
  $authUrl = $client->createAuthUrl();
}
