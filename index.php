<?php
if (version_compare(phpversion(), '5.3.0', 'ge')) {
  if ((extension_loaded('mysqli') === true) && (extension_loaded('mysql') === true)) {
    include_once __DIR__ . '/lib.inc.php';
    WebLib::CreateDB();
  } else {
    die('Required PHP Extensions: mysql and mysqli  <br/> But you have: ' . implode(', ', get_loaded_extensions()));
  }
} else {
  die('Required PHP Version: 5.3 or later. <br/> You have: ' . phpversion());
}

WebLib::SetPATH();
WebLib::InitHTML5page('Home');
WebLib::IncludeCSS();
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
    <?php
    echo is_array($_POST);
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
