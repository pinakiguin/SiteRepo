<?php
require_once(__DIR__ . '/srer.lib.php');

WebLib::InitHTML5page("Search");
WebLib::IncludeCSS();

$Data = new MySQLiDB();

if (WebLib::GetVal($_SESSION, 'ACNo') == "")
  $_SESSION['ACNo'] = "-- Choose --";
if ((WebLib::GetVal($_SESSION, 'PartID') == "") || (WebLib::GetVal($_SESSION, 'ACNo') != WebLib::GetVal($_POST, 'ACNo')))
  $_SESSION['PartID'] = "-- Choose --";
if (intval(WebLib::GetVal($_POST, 'PartID')) > 0)
  $_SESSION['PartID'] = intval(WebLib::GetVal($_POST, 'PartID'));
if (WebLib::GetVal($_POST, 'ACNo') != "")
  $_SESSION['ACNo'] = WebLib::GetVal($_POST, 'ACNo');
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
  WebLib::ShowMenuBar('SRER')
  ?>
  <div class="content">
    <h2><?php echo AppTitle; ?></h2>
    <hr/>
    <form name="frmSRER" method="post" action="index.php">
      <label for="textfield">AC No.:</label>
      <select name="ACNo" onChange="document.frmSRER.submit();">
        <?php
        $Query = 'Select ACNo,CONCAT(ACNo,\' - \',ACName) AS ACName from ' . MySQL_Pre . 'SRER_ACs Order by ACNo';
        $Data->show_sel('ACNo', 'ACName', $Query, WebLib::GetVal($_SESSION, 'ACNo', TRUE));
        ?>
      </select>
      <label for="textfield">Part No.:</label>
      <select name="PartID">
        <?php
        $Query = 'Select PartID,CONCAT(PartNo,\' - \',PartName) as PartName from ' . MySQL_Pre . 'SRER_PartMap'
                . ' Where ACNo=\'' . WebLib::GetVal($_SESSION, 'ACNo', TRUE) . "' Order by PartNo";
        $Data->show_sel('PartID', 'PartName', $Query, WebLib::GetVal($_SESSION, 'PartID'));
        ?>
      </select>
      <?php //echo $Query;  ?>
      <input type="submit" name="FormName" value="Show" />
      <hr /><br />
    </form>
    <?php
    if (intval(WebLib::GetVal($_SESSION, 'PartID')) > 0) {
      echo "<h3>Form 6</h3>";
      $Query = 'Select `SlNo`,`ReceiptDate`,`AppName`,`DOB`,`Sex`,`RelationshipName`,`Relationship`,`Status` '
              . ' From ' . MySQL_Pre . 'SRER_Form6 Where PartID=' . WebLib::GetVal($_SESSION, 'PartID', TRUE);
      ShowSRER($Query);
      echo "<h3>Form 6A</h3>";
      $Query = 'Select `SlNo`,`ReceiptDate`,`AppName`,`DOB`,`Sex`,`RelationshipName`,`Relationship`,`Status`'
              . ' From ' . MySQL_Pre . 'SRER_Form6A Where PartID=' . WebLib::GetVal($_SESSION, 'PartID', TRUE);
      ShowSRER($Query);
      echo "<h3>Form 7</h3>";
      $Query = 'Select `SlNo`,`ReceiptDate`,`ObjectorName`,`PartNo`,`SerialNoInPart`,`DelPersonName`,`ObjectReason`,`Status`'
              . ' From ' . MySQL_Pre . 'SRER_Form7 Where PartID=' . WebLib::GetVal($_SESSION, 'PartID', TRUE);
      ShowSRER($Query);
      echo "<h3>Form 8</h3>";
      $Query = 'Select `SlNo`,`ReceiptDate`,`ElectorName`,`ElectorPartNo`,`ElectorSerialNoInPart`,`NatureObjection`,`Status`'
              . ' From ' . MySQL_Pre . 'SRER_Form8 Where PartID=' . WebLib::GetVal($_SESSION, 'PartID', TRUE);
      ShowSRER($Query);
      echo "<h3>Form 8A</h3>";
      $Query = 'Select `SlNo`,`ReceiptDate`,`AppName`,`TransName`,`TransPartNo`,`TransSerialNoInPart`,`TransEPIC`,`PreResi`,`Status`'
              . ' From ' . MySQL_Pre . 'SRER_Form8A Where PartID=' . WebLib::GetVal($_SESSION, 'PartID', TRUE);
      ShowSRER($Query);
    }
    ?>
    <br />
  </div>
  <div class="pageinfo"><?php WebLib::PageInfo(); ?></div>
  <div class="footer"><?php WebLib::FooterInfo(); ?></div>
</body>
</html>