<?php
require_once __DIR__ . '/../lib.inc.php';
WebLib::AuthSession();
WebLib::Html5Header('Attendance Register');
WebLib::IncludeCSS();
WebLib::JQueryInclude();

function PrintArr($Arr) {
  echo '<pre>';
  print_r($Arr);
  echo '</pre>';
}
?>
<script type="text/javascript" >
  $(function() {
    $('input[type="submit"]').button();
    $('input[type="button"]').button();
  });
</script>
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
    <h2>Attendance Register</h2>
    <form name="frmEditUser" id="frmAssignParts" method="post" action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>">
      <?php
      $Data = new MySQLiDB();

      if (WebLib::GetVal($_POST, 'CmdAtnd') !== null) {
        if ($_SESSION['InOut'] === 'In') {
          $AtndQuery = 'INSERT INTO `' . MySQL_Pre . 'ATND_Register` (`UserMapID`, `InDateTime`) '
                  . 'VALUES (' . $_SESSION['UserMapID'] . ',FROM_UNIXTIME(' . $_SESSION['ATND_TIME'] . '));';
        } else {
          $AtndQuery = 'Update `' . MySQL_Pre . 'ATND_Register` '
                  . 'Set `OutDateTime`=FROM_UNIXTIME(' . $_SESSION['ATND_TIME'] . ')'
                  . ' Where `AtndID`=' . $_SESSION['AtndID'] . ';';
        }
        $_SESSION['Query'] = $AtndQuery;
        if ($Data->do_ins_query($AtndQuery) > 0) {
          $_SESSION['Msg'] = 'Attendance Registered!';
        } else {
          $_SESSION['Msg'] = 'Unable to Register Attendance!';
        }
      }

      WebLib::ShowMsg();

      $Query = 'SELECT Max(`AtndID`) as `AtndID` FROM `' . MySQL_Pre . 'ATND_Register`'
              . ' WHERE `UserMapID`=' . $_SESSION['UserMapID'] . ' AND `InDateTime`>CURDATE();';
      $_SESSION['AtndID'] = $Data->do_max_query($Query);

      $InOut['In Time'] = null;

      $Query = 'SELECT DATE_FORMAT(`InDateTime`,"%d-%m-%Y") as `Attendance Date`, '
              . ' DATE_FORMAT(`InDateTime`,"%r") as `In Time`, '
              . ' DATE_FORMAT(`OutDateTime`,"%r") as `Out Time` FROM `' . MySQL_Pre . 'ATND_Register`'
              . ' WHERE `UserMapID`=' . $_SESSION['UserMapID'] . ' ORDER BY `AtndID`;';

      $_SESSION['ATND_TIME'] = time();
      $_SESSION['InOut'] = ($_SESSION['AtndID'] === 0 ? 'In' : 'Out');
      ?>
      <span class="Notice"><b style="font-size:large;">Attendance for <?php echo date('d-m-Y') . ':'; ?></b>
        <input class="button" name="CmdAtnd" id="CmdAtnd" type="submit"
               value="<?php echo $_SESSION['InOut'] . ' : ' . date('H:i:s a', $_SESSION['ATND_TIME']); ?>"/>
      </span>
    </form>
    <?php
    //PrintArr($_SESSION);
    $Data->ShowTable($Query);
    $Data->do_close();
    ?>
    <div style="clear:both;"></div>
  </div>
  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>
