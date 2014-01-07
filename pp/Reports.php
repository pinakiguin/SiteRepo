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
    echo 'Total Records: ' . $Data->ShowTable('SELECT `OfficeName` as `Name of the Office`, `DesgOC` as `Designation of Officer-in-Charge`, '
            . '`AddrPTS` as `Para/Tola/Street`, `AddrVTM` as `Village/Town/Street`, `PostOffice`, `PSCode`,`PinCode`, '
            . '`Status` as `Nature`, `TypeCode` as `Status`, `Phone`, `Fax`, `Mobile`, `EMail`, `Staffs`, `ACNo` '
            . 'FROM `' . MySQL_Pre . 'PP_Offices` WHERE `UserMapID`=' . $_SESSION['UserMapID']);
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

