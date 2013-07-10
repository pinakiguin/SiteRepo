<?php
include_once 'lib.inc.php';

if (NeedsDB)
  CreateDB("WebSite");

initHTML5page("Home");
IncludeCSS();
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
    if (GetVal($_POST, 'CmdSubmit') !== NULL) {
      if (StaticCaptcha()) {
        $_SESSION['Msg'] = "Valid";
      } else {
        $_SESSION['Msg'] = "In-Valid";
      }
    }
    ShowMsg();
    ?>
    <form method="post" action="index.php">
      <?php StaticCaptcha(TRUE); ?>
      <input name="CmdSubmit" type="submit" value="Login" />
    </form>
  </div>
  <div class="pageinfo">
    <?php pageinfo(); ?>
  </div>
  <div class="footer">
    <?php footerinfo(); ?>
  </div>
</body>
</html>
