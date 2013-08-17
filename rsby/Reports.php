<?php
require_once('../lib.inc.php');

WebLib::AuthSession();
WebLib::Html5Header('RSBY-2014');
WebLib::IncludeCSS();
if (NeedsDB) {
  WebLib::CreateDB('RSBY');
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
  WebLib::ShowMenuBar('RSBY');
  ?>
  <div class="content">
    <?php
    $Data = new MySQLiDB();
    $QryUnMatchedCount = 'Select `BlockName`,count(`RegistrationNo`) as UnMatched,'
            . 'count(`MouzaCode`) as Updated,count(`RegistrationNo`)-count(`MouzaCode`) as Remaining '
            . 'from `' . MySQL_Pre . 'RSBY_MGNREGA` group by BlockName';
    $Data->ShowTable($QryUnMatchedCount);
    //echo $QryUnMatchedCount;
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