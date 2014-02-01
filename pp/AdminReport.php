<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Reports');
WebLib::IncludeCSS();
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
  WebLib::ShowMenuBar('PP');
  ?>
  <div class="content" style="display: table;">
    <?php
    $Data = new MySQLiDB();

    echo '<div style="width:300px;float:left;margin:10px;">';
    echo '<h3>Data Entry Count</h3>';
    $Data->ShowTable('Select * FROM `WebSite_NoDefs_CountPP2`');
    echo '</div>';

    echo '<div style="width:800px;float:left;margin:10px;">';
    echo '<h3>Last 10 Entries</h3>';
    $Data->ShowTable('Select LastUpdatedOn,EmpSL,EmpName,DOB,BankACNo,OfficeSL'
        . ' FROM `' . MySQL_Pre . 'PP_Personnel` '
        . ' Order By LastUpdatedOn desc limit 10');
    echo '<h3>Total Entry</h3>';
    $Query = 'SELECT `SexId` as `Gender`,COUNT(*)as `Total` '
        . ' FROM `WebSite_PP_Personnel` GROUP BY `SexId`';
    $Users = $Data->ShowTable($Query);
    echo '</div>';
    unset($Data);
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

