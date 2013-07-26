<?php
require_once('../lib.inc.php');

WebLib::AuthSession();
WebLib::Html5Header("Panchayat Election 2013");
WebLib::IncludeCSS();
if (NeedsDB) {
  WebLib::CreateDB("CP");
}
?>
</head>
<body>
  <div class="TopPanel">
    <div class="LeftPanelSide"></div>
    <div class="RightPanelSide"></div>
    <h1><?php echo AppTitle; ?></h1>
  </div>
  <div class="Header"></div>
  <?php
  WebLib::ShowMenuBar('CP');
  ?>
  <div class="content">
    <span class="Message" id="Msg" style="float: right;"></span>
    <input type="hidden" id="AjaxToken" value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
    <pre id="Error"></pre>
  </div>
  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>

