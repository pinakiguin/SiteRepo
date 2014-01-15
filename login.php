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

if (WebLib::GetVal($_SESSION, 'BaseDIR') === NULL) {
  header('Location: index.php');
  exit();
}
$_SESSION['ET'] = microtime(TRUE);
$Data = new MySQLiDB();
$ID = WebLib::GetVal($_SESSION, 'ID');
$_SESSION['ID'] = session_id();
if (WebLib::GetVal($_SESSION, 'LifeTime') === NULL)
  $_SESSION['LifeTime'] = time();
$action = WebLib::CheckAuth();
if ($action == "LogOut") {
  $Query = "INSERT INTO `" . MySQL_Pre . "Logs` (`SessionID`,`IP`,`Referrer`,`UserAgent`,`UserID`,`URL`,`Action`,`Method`,`URI`)"
          . " Values('" . WebLib::GetVal($_SESSION, 'ID') . "','" . $_SERVER['REMOTE_ADDR'] . "','"
          . $Data->SqlSafe($_SERVER["HTTP_REFERER"]) . "','"
          . $_SERVER['HTTP_USER_AGENT']
          . "','" . WebLib::GetVal($_SESSION, 'UserMapID') . "','"
          . $Data->SqlSafe($_SERVER['PHP_SELF']) . "','"
          . $action . ": (" . $_SERVER['SCRIPT_NAME'] . ")','"
          . $Data->SqlSafe($_SERVER['REQUEST_METHOD']) . "','"
          . $Data->SqlSafe($_SERVER['REQUEST_URI']) . "');";
  $Data->do_ins_query($Query);
  $Data->do_close();
  unset($Data);
  session_unset();
  session_destroy();
  session_start();
  $_SESSION = array();
  $_SESSION['ET'] = microtime(TRUE);
  $_SESSION['Debug'] = WebLib::GetVal($_SESSION, 'Debug') . $action . "TOKEN-!Valid";
  header("Location: index.php");
  exit;
} elseif ($action != "Valid") {
  WebLib::InitSess();
}

if (WebLib::GetVal($_SESSION, 'TryCount') >= $FailedTry) {
  $ValidCaptcha = WebLib::StaticCaptcha();
} else {
  $ValidCaptcha = TRUE;
}

