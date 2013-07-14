<?php
require_once('lib.inc.php');
WebLib::AuthSession();
WebLib::Html5Header("Profile");
WebLib::IncludeCSS();
WebLib::IncludeJS("js/md5.js");
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
  WebLib::ShowMenuBar();
  $action = 0;
  $Data = new MySQLiDB();
  if (WebLib::GetVal($_POST, 'FormToken') !== NULL) {
    if (WebLib::GetVal($_POST, 'FormToken') !== WebLib::GetVal($_SESSION, 'FormToken')) {
      $action = 4;
    } else {
      if (WebLib::GetVal($_POST, 'NewPassWD') !== md5(WebLib::GetVal($_POST, 'CNewPassWD') . md5(WebLib::GetVal($_SESSION, 'FormToken')))) {
        $action = 3;
      } elseif (preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", WebLib::GetVal($_POST, 'NewPassWD'))) {
        $Qry = "Update `" . MySQL_Pre . "Users` set UserPass='" . WebLib::GetVal($_POST, 'CNewPassWD', TRUE)
                . "' where UserMapID=" . WebLib::GetVal($_SESSION, 'UserMapID') . " AND "
                . "md5(concat(`UserPass`,md5('" . WebLib::GetVal($_POST, 'FormToken') . "')))='"
                . WebLib::GetVal($_POST, 'OldPassWD') . "'";
        $rows = $Data->do_ins_query($Qry);
        if ($rows > 0) {
          $action = 1;
        } else {
          $action = 2;
        }
      } else {
        $action = 5;
      }
    }
    $_SESSION['FormToken'] = md5($_SERVER['REMOTE_ADDR'] . session_id() . microtime());
  }
  ?>
  <div class="content">
    <?php
    echo "<h2>Change Password</h2>";
    $Msg[0] = NULL;
    $Msg[1] = "<b>Your password changed Successfully!</b>";
    $Msg[2] = "<b>Sorry! Invalid Old Password!</b>";
    $Msg[3] = "<b>New Passwords do not match.</b>";
    $Msg[4] = "<b>Un-Authorised " . WebLib::GetVal($_POST, 'FormToken') . "|" . WebLib::GetVal($_SESSION, 'FormToken') . "</b>";
    $Msg[5] = "<b>Your password is not safe.</b>";

    $_SESSION['Msg'] = $Msg[$action];
    WebLib::ShowMsg();
    if ($action !== 4) {
      ?>
      <form name="frmChgPWD" id="frmChgPWD" method="post" action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>">
        <label for="OldPassWD">Old Password:</label><br />
        <input type="password" name="OldPassWD" id="OldPassWD" />
        <br />
        <label for="NewPassWD">New Password:</label> <br />
        <input type="password" name="NewPassWD" id="NewPassWD" />
        <br />
        <label for="CNewPassWD">Confirm New Password:</label> <br />
        <input type="password" name="CNewPassWD" id="CNewPassWD" />
        <input type="hidden" name="FormToken" value="<?php echo WebLib::GetVal($_SESSION, 'FormToken'); ?>" />
        <br />
        <input type="button" value="Change Password" onClick="ChkPwd('<?php echo md5(WebLib::GetVal($_SESSION, 'FormToken')); ?>');" />
      </form>
      <?php
    }
    ?>
  </div>
  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>

