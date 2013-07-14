<?php
include_once 'lib.inc.php';

if (NeedsDB) {
  WebLib::CreateDB("WebSite");
  WebLib::CreateDB("SRER");
}

WebLib::InitHTML5page("Home");
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
  WebLib::ShowMenuBar();
  ?>
  <div class="content">
    <?php
    WebLib::ShowMsg();
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
