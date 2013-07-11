<?php
require_once('lib.inc.php');
AuthSession();
Html5Header("Users");
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
  //$Data = new MySQLiDB();
  if (GetVal($_POST, 'FormToken') !== NULL) {
    if (GetVal($_POST, 'FormToken') !== GetVal($_SESSION, 'FormToken')) {
      $action = 1;
    } else {
      // Authenticated Inputs
      $_SESSION['FormToken'] = md5($_SERVER['REMOTE_ADDR'] . session_id() . microtime());
    }
  }
  ?>
  <div class="content">
    <?php
    $Msg[0] = "<h2>Manage Users</h2>";
    $Msg[1] = "<h2>Un-Authorised</h2>";
    echo $Msg[$action];
    if (($action == 2) || ($action == 0) || ($action == 3)) {
      ?>
      <form name="frmCreateUser" id="frmCreateUser" method="post" action="<?php echo GetVal($_SERVER, 'PHP_SELF'); ?>">
        <label for="OldPassWD">User ID:</label><br />
        <input type="password" name="OldPassWD" id="OldPassWD" />
        <br />
        <input type="hidden" name="FormToken" value="<?php echo GetVal($_SESSION, 'FormToken') ?>" />
        <br />
        <input type="button" value="Save" onClick="ChkPwd('<?php echo md5(GetVal($_SESSION, 'FormToken')); ?>');" />
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

