<?php
require_once __DIR__ . '/google-api-php-client/autoload.php';

$client = new Google_Client();
$client->setClientId(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->setRedirectUri(REDIRECT_URI);
$client->addScope("email");

if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
  $token_data = $client->verifyIdToken()->getAttributes();
}
else {
  $authUrl = $client->createAuthUrl();
}


if ((WebLib::GetVal($_POST, 'UserID') !== NULL) && (WebLib::GetVal($_POST,
      'UserPass') !== NULL) && $ValidCaptcha
) {
  $QueryLogin = "Select UserMapID,UserName from `" . MySQL_Pre . "Users` "
    . " Where `UserID`=? AND MD5(CONCAT(`UserPass`,MD5(?)))=? AND Activated";
  $filter[] = WebLib::GetVal($_POST, 'UserID', TRUE);
  $filter[] = WebLib::GetVal($_SESSION, 'Token', TRUE);
  $filter[] = WebLib::GetVal($_POST, 'UserPass', TRUE);

  $rows = $Data->rawQuery($QueryLogin, $filter);

  if (count($rows) > 0) {
    session_regenerate_id();
    $Row = $rows[0];
    $_SESSION['CheckAuth'] = "Valid";
    $_SESSION['UserName'] = $Row['UserName'];
    $_SESSION['UserMapID'] = $Row['UserMapID'];
    $_SESSION['ID'] = session_id();
    $_SESSION['FingerPrint'] = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . "KeyLeft");
    $_SESSION['REFERER1'] = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $action = "JustLoggedIn";

    $Data->ddlQuery("Update " . MySQL_Pre . "Users Set LoginCount=LoginCount+1"
      . " Where `UserID`='" . WebLib::GetVal($_POST, 'UserID', TRUE) . "'"
      . " AND MD5(concat(`UserPass`,MD5('" . WebLib::GetVal($_POST,
        'LoginToken', TRUE) . "')))='" . WebLib::GetVal($_POST,
        'UserPass',
        TRUE) . "'");

    $QueryData['SessionID'] = WebLib::GetVal($_SESSION, 'ID');
    $QueryData['IP'] = $_SERVER['REMOTE_ADDR'];
    $QueryData['Referrer'] = $Data->escape($_SERVER["HTTP_REFERER"]);
    $QueryData['UserAgent'] = $_SERVER['HTTP_USER_AGENT'];
    $QueryData['UserID'] = WebLib::GetVal($_SESSION, 'UserMapID');
    $QueryData['URL'] = $Data->escape($_SERVER['PHP_SELF']);
    $QueryData['Action'] = 'Login: Success';
    $QueryData['Method'] = $Data->escape($_SERVER['REQUEST_METHOD']);
    $QueryData['URI'] = $Data->escape($_SERVER['REQUEST_URI']);

    $Data->insert(MySQL_Pre . 'Logs', $QueryData);
    unset($QueryData);

  }
  else {
    $action = "NoAccess";

    $QueryData['SessionID'] = WebLib::GetVal($_SESSION, 'ID');
    $QueryData['IP'] = $_SERVER['REMOTE_ADDR'];
    $QueryData['Referrer'] = $Data->escape($_SERVER["HTTP_REFERER"]);
    $QueryData['UserAgent'] = $_SERVER['HTTP_USER_AGENT'];
    $QueryData['UserID'] = WebLib::GetVal($_SESSION, 'UserMapID');
    $QueryData['URL'] = $Data->escape($_SERVER['PHP_SELF']);
    $QueryData['Action'] = 'Login: Failed[' . WebLib::GetVal($_POST, 'UserID', TRUE) . ']';
    $QueryData['Method'] = $Data->escape($_SERVER['REQUEST_METHOD']);
    $QueryData['URI'] = $Data->escape($_SERVER['REQUEST_URI']);

    $Data->insert(MySQL_Pre . 'Logs', $QueryData);
    unset($QueryData);
  }
}
$_SESSION['Token'] = md5($_SERVER['REMOTE_ADDR'] . $ID . time());
?>

<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
<script src="https://apis.google.com/js/client:platform.js?onload=render" async defer></script>
<script>
  function render() {
    gapi.signin.render('customBtn', {
      'callback': 'signinCallback',
      'clientid': '105762385057-lsj9119fp6spbk6p0svhuuva28g5gvj5.apps.googleusercontent.com',
      'cookiepolicy': 'single_host_origin',
      'scope': 'email'
    });
  }
  function signinCallback(authResult) {
    if (authResult['status']['signed_in']) {

      // Update the app to reflect a signed in user
      // Hide the sign-in button now that the user is authorized, for example:
      document.getElementById('gSignInWrapper').setAttribute('style', 'display: none');
    } else {
      // Update the app to reflect a signed out user
      // Possible error values:
      //   "user_signed_out" - User is signed-out
      //   "access_denied" - User denied access to your app
      //   "immediate_failed" - Could not automatically log in the user
      console.log('Sign-in state: ' + authResult['error']);
    }
  }
</script>
<style type="text/css">
  #customBtn {
    display: inline-block;
    background: #dd4b39;
    color: white;
    width: 200px;
    border-radius: 5px;
    white-space: nowrap;
  }

  #customBtn:hover {
    background: #e74b37;
    cursor: hand;
  }

  span.label {
    font-weight: bold;
  }

  span.icon {
    background: url('https://developers.google.com/+/images/branding/btn_red_32.png') transparent 2px 50% no-repeat;
    display: inline-block;
    vertical-align: middle;
    width: 35px;
    height: 35px;
    border-right: #bb3f30 1px solid;
  }

  span.buttonText {
    display: inline-block;
    vertical-align: middle;
    padding-left: 10px;
    padding-right: 10px;
    font-size: 14px;
    font-weight: bold;
    /* Use the Roboto font that is loaded in the <head> */
    font-family: 'Roboto', arial, sans-serif;
  }
</style>
<div id="gSignInWrapper" style="margin:5px;padding:0px;text-align: center;float:right;">
  <div id="customBtn" class="customGPlusSignIn">
    <span class="icon"></span>
    <span class="buttonText">Sign in with Google</span>
  </div>
</div>