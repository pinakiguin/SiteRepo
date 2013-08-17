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
    <span class = "Message"><?php
      $Data = new MySQLiDB();
      $QryUnMatchedCount = "Select count(`RegistrationNo`)-count(`NewMouzaCode`) from `RSBY_MGNREGA`";
      $Total = $Data->do_max_query("Select count(*)+1 from RSBY_MGNREGA");
      $Rem = $Data->do_max_query($QryUnMatchedCount);
      echo "Total UnMatched (" . ($Total - 1) . ") Remaining (" . $Rem . "-" . round($Rem / $Total * 100, 2) . "%) Done (" . (($Total - 1) - $Rem) . "-" . (100 - round($Rem / $Total * 100, 2)) . "%)";
      ?></span>
    <?php
    $QryUnMatchedCount = "Select `BlockName`,count(`RegistrationNo`) as UnMatched,count(`NewMouzaCode`) as Updated,count(`RegistrationNo`)-count(`NewMouzaCode`) as Remaining from `RSBY_MGNREGA` group by BlockName";
    $Data->ShowTable($QryUnMatchedCount);
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