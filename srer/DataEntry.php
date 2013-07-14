<?php
require_once('srer.lib.php');

WebLib::AuthSession();
WebLib::Html5Header("Data Entry");
WebLib::IncludeCSS();
WebLib::JQueryInclude();
$Data = new MySQLiDB();
SetCurrForm();
if (WebLib::GetVal($_SESSION, 'ACNo') == "")
  $_SESSION['ACNo'] = "-- Choose --";
if (WebLib::GetVal($_SESSION, 'PartID') == "")
  $_SESSION['PartID'] = "-- Choose --";
if (intval(WebLib::GetVal($_POST, 'PartID')) > 0)
  $_SESSION['PartID'] = intval(WebLib::GetVal($_POST, 'PartID'));
if (WebLib::GetVal($_POST, 'ACNo') != "")
  $_SESSION['ACNo'] = WebLib::GetVal($_POST, 'ACNo');
if (intval(WebLib::GetVal($_REQUEST, 'ID')) > 0)
  $_SESSION['PartMapID'] = intval($_REQUEST['ID']);
?>
<script>
  $(function() {
    $(".datepick").datepicker({
      dateFormat: 'yy-mm-dd',
      showOtherMonths: true,
      selectOtherMonths: true,
      showButtonPanel: true,
      showAnim: "slideDown"
    });
    $("#Dept").autocomplete({
      source: "query.php",
      minLength: 3,
      select: function(event, ui) {
        $('#Dept').val(ui.item.value);
      }
    });
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
  WebLib::ShowMenuBar()
  ?>
  <div class="content" style="margin-left:5px;margin-right:5px;">
    <h2><?php echo AppTitle; ?></h2>
    <hr/>
    <form name="frmSRER" method="post" action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>">
      <label for="textfield">AC No.:</label>
      <select name="ACNo" onChange="document.frmSRER.submit();">
        <?php
        $Query = "select ACNo,ACNo from SRER_PartMap Where PartMapID=" . WebLib::GetVal($_SESSION, 'PartMapID', TRUE) . " group by ACNo";
        $Data->show_sel('ACNo', 'ACNo', $Query, WebLib::GetVal($_SESSION, 'ACNo', TRUE));
        ?>
      </select>
      <label for="textfield">Part No.:</label>
      <select name="PartID">
        <?php
        $Query = "Select PartID,CONCAT(PartNo,'-',PartName) as PartName from SRER_PartMap where ACNo='" . WebLib::GetVal($_SESSION, 'ACNo') . "' and PartMapID=" . WebLib::GetVal($_SESSION, 'PartMapID') . " group by PartNo";
        $RowCount = $Data->show_sel('PartID', 'PartName', $Query, WebLib::GetVal($_SESSION, 'PartID'));
        ?>
      </select>
      <input type="submit" name="CmdSubmit" value="Refresh" />
      <?php //echo $Query; ?>
      <br /><hr />
      <?php
      if ((intval(WebLib::GetVal($_SESSION, 'PartID')) > 0) && (WebLib::GetVal($_SESSION, 'TableName') != "")) {
        $RowCount = $Data->do_max_query("Select count(*) from " . WebLib::GetVal($_SESSION, 'TableName') . " Where PartID=" . WebLib::GetVal($_SESSION, 'PartID'));
        $RowCount = $RowCount - 9;
        if ($RowCount < 1)
          $RowCount = 1;
      }
      if (intval(WebLib::GetVal($_SESSION, 'PartID')) > 0) {
        ?>
        <label for="SlFrom">From Serial No.:</label>
        <input type="text" name="SlFrom" size="3" value="<?php echo (WebLib::GetVal($_POST, 'ShowBlank') == "1") ? '0' : $RowCount; ?>"/>
        <input type="submit" name="FormName" value="Form 6" />
        <input type="submit" name="FormName" value="Form 6A" />
        <input type="submit" name="FormName" value="Form 7" />
        <input type="submit" name="FormName" value="Form 8" />
        <input type="submit" name="FormName" value="Form 8A" />
        <input type="checkbox" name="ShowBlank" value="1" <?php if (WebLib::GetVal($_POST, 'ShowBlank')) echo "Checked" ?>/>
        <label for="ShowBlank">Show Blank Records</label>
        <input type="checkbox" name="ShowBlankCount" value="1"/>
        <label for="ShowBlank">Show Blank Records Count</label>
        <hr /><br />
        <?php
        $PartName = GetPartName();
        echo "<h3>Selected Part[{$PartName}] " . WebLib::GetVal($_SESSION, 'FormName') . "</h3>";
      }
      ?>
    </form>
    <?php
    $CondBlank = "";
    if (WebLib::GetVal($_SESSION, 'TableName') !== NULL) {
      if (WebLib::GetVal($_POST, 'ShowBlank') == "1") {
        $FieldNames = explode(',', WebLib::GetVal($_SESSION, 'Fields'));
        $CondBlank = " AND (";
        for ($i = 1; $i < count($FieldNames); $i++) {
          $CondBlank = $CondBlank . $FieldNames[$i] . "='' OR " . $FieldNames[$i] . " IS NULL) AND (";
        }
        $CondBlank = $CondBlank . "1 )";
      }
      $Query = "Select " . WebLib::GetVal($_SESSION, 'Fields') . " from " . WebLib::GetVal($_SESSION, 'TableName') . " Where PartID=" . WebLib::GetVal($_SESSION, 'PartID');
      $Query = $Query . $CondBlank;

      echo $Query;

      EditForm($Query);
      if (WebLib::GetVal($_POST, 'ShowBlankCount') == "1") {

        $Query = "SELECT ACNo as `AC Name`,PartNo,PartName,SUM(CountF6) as CountF6,SUM(CountF6A) as CountF6A,SUM(CountF7) as CountF7,"
                . "SUM(CountF8) as CountF8,SUM(CountF8A) as CountF8A,(IFNULL(SUM(CountF6),0)+IFNULL(SUM(CountF6A),0)+IFNULL(SUM(CountF7),0)+"
                . "IFNULL(SUM(CountF8),0)+IFNULL(SUM(CountF8A),0)) as Total "
                . "FROM SRER_Users U INNER JOIN SRER_PartMap P ON U.PartMapID=P.PartMapID AND U.PartMapID=" . WebLib::GetVal($_SESSION, 'PartMapID') . " LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6 FROM `SRER_Form6` where ((`ReceiptDate`='' OR `ReceiptDate` IS NULL) AND (`AppName`='' OR `AppName` IS NULL) AND (`RelationshipName`='' OR `RelationshipName` IS NULL) AND (`Relationship`='' OR `Relationship` IS NULL) AND (`Status`='' OR `Status` IS NULL)) GROUP BY PartID) F6 "
                . "ON (F6.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6A FROM `SRER_Form6A` where ((`ReceiptDate`='' OR `ReceiptDate` IS NULL) AND (`AppName`='' OR `AppName` IS NULL) AND (`RelationshipName`='' OR `RelationshipName` IS NULL) AND (`Relationship`='' OR `Relationship` IS NULL) AND (`Status`='' OR `Status` IS NULL)) GROUP BY PartID) F6A "
                . "ON (F6A.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF7 FROM `SRER_Form7` Where ((`ReceiptDate`='' OR `ReceiptDate` IS NULL) AND (`ObjectorName`='' OR `ObjectorName` IS NULL) AND (`PartNo`='' OR `PartNo` IS NULL) AND (`SerialNoInPart`='' OR `SerialNoInPart` IS NULL) AND (`DelPersonName`='' OR `DelPersonName` IS NULL) AND (`ObjectReason`='' OR `ObjectReason` IS NULL) AND (`Status` ='' OR `Status` IS NULL)) GROUP BY PartID) F7 "
                . "ON (F7.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8 FROM `SRER_Form8` where ((`ReceiptDate`='' OR `ReceiptDate` IS NULL) AND (`AppName`='' OR `AppName` IS NULL) AND (`RelationshipName`='' OR `RelationshipName` IS NULL) AND (`Relationship`='' OR `Relationship` IS NULL) AND (`Status`='' OR `Status` IS NULL)) GROUP BY PartID) F8 "
                . "ON (F8.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8A FROM `SRER_Form8A` where ((`ReceiptDate`='' OR `ReceiptDate` IS NULL) AND (`AppName`='' OR `AppName` IS NULL) AND (`RelationshipName`='' OR `RelationshipName` IS NULL) AND (`Relationship`='' OR `Relationship` IS NULL) AND (`Status`='' OR `Status` IS NULL)) GROUP BY PartID) F8A "
                . "ON (F8A.PartID=P.PartID) GROUP BY ACNo,PartNo,PartName";
        ShowSRER($Query);
        //echo $Query;
        $Query = "Select SUM(CountF6) as TotalF6,SUM(CountF6A) as TotalF6A,SUM(CountF7) as TotalF7,SUM(CountF8) as TotalF8,SUM(CountF8A) as TotalF8A"
                . ",SUM(Total) as Total FROM ({$Query}) as T";
        ShowSRER($Query);
      }
    }
    ?>
    <br />
  </div>
  <div class="pageinfo"><?php WebLib::PageInfo(); ?></div>
  <div class="footer"><?php WebLib::FooterInfo(); ?></div>
</body>
</html>
