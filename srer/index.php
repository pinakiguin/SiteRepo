<?php
require_once('../lib.inc.php');

WebLib::AuthSession();
WebLib::Html5Header("SRER-2014");
WebLib::IncludeCSS();
if (NeedsDB) {
  WebLib::CreateDB("SRER");
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
  WebLib::ShowMenuBar('SRER');
  ?>
  <div class="content">
    <span class="Message" id="Msg" style="float: right;"></span>
    <?php
    $Data = new MySQLiDB();
    $Query = 'Select `W`.`SessionID`,`W`.`UserID`,`Action`,`AccessTime` FROM '
            . '(Select `UserID`,Max(`LogID`) as `LogID` FROM `' . MySQL_Pre . 'Logs`'
            . ' Where `UserID`>0 AND (`AccessTime`+0)>(CURRENT_TIMESTAMP -(' . LifeTime . ' * 60)) '
            . ' Group By `UserID`,`SessionID` HAVING MAX(`LogID`)) as `L` JOIN `' . MySQL_Pre . 'Logs` as `W` '
            . ' ON (`W`.`LogID`=`L`.`LogID` AND `Action` NOT LIKE \'LogOut:%\')';
    echo "<b>Currently Active Users: </b>" . $Data->do_sel_query($Query);
    if (WebLib::GetVal($_SESSION, 'CheckAuth') === 'Valid') {
      $Data->ShowTable($Query);
    }
    $Data->do_close();
    WebLib::ShowMsg();
    ?>
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