if ((WebLib::GetVal($_POST, 'UserID') !== NULL) && (WebLib::GetVal($_POST, 'UserPass') !== NULL) && $ValidCaptcha) {
  $QueryLogin = "Select UserMapID,UserName from `" . MySQL_Pre . "Users` "
          . " Where `UserID`='" . WebLib::GetVal($_POST, 'UserID', TRUE) . "' "
          . " AND MD5(concat(`UserPass`,MD5('" . WebLib::GetVal($_SESSION, 'Token', TRUE) . "')))='" . WebLib::GetVal($_POST, 'UserPass', TRUE) . "'"
          . " AND Activated";
  $rows = $Data->do_sel_query($QueryLogin);
  if ($rows > 0) {
    session_regenerate_id();
    $Row = $Data->get_row();
    $_SESSION['CheckAuth'] = "Valid";
    $_SESSION['UserName'] = $Row['UserName'];
    $_SESSION['UserMapID'] = $Row['UserMapID'];
    $_SESSION['ID'] = session_id();
    $_SESSION['FingerPrint'] = md5($_SERVER['REMOTE_ADDR'] . $_SERVER[
            'HTTP_USER_AGENT'] . "KeyLeft");
    $_SESSION['REFERER1'] = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER[
            'REQUEST_URI'];
    $action = "JustLoggedIn";
    $Data->do_ins_query(
            "Update " . MySQL_Pre . "Users Set LoginCount=LoginCount+1"
            . " Where `UserID`='" . WebLib::GetVal($_POST, 'UserID', TRUE) . "'"
            . " AND MD5(concat(`UserPass`,MD5('" . WebLib::GetVal($_POST, 'LoginToken', TRUE) . "')))='" . WebLib::GetVal($_POST, 'UserPass', TRUE) . "'");
    $Data->do_ins_query(
            "INSERT INTO " . MySQL_Pre . "Logs (`SessionID`,`IP`,`Referrer`,`UserAgent`,`UserID`,`URL`,`Action`,`Method`,`URI`) "
            . "Values ('" . WebLib::GetVal($_SESSION, 'ID', TRUE) . "','"
            . $Data->SqlSafe($_SERVER['REMOTE_ADDR']) . "','"
            . $Data->SqlSafe($_SERVER['HTTP_REFERER']) . "','"
            . $Data->SqlSafe($_SERVER['HTTP_USER_AGENT']) . "','" . WebLib::GetVal($_SESSION, 'UserMapID', TRUE) . "','"
            . $Data->SqlSafe($_SERVER['PHP_SELF']) . "','Login: Success','"
            . $Data->SqlSafe($_SERVER['REQUEST_METHOD']) . "','"
            . $Data->SqlSafe($_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']) . "');");
  } else {
    $action = "NoAccess";
    $Data->do_ins_query(
            "INSERT INTO " . MySQL_Pre . "Logs (`SessionID`,`IP`,`Referrer`,`UserAgent`,`UserID`,`URL`,`Action`,`Method`,`URI`,`ED`) "
            . "Values ('" . WebLib::GetVal($_SESSION, 'ID', TRUE) . "','"
            . $Data->SqlSafe($_SERVER['REMOTE_ADDR']) . "','"
            . $Data->SqlSafe($_SERVER['HTTP_REFERER']) . "','"
            . $Data->SqlSafe($_SERVER['HTTP_USER_AGENT']) . "','" . WebLib::GetVal($_POST, 'UserID', TRUE) . "','"
            . $Data->SqlSafe($_SERVER['PHP_SELF']) . "','Login: Failed[" . WebLib::GetVal($_POST, 'UserID', TRUE) . "]','"
            . $Data->SqlSafe($_SERVER['REQUEST_METHOD']) . "','"
            . $Data->SqlSafe($_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']) . "',"
            . WebLib::GetVal($_SESSION, 'ED', TRUE) . ");");
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
</head>
<body>
  <div class="TopPanel">
    <div class="LeftPanelSide"></div>
    <div class="RightPanelSide"></div>
    <h1><?php echo AppTitle; ?></h1>
  </div>
  <div class="Header">
  </div>
  <?php
  WebLib::ShowMenuBar('WebSite');
  ?>
  <div class="content">
    <div class="formWrapper">
      <?php
      switch ($action) {
        case "LogOut":
          echo
          "<h2>Thank You! You Have Successfully Logged Out!</h2>";
          break;
        case "JustLoggedIn":
          echo "<h2>Welcome {$_SESSION['UserName']}!</h2>";
          break;
        case "Valid":
          echo "<h2>Already logged In as {$_SESSION['UserName']}!</h2>";
          break;
        case "NoAccess":
          $_SESSION['Msg'] = "Sorry! Access Denied!";
          $_SESSION['TryCount'] = WebLib::GetVal($_SESSION, 'TryCount') + 1;
          //echo "Try Count:" . WebLib::GetVal($_SESSION, 'TryCount');
          break;
      }
      if (($action != "JustLoggedIn") && ($action != "Valid")) {
        echo "<h3>Login</h3>";
        WebLib::ShowMsg();
        ?>
        <form name="frmLogin" method="post"
              action="<?php $_SERVER['PHP_SELF'] ?>" >
          <label for="UserID">
            <strong>User ID</strong> (Registered E-Mail)
            <input type="text" id="UserID" name="UserID"
                   value="admin" autocomplete="off"/>
          </label>
          <label for="UserPass">
            <strong>Password</strong>
            <input type="password" id="UserPass" name="UserPass"
                   value="test@123" autocomplete="off"/>
          </label>
          <?php
          if (WebLib::GetVal($_SESSION, 'TryCount') >= $FailedTry) {
            WebLib::StaticCaptcha(TRUE);
          }
          ?>
          <div class="formControl">
            <input type="hidden" id="LoginToken" name="LoginToken"
                   value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
            <input type="submit" value="Login" />
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
