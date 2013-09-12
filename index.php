<?php
if (strnatcmp(phpversion(), '5.3') >= 0) {
  if ((extension_loaded('mysqli') === true) && (extension_loaded('mysql') === true)) {
    include_once __DIR__ . '/lib.inc.php';
    if (NeedsDB) {
      WebLib::CreateDB("WebSite");
      WebLib::CreateDB("SRER");
    }
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
    $Data = new MySQLiDB();
    $Query = 'Select `W`.`SessionID`,`W`.`UserID`,`U`.`UserName`,`W`.`Action`,`W`.`AccessTime` FROM '
            . '(Select `UserID`,Max(`LogID`) as `LogID` FROM `' . MySQL_Pre . 'Logs`'
            . ' Where `UserID`>0 AND (`AccessTime`+0)>(CURRENT_TIMESTAMP -(' . LifeTime . ' * 60)) '
            . ' Group By `UserID`,`SessionID` HAVING MAX(`LogID`)) as `L`'
            . ' JOIN `' . MySQL_Pre . 'Logs` as `W` '
            . ' ON (`W`.`LogID`=`L`.`LogID` AND `Action` NOT LIKE \'LogOut:%\')'
            . ' JOIN `' . MySQL_Pre . 'Users` as `U` '
            . ' ON (`W`.`UserID`=`U`.`UserMapID`)';
    $QueryUsers = 'Select `U`.`UserName`,`W`.`Action`,`W`.`AccessTime` FROM '
            . '(Select `UserID`,Max(`LogID`) as `LogID` FROM `' . MySQL_Pre . 'Logs`'
            . ' Where `UserID`>0 AND (`AccessTime`+0)>(CURRENT_TIMESTAMP -(' . LifeTime . ' * 60)) '
            . ' Group By `UserID`,`SessionID` HAVING MAX(`LogID`)) as `L`'
            . ' JOIN `' . MySQL_Pre . 'Logs` as `W` '
            . ' ON (`W`.`LogID`=`L`.`LogID` AND `Action` NOT LIKE \'LogOut:%\')'
            . ' JOIN `' . MySQL_Pre . 'Users` as `U` '
            . ' ON (`W`.`UserID`=`U`.`UserMapID`)';
    echo "<b>Currently Active Users: </b>" . $Data->do_sel_query($Query);
    if (WebLib::GetVal($_SESSION, 'CheckAuth') === 'Valid') {
      $Data->ShowTable($Query);
    } else {
      $Data->ShowTable($QueryUsers);
    }
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
