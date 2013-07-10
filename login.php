<?php
/**
 * On successful Authentication the following Session Variables are set
 *
 *  $_SESSION['CheckAuth'] = "Valid";
 *  $_SESSION['UserName'] = $Row['UserName'];
 *  $_SESSION['UserMapID'] = $Row['UserMapID'];
 */
require_once('lib.inc.php');
session_start();
$_SESSION['ET'] = microtime(TRUE);
$Data = new MySQLiDB();
$ID = GetVal($_SESSION, 'ID');
$_SESSION['ID'] = session_id();
if (GetVal($_SESSION, 'LifeTime') === NULL)
  $_SESSION['LifeTime'] = time();
$action = CheckAuth();
if ($action == "LogOut") {
  $Data->do_ins_query("INSERT INTO `" . MySQL_Pre . "Logs` (`SessionID`,`IP`,`Referrer`,`UserAgent`,`UserMapID`,`URL`,`Action`,`Method`,`URI`) values"
          . "('" . GetVal($_SESSION, 'ID') . "','" . $_SERVER['REMOTE_ADDR'] . "','"
          . $Data->SqlSafe($_SERVER["HTTP_REFERER"]) . "','" . $_SERVER['HTTP_USER_AGENT']
          . "','" . GetVal($_SESSION, 'UserMapID') . "','" . $Data->SqlSafe($_SERVER['PHP_SELF']) . "','"
          . $action . ": (" . $_SERVER['SCRIPT_NAME'] . ")','" . $Data->SqlSafe($_SERVER['REQUEST_METHOD'])
          . "','" . $Data->SqlSafe($_SERVER['REQUEST_URI']) . "');");
  session_unset();
  session_destroy();
  session_start();
  $_SESSION = array();
  $_SESSION['Debug'] = GetVal($_SESSION, 'Debug') . $action . "TOKEN-!Valid";
  header("Location: index.php");
  exit;
}

if ($action != "Valid") {
  initSess();
}

if ((GetVal($_POST, 'UserID') !== NULL) && (GetVal($_POST, 'UserPass') !== NULL)) {
  $QueryLogin = "Select UserMapID,UserName from `" . MySQL_Pre . "Users` U "
          . "where `UserID`='" . GetVal($_POST, 'UserID', TRUE) . "' AND MD5(concat(`UserPass`,MD5('"
          . GetVal($_POST, 'LoginToken', TRUE) . "')))='" . GetVal($_POST, 'UserPass', TRUE) . "' AND Activated";
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
            "Update " . MySQL_Pre . "Users Set LoginCount=LoginCount+1 where `UserID`='" .
            GetVal($_POST, 'UserID', TRUE) . "' AND MD5(concat(`UserPass`,MD5('"
            . GetVal($_POST, 'LoginToken', TRUE) . "')))='" . GetVal($_POST, 'UserPass', TRUE) . "'");
    $Data->do_ins_query(
            "INSERT INTO " . MySQL_Pre . "Logs (`SessionID`,`IP`,`Referrer`,`UserAgent`,`UserMapID`,`URL`,`Action`,`Method`,`URI`) values"
            . "('" . GetVal($_SESSION, 'ID', TRUE) . "','" . $_SERVER['REMOTE_ADDR'] . "','"
            . $Data->SqlSafe($_SERVER['HTTP_REFERER']) . "','" . $_SERVER['HTTP_USER_AGENT']
            . "','" . GetVal($_SESSION, 'UserMapID', TRUE) . "','" . $Data->SqlSafe($_SERVER['PHP_SELF']) .
            "','Login: Success','" . $Data->SqlSafe($_SERVER['REQUEST_METHOD'])
            . "','" . $Data->SqlSafe($_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']) . "');");
  } else {
    $action = "NoAccess";
    $Data->do_ins_query(
            "INSERT INTO " . MySQL_Pre . "logs (`SessionID`,`IP`,`Referrer`,`UserAgent`,`UserMapID`,`URL`,`Action`,`Method`,`URI`) values"
            . "('" . GetVal($_SESSION, 'ID') . "','" . $_SERVER['REMOTE_ADDR'] . "','" .
            $Data->SqlSafe($_SERVER['HTTP_REFERER']) . "','" .
            $_SERVER['HTTP_USER_AGENT'] . "','" . GetVal($_POST, 'UserID') . "','" .
            $Data->SqlSafe($_SERVER['PHP_SELF']) .
            "','Login: Failed[" . GetVal($_POST, 'UserID') . "]','" . $Data->SqlSafe($_SERVER[
                    'REQUEST_METHOD']) . "','" . $Data->SqlSafe($_SERVER[
                    'REQUEST_URI'] . $_SERVER['QUERY_STRING']) . "');");
  }
}
$_SESSION['Token'] = md5($_SERVER['REMOTE_ADDR'] . $ID . time());
Html5Header("Login");
IncludeCSS();
jQueryInclude();
IncludeJS("js/md5.js");
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
  ShowMenuBar();
  ?>
  <div class="content">
    <?php
    switch ($action) {
      case "LogOut":
        echo
        "<h2 align=\"center\">Thank You! You Have Successfully Logged Out!</h2>";
        break;
      case "JustLoggedIn":
        echo "<h2 align=\"center\">Welcome " . GetVal($_SESSION, 'UserName') .
        " You Have Successfully Logged In!</h2>";
        break;
      case "Valid":
        echo "<h2 align=\"center\">You are already Logged In as " . GetVal($_SESSION, 'UserName') . "!</h2>";
        break;
      case "NoAccess":
        echo "<h2 align=\"center\">Sorry! Access Denied!</h2>";
        $_SESSION['TryCount'] = GetVal($_SESSION, 'TryCount') + 1;
        break;
      default:
        echo "<h2>Login - " . AppTitle . "</h2>";
        break;
    }
    if (($action != "JustLoggedIn") && ($action != "Valid")) {
      ?>
      <form name="frmLogin" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
        <label for="UserID">User ID:</label><br />
        <input type="text" id="UserID" name="UserID" value="admin" autocomplete="off"/><br />
        <label for="UserPass">Password:</label><br />
        <input type="password" id="UserPass" name="UserPass" value="test@123" autocomplete="off"/><br />
        <input type="hidden" name="LoginToken" value="<?php echo GetVal($_SESSION, 'Token'); ?>" />
        <input style="width:80px;" type="submit" value="Login" onClick="document.getElementById('UserPass').value = MD5(MD5(document.getElementById('UserPass').value) + '<?php echo md5(GetVal($_SESSION, 'Token')); ?>');"/>
      </form>
      <p><b>Register: </b><a href="Register.php">Click here</a> to register yourself</p>
      <?php
      //echo GetVal($_SESSION,'Debug');
    }
    ?>
  </div>
  <div class="pageinfo">
    <?php pageinfo(); ?>
  </div>
  <div class="footer">
    <?php footerinfo(); ?>
  </div>
  <?php
//print_r($_SESSION);
  ?>
</body>
</html>
