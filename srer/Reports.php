<?php
require_once('srer.lib.php');

AuthSession();

Html5Header("Data Entry");
IncludeCSS();
jQueryInclude();
$Data = new MySQLiDB();
SetCurrForm();

if (GetVal($_SESSION, 'ACNo') == "")
  $_SESSION['ACNo'] = "-- Choose --";
if ((Getval($_SESSION, 'PartID') == "") || (Getval($_SESSION, 'ACNo') != Getval($_POST, 'ACNo')))
  $_SESSION['PartID'] = "-- Choose --";
if (intval(Getval($_SESSION, 'PartID')) > 0)
  $_SESSION['PartID'] = intval(GetVal($_POST, 'PartID'));
if (Getval($_POST, 'ACNo') != "")
  $_SESSION['ACNo'] = GetVal($_POST, 'ACNo');
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
  ShowMenuBar()
  ?>
  <div class="content">
    <h2><?php echo AppTitle; ?></h2>
    <hr/>
    <form name="frmSRER" method="post" action="<?php echo GetVal($_SERVER, 'PHP_SELF'); ?>">
      <label for="textfield">AC No.:</label>
      <select name="ACNo" onChange="document.frmSRER.submit();">
        <?php
        $Query = "select ACNo,ACNo from SRER_PartMap group by ACNo";
        $Data->show_sel('ACNo', 'ACNo', $Query, GetVal($_SESSION, 'ACNo', TRUE));
        ?>
      </select>
      <label for="textfield">Part No.:</label>
      <select name="PartID">
        <?php
        $Query = "Select PartID,CONCAT(PartNo,'-',PartName) as PartName from SRER_PartMap where ACNo='" . GetVal($_SESSION, 'ACNo', TRUE) . "' group by PartNo";
        $Data->show_sel('PartID', 'PartName', $Query, GetVal($_SESSION, 'PartID'));
        ?>
      </select>
      <?php //echo $Query;  ?>
      <input type="submit" name="FormName" value="Show" />
      <hr /><br />
    </form>
    <?php
    if (intval(GetVal($_SESSION, 'PartID')) > 0) {
      echo "<h3>Form 6</h3>";
      $Query = "Select `SlNo`, `ReceiptDate`, `AppName`, `RelationshipName`, `Relationship`, `Status` from SRER_Form6 Where PartID=" . GetVal($_SESSION, 'PartID', TRUE);
      ShowSRER($Query);
      echo "<h3>Form 6A</h3>";
      $Query = "Select `SlNo`, `ReceiptDate`, `AppName`, `RelationshipName`, `Relationship`, `Status` from SRER_Form6A Where PartID=" . GetVal($_SESSION, 'PartID', TRUE);
      ShowSRER($Query);
      echo "<h3>Form 7</h3>";
      $Query = "Select `SlNo`, `ReceiptDate`, `ObjectorName`, `PartNo`, `SerialNoInPart`, `DelPersonName`, `ObjectReason`, `Status` from SRER_Form7 Where PartID=" . GetVal($_SESSION, 'PartID', TRUE);
      ShowSRER($Query);
      echo "<h3>Form 8</h3>";
      $Query = "Select `SlNo`, `ReceiptDate`, `AppName`, `RelationshipName`, `Relationship`, `Status` from SRER_Form8 Where PartID=" . GetVal($_SESSION, 'PartID', TRUE);
      ShowSRER($Query);
      echo "<h3>Form 8A</h3>";
      $Query = "Select `SlNo`, `ReceiptDate`, `AppName`, `RelationshipName`, `Relationship`, `Status` from SRER_Form8A Where PartID=" . GetVal($_SESSION, 'PartID', TRUE);
      ShowSRER($Query);
    }
    if (GetVal($_SERVER, 'PHP_SELF') == '/srer2013/reports.php') {
      /* if((time()-strtotime("02:30:00"))>0)
        {
        echo "<h3>Summary Reports will be available at 8:00AM.</h3>";
        }
        else
        { */
      $Query = "SELECT ACNo as `AC Name`,PartNo,PartName,SUM(CountF6) as CountF6,SUM(CountF6A) as CountF6A,SUM(CountF7) as CountF7,"
              . "SUM(CountF8) as CountF8,SUM(CountF8A) as CountF8A,(IFNULL(SUM(CountF6),0)+IFNULL(SUM(CountF6A),0)+IFNULL(SUM(CountF7),0)+"
              . "IFNULL(SUM(CountF8),0)+IFNULL(SUM(CountF8A),0)) as Total "
              . "FROM SRER_Users U INNER JOIN SRER_PartMap P ON U.PartMapID=P.PartMapID AND U.PartMapID=" . GetVal($_SESSION, 'PartMapID', TRUE) . " LEFT JOIN "
              . "(SELECT PartID,Count(*) as CountF6 FROM `SRER_Form6` GROUP BY PartID) F6 "
              . "ON (F6.PartID=P.PartID) LEFT JOIN "
              . "(SELECT PartID,Count(*) as CountF6A FROM `SRER_Form6A` GROUP BY PartID) F6A "
              . "ON (F6A.PartID=P.PartID) LEFT JOIN "
              . "(SELECT PartID,Count(*) as CountF7 FROM `SRER_Form7` GROUP BY PartID) F7 "
              . "ON (F7.PartID=P.PartID) LEFT JOIN "
              . "(SELECT PartID,Count(*) as CountF8 FROM `SRER_Form8` GROUP BY PartID) F8 "
              . "ON (F8.PartID=P.PartID) LEFT JOIN "
              . "(SELECT PartID,Count(*) as CountF8A FROM `SRER_Form8A` GROUP BY PartID) F8A "
              . "ON (F8A.PartID=P.PartID) GROUP BY ACNo,PartNo,PartName";
      ShowSRER($Query);
      //echo $Query;
      $Query = "Select SUM(CountF6) as TotalF6,SUM(CountF6A) as TotalF6A,SUM(CountF7) as TotalF7,SUM(CountF8) as TotalF8,SUM(CountF8A) as TotalF8A"
              . ",SUM(Total) as Total FROM ({$Query}) as T";
      ShowSRER($Query);
      //}
    }
//echo $Query;
    ?>
    <br />
  </div>
  <div class="pageinfo"><?php pageinfo(); ?></div>
  <div class="footer"><?php footerinfo(); ?></div>
</body>
</html>