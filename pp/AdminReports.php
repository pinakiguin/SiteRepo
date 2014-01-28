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
  <div class="content">
    <h2>Offices</h2>
    <?php
    $Data = new MySQLiDB();
    echo 'Total Records: ' .
    $Data->ShowTable('SELECT `UserName`, COUNT(*) as `Total Offices` '
            . ' FROM `' . MySQL_Pre . 'PP_Offices` O INNER JOIN `' . MySQL_Pre . 'Users` U ON (`O`.`UserMapID`=`U`.`UserMapID`) '
            . ' Group By `U`.`UserMapID`');
    $Data->do_close();
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

