<?php
/**
 * On successful Authentication the following Session Variables are set
 *
 *  $_SESSION['CheckAuth'] = "Valid";
 *  $_SESSION['UserName'] = $Row['UserName'];
 *  $_SESSION['UserMapID'] = $Row['UserMapID'];
 */
$FailedTry = 2; //No of Allowed failed login without captcha

require_once __DIR__ . '/lib.inc.php';
session_start();

if (WebLib::GetVal($_SESSION, 'BaseDIR') === null) {
  header('Location: index.php');
  exit();
}
$_SESSION['ET'] = microtime(true);
$Data = new MySQLiDBHelper();
$ID = WebLib::GetVal($_SESSION, 'ID');
$_SESSION['ID'] = session_id();
if (WebLib::GetVal($_SESSION, 'LifeTime') === null) {
  $_SESSION['LifeTime'] = time();
}
$action = WebLib::CheckAuth();
if ($action == "LogOut") {
  $QueryData['SessionID'] = WebLib::GetVal($_SESSION, 'ID');
  $QueryData['IP']        = $_SERVER['REMOTE_ADDR'];
  $QueryData['Referrer']  = $Data->escape($_SERVER["HTTP_REFERER"]);
  $QueryData['UserAgent'] = $_SERVER['HTTP_USER_AGENT'];
  $QueryData['UserID']    = WebLib::GetVal($_SESSION, 'UserMapID');
  $QueryData['URL']       = $Data->escape($_SERVER['PHP_SELF']);
  $QueryData['Action']    = $action . ': (' . $_SERVER['SCRIPT_NAME'] . ')';
  $QueryData['Method']    = $Data->escape($_SERVER['REQUEST_METHOD']);
  $QueryData['URI']       = $Data->escape($_SERVER['REQUEST_URI']);
  $Data->insert(TABLE_PREFIX . 'Logs', $QueryData);
  unset($QueryData);
  unset($Data);
  session_unset();
  session_destroy();
  session_start();
  $_SESSION          = array();
  $_SESSION['ET']    = microtime(true);
  $_SESSION['Debug'] = WebLib::GetVal($_SESSION, 'Debug') . $action . "TOKEN-!Valid";
  header("Location: index.php");
  exit();
} elseif ($action != "Valid") {
  WebLib::InitSess();
}

if (WebLib::GetVal($_SESSION, 'TryCount') >= $FailedTry) {
  $ValidCaptcha = WebLib::StaticCaptcha();
} else {
  $ValidCaptcha = true;
}

if ((WebLib::GetVal($_POST, 'UserPass') !== null) &&
    (WebLib::GetVal($_POST, 'UserID') !== null) &&
    $ValidCaptcha
) {
  $QueryLogin = "Select UserMapID,UserName from `" . TABLE_PREFIX . "Users` "
      . " Where `UserID`=? AND MD5(CONCAT(`UserPass`,MD5(?)))=? AND Activated";
  $filter[]   = WebLib::GetVal($_POST, 'UserID', true);
  $filter[]   = WebLib::GetVal($_SESSION, 'Token', true);
  $filter[]   = WebLib::GetVal($_POST, 'UserPass', true);

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

  } else {
    $action = "NoAccess";

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
  }
}
$_SESSION['Token'] = md5($_SERVER['REMOTE_ADDR'] . $ID . time());
WebLib::Html5Header("Login");
WebLib::IncludeCSS();
WebLib::IncludeCSS('css/forms.css');
WebLib::JQueryInclude();
WebLib::IncludeJS('js/forms.js');
WebLib::IncludeJS('js/jQuery-MD5/jquery.md5.js');
?>
<link type="text/css" rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Roboto">
<style type="text/css" media="all">
  #gSignInWrapper {
    display: inline-block;
    background: #dd4b39;
    color: white;
    border-radius: 5px;
    white-space: nowrap;
    margin: auto;
  }

  #gSignInWrapper:hover {
    background: #e74b37;
    cursor: hand;
  }

  #gSignInWrapper .icon {
    background: url('img/btn_red_32.png') transparent 2px 50% no-repeat;
    display: inline-block;
    vertical-align: middle;
    width: 35px;
    height: 35px;
    border-right: #bb3f30 1px solid;
  }

  #gSignInWrapper .buttonText {
    color: white;
    display: inline-block;
    vertical-align: middle;
    padding-left: 10px;
    padding-right: 10px;
    font-size: 14px;
    font-weight: bold;
    font-family: 'Roboto', arial, sans-serif;
    text-decoration: none;
  }
</style>
</head>
<body>
<div class="TopPanel">
  <div class="LeftPanelSide"></div>
  <div class="RightPanelSide"></div>
  <h1><?php echo APP_NAME; ?></h1>
</div>
<div class="Header">
</div>
<?php
WebLib::ShowMenuBar('WebSite');
$msgText = "";
switch ($action) {
  case "LogOut":
    $msgText = "<h2>Thank You! You Have Successfully Logged Out!</h2>";
    break;
  case "JustLoggedIn":
    $msgText = "<h2>Welcome {$_SESSION['UserName']}!</h2>";
    break;
  case "Valid":
    $msgText = "<h2>Already logged In as {$_SESSION['UserName']}!</h2>";
    break;
  case "NoAccess":
    $_SESSION['Msg']      = "Sorry! Access Denied!";
    $_SESSION['TryCount'] = WebLib::GetVal($_SESSION, 'TryCount') + 1;
    //echo "Try Count:" . WebLib::GetVal($_SESSION, 'TryCount');
    break;
}

?>
<div class="content">
  <div class="formWrapper-Autofit">
    <?php
    echo $msgText;
    if (($action != "JustLoggedIn") && ($action != "Valid")) {
      echo '<h3 class="formWrapper-h3">Login</h3>';
      WebLib::ShowMsg();
      ?>
      <?php include('googleAuth.php'); ?>
      <div style="text-align: center;">
        <div id="gSignInWrapper">
          <span class="icon"></span>
          <a class='buttonText' href='<?php echo $authUrl; ?>'>Sign in with Google</a>
        </div>
      </div>
      <hr/>
      <form name="frmLogin" method="post"
            action="<?php $_SERVER['PHP_SELF'] ?>">
        <label for="UserID">
          <strong>User ID</strong> (Registered E-Mail)
          <input type="text" id="UserID" class="form-TxtInput"
                 name="UserID" value="admin" autocomplete="off"/>
        </label>
        <label for="UserPass">
          <strong>Password</strong>
          <input type="password" id="UserPass" class="form-TxtInput"
                 name="UserPass" value="test@123" autocomplete="off"/>
        </label>
        <?php
        if (WebLib::GetVal($_SESSION, 'TryCount') >= $FailedTry) {
          WebLib::StaticCaptcha(true);
        }
        ?>
        <hr/>
        <div class="formControl">
          <input type="hidden" id="LoginToken" name="LoginToken"
                 value="<?php
                 echo WebLib::GetVal($_SESSION, 'Token');
                 ?>"/>
          <input type="submit" class="formButton" value="Login"/>
        </div>
      </form>
      <?php
      //echo WebLib::GetVal($_SESSION,'Debug');
    }
    ?>
  </div>
</div>
<div class="pageinfo">
  <?php WebLib::PageInfo(); ?>
</div>
<div class="footer">
  <?php WebLib::FooterInfo(); ?>
</div>
<?php
//print_r($_SESSION);
?>
</body>
</html>
