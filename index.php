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
    $Data = new MySQLiDB();
    $Query = 'Select `W`.`UserID`,`Action`,`AccessTime` FROM '
            . '(Select `UserID`,Max(`LogID`) as `LogID` FROM `' . MySQL_Pre . 'Logs`'
            . ' Group By `UserID`) as `L` JOIN `' . MySQL_Pre . 'Logs` as `W` '
            . ' ON (`W`.`LogID`=`L`.`LogID` AND `Action` NOT LIKE \'LogOut:%\')';
    echo "<b>Currently Active Users: </b>" . $Data->do_sel_query($Query);
    $Data->do_close();
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
