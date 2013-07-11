<?php
require_once('lib.inc.php');
AuthSession();
Html5Header("Profile");
IncludeCSS();
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
  $action = 0;
  $Data = new MySQLiDB();
  if (GetVal($_POST, 'FormToken') !== NULL) {
    if (GetVal($_POST, 'FormToken') !== GetVal($_SESSION, 'FormToken')) {
      $action = 4;
    } else {
      if (GetVal($_POST, 'NewPassWD') !== md5(GetVal($_POST, 'CNewPassWD') . md5(GetVal($_SESSION, 'FormToken')))) {
        $action = 3;
      } else {
        $Qry = "Update `" . MySQL_Pre . "Users` set UserPass='" . $Data->SqlSafe(GetVal($_POST, 'CNewPassWD'))
                . "' where UserMapID=" . $_SESSION['UserMapID'] . " AND "
                . "md5(concat(`UserPass`,md5('" . GetVal($_POST, 'FormToken') . "')))='"
                . GetVal($_POST, 'OldPassWD') . "'";
        $rows = $Data->do_ins_query($Qry);
        if ($rows > 0) {
          $action = 1;
        } else {
          $action = 2;
        }
      }
      $_SESSION['FormToken'] = md5($_SERVER['REMOTE_ADDR'] . session_id() . microtime());
    }
  }
  ?>
  <div class="content">
    <?php
    $Msg[0] = "<h2>Change Password</h2>";
    $Msg[1] = "<h2>Your password changed Successfully!</h2>";
    $Msg[2] = "<h2>Sorry! Invalid Old Password!</h2>";
    $Msg[3] = "<h2>New Passwords do not match.</h2>";
    $Msg[4] = "<h2>Un-Authorised " . GetVal($_POST, 'FormToken') . "|" . GetVal($_SESSION, 'FormToken') . "</h2>";
    echo $Msg[$action];
    if (($action == 2) || ($action == 0) || ($action == 3)) {
      ?>
      <form name="frmChgPWD" id="frmChgPWD" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="OldPassWD">Old Password:</label><br />
        <input type="password" name="OldPassWD" id="OldPassWD" />
        <br />
        <label for="NewPassWD">New Password:</label> <br />
        <input type="password" name="NewPassWD" id="NewPassWD" />
        <br />
        <label for="CNewPassWD">Confirm New Password:</label> <br />
        <input type="password" name="CNewPassWD" id="CNewPassWD" />
        <input type="hidden" name="FormToken" value="<?php echo GetVal($_SESSION, 'FormToken') ?>" />
        <br />
        <input type="button" value="Change Password" onClick="ChkPwd('<?php echo md5(GetVal($_SESSION, 'FormToken')); ?>');" />
      </form>
      <?php
    }
    ?>
  </div>
  <div class="pageinfo">
    <?php pageinfo(); ?>
  </div>
  <div class="footer">
    <?php footerinfo(); ?>
  </div>
</body>
</html>

