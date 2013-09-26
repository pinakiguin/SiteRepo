<?php
require_once(__DIR__ . '/../lib.inc.php');

WebLib::AuthSession();
WebLib::Html5Header('Attendance Report');
WebLib::IncludeCSS();

$Data = new MySQLiDB();
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
  WebLib::ShowMenuBar('ATND');
  ?>
  <div class="content">
    <h2>Attendance Report</h2>
    <hr/>
    <form name="frmAtndRpt" method="post" action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>">
      <label for="textfield">Month:</label>
      <select name="MonYr">
        <?php
        $Query = 'Select DATE_FORMAT(`InDateTime`,"%m-%Y") as `MonYr`,'
                . ' DATE_FORMAT(`InDateTime`,"%b-%Y") as `MonthYear` FROM `' . MySQL_Pre . 'ATND_Register`'
                . ' Where `UserMapID`=' . $_SESSION['UserMapID'] . '  GROUP BY DATE_FORMAT(`InDateTime`,"%m-%Y")';
        $Data->show_sel('MonYr', 'MonthYear', $Query, WebLib::GetVal($_POST, 'MonYr'));
        ?>
      </select>
      <?php //echo $Query;   ?>
      <input type="submit" name="FormName" value="Show" />
      <hr /><br />
    </form>
    <?php
    $Query = 'SELECT DATE_FORMAT(`InDateTime`,"%d-%m-%Y") as `Attendance Date`, '
            . ' DATE_FORMAT(`InDateTime`,"%r") as `In Time`, '
            . ' DATE_FORMAT(`OutDateTime`,"%r") as `Out Time` FROM `' . MySQL_Pre . 'ATND_Register`'
            . ' WHERE DATE_FORMAT(`InDateTime`,"%m-%Y")=\'' . WebLib::GetVal($_POST, 'MonYr', true) . '\''
            . ' AND `UserMapID`=' . $_SESSION['UserMapID'] . ' ORDER BY `AtndID`;';
    $Data->ShowTable($Query);
    $Data->do_close();
    ?>
    <br />
  </div>
  <div class="pageinfo"><?php WebLib::PageInfo(); ?></div>
  <div class="footer"><?php WebLib::FooterInfo(); ?></div>
</body>
</html>