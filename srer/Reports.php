<?php
require_once(__DIR__ . '/srer.lib.php');
switch (WebLib::GetVal($_POST, 'FormName')) {
  case 'Save as PDF':
    include __DIR__ . '/ShowPDF.php';
    exit();
    break;
  case 'Download Manuscript':
    $_SESSION['Datewise'] = '0';
    include __DIR__ . '/Manuscript.php';
    exit();
    break;
  case 'Download Datewise Manuscript':
    include __DIR__ . '/Manuscript.php';
    exit();
    break;
}

WebLib::AuthSession();
WebLib::Html5Header('SRER Report');
WebLib::IncludeCSS();

$Data = new MySQLiDBHelper();

if (WebLib::GetVal($_SESSION, 'ACNo') == "") {
  $_SESSION['ACNo'] = "-- Choose --";
}
if ((WebLib::GetVal($_SESSION, 'PartID') == "") || (WebLib::GetVal($_SESSION, 'ACNo') != WebLib::GetVal($_POST, 'ACNo'))) {
  $_SESSION['PartID'] = "-- Choose --";
}
if (intval(WebLib::GetVal($_POST, 'PartID')) > 0) {
  $_SESSION['PartID'] = intval(WebLib::GetVal($_POST, 'PartID'));
}
if (WebLib::GetVal($_POST, 'ACNo') != "") {
  $_SESSION['ACNo'] = WebLib::GetVal($_POST, 'ACNo');
}
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
WebLib::ShowMenuBar('SRER');
?>
<div class="content">
  <h2>SRER Reports</h2>
  <hr/>
  <form name="frmSRER" method="post" action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>">
    <label for="textfield">AC No.:</label>
    <select name="ACNo" onChange="document.frmSRER.submit();">
      <?php
      $Query = 'Select ACNo,CONCAT(ACNo,\' - \',ACName) AS ACName from ' . MySQL_Pre . 'SRER_ACs'
        . ' Where `DistCode`=' . DistCode . ' Order by ACNo';
      WebLib::showSelect('ACNo', 'ACName', $Query, WebLib::GetVal($_SESSION, 'ACNo', TRUE));
      ?>
    </select>
    <label for="PartID">Part No.:</label>
    <select id="PartID" name="PartID">
      <?php
      $Query = 'Select PartID,CONCAT(PartNo,\' - \',PartName) as PartName from ' . MySQL_Pre . 'SRER_PartMap'
        . ' Where ACNo=' . intval(WebLib::GetVal($_SESSION, 'ACNo', TRUE)) . ' Order by PartNo';
      WebLib::showSelect('PartID', 'PartName', $Query, WebLib::GetVal($_SESSION, 'PartID'));
      ?>
    </select>
    <?php //echo $Query;  ?>
    <input type="submit" name="FormName" value="Show"/>
    <input type="submit" name="FormName" value="Save as PDF"/>
    <input type="submit" id="DateTo" name="FormName" value="Download Manuscript"/><br/>
    <label for="DateFrom">Date of Receipt From:</label>
    <input type="text" id="DateFrom" name="DateFrom" placeholder="YYYY-MM-DD"
           value="<?php echo WebLib::GetVal($_SESSION, 'DateFrom'); ?>"/>
    <label for="DateTo">To:</label>
    <input type="text" name="DateTo" placeholder="YYYY-MM-DD"
           value="<?php echo WebLib::GetVal($_SESSION, 'DateTo'); ?>"/>
    <input type="submit" id="DateTo" name="FormName" value="Download Datewise Manuscript"/>
    <hr/>
    <br/>
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
  <br/>
</div>
<div class="pageinfo"><?php WebLib::PageInfo(); ?></div>
<div class="footer"><?php WebLib::FooterInfo(); ?></div>
</body>
</html>