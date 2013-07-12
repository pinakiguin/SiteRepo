<?php
require_once('srer.lib.php');

AuthSession();
Html5Header("Admin Page");
IncludeCSS();
jQueryInclude();
//if (GetVal($_SESSION,'UserName') != "Admin")
//  exit;

SetCurrForm();
if (intval(GetVal($_POST, 'PartID')) > 0)
  $_SESSION['PartID'] = intval(GetVal($_POST, 'PartID'));
if (GetVal($_POST, 'ACNo') != "")
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
    <h1>Summary Revision of Electoral Roll 2013</h1>
  </div>
  <div class="Header">
  </div>
  <?php
  ShowMenuBar()
  ?>
  <div class="content">
    <h2><?php echo AppTitle; ?></h2>
    <hr />
    <form name="frmSRER" method="post" action="<?php GetVal($_SERVER, 'PHP_SELF') ?>">
      <input type="submit" name="FormName" value="User Activity" />
      <input type="submit" name="FormName" value="AC wise Data Entry Status" />
      <input type="submit" name="FormName" value="Block wise Data Entry Status" />
      <input type="submit" name="FormName" value="Block AC wise Data Entry Status" />
      <input type="submit" name="FormName" value="Block AC wise Blank Records" />
      <input type="submit" name="FormName" value="Block AC wise Accepted" />
      <input type="submit" name="FormName" value="Block AC wise Rejected" /><hr /><br />
    </form>
    <?php
    if (GetVal($_POST, 'FormName') != "")
      $_SESSION['AdminView'] = GetVal($_POST, 'FormName');
    echo "<h3>" . GetVal($_SESSION, 'AdminView') . "</h3>";
    Switch (GetVal($_SESSION, 'AdminView')) {
      case 'User Activity':
        $Query = "Select `UserName`,`LoginCount`,CONVERT_TZ(`LastLoginTime`,'+00:00','+05:30') as LastLoginTime,"
                . "CONVERT_TZ(L.`AccessTime`,'+00:00','+05:30') as LastAccessTime,Li.`IP`,Li.`Action`"
                . " from SRER_Users U,(Select UserID,max(`AccessTime`) as AccessTime,max(LogID) as MaxLogID from SRER_logs Group by UserID ) L"
                . ", SRER_logs Li"
                . " where UserName=L.UserID AND L.MaxLogID=Li.LogID order by LastLoginTime desc";
        ShowSRER($Query);
        break;
      case 'AC wise Data Entry Status':
        $Query = "SELECT ACNo,SUM(CountF6) as CountF6,SUM(CountF6A) as CountF6A,SUM(CountF7) as CountF7,"
                . "SUM(CountF8) as CountF8,SUM(CountF8A) as CountF8A,(IFNULL(SUM(CountF6),0)+IFNULL(SUM(CountF6A),0)+IFNULL(SUM(CountF7),0)+"
                . "IFNULL(SUM(CountF8),0)+IFNULL(SUM(CountF8A),0)) as Total "
                . "FROM SRER_PartMap P LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6 FROM `SRER_Form6` GROUP BY PartID) F6 "
                . "ON (F6.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6A FROM `SRER_Form6A` GROUP BY PartID) F6A "
                . "ON (F6A.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF7 FROM `SRER_Form7` GROUP BY PartID) F7 "
                . "ON (F7.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8 FROM `SRER_Form8` GROUP BY PartID) F8 "
                . "ON (F8.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8A FROM `SRER_Form8A` GROUP BY PartID) F8A "
                . "ON (F8A.PartID=P.PartID) GROUP BY ACNo";
        ShowSRER($Query);
        $Query = "Select SUM(CountF6) as TotalF6,SUM(CountF6A) as TotalF6A,SUM(CountF7) as TotalF7,SUM(CountF8) as TotalF8,SUM(CountF8A) as TotalF8A"
                . ",SUM(Total) as Total FROM ({$Query}) as T";
        ShowSRER($Query);
        break;
      case 'Block wise Data Entry Status':
        $Query = "SELECT UserName,SUM(CountF6) as CountF6,SUM(CountF6A) as CountF6A,SUM(CountF7) as CountF7,"
                . "SUM(CountF8) as CountF8,SUM(CountF8A) as CountF8A,(IFNULL(SUM(CountF6),0)+IFNULL(SUM(CountF6A),0)+IFNULL(SUM(CountF7),0)+"
                . "IFNULL(SUM(CountF8),0)+IFNULL(SUM(CountF8A),0)) as Total "
                . "FROM SRER_Users U INNER JOIN SRER_PartMap P ON U.PartMapID=P.PartMapID LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6 FROM `SRER_Form6` GROUP BY PartID) F6 "
                . "ON (F6.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6A FROM `SRER_Form6A` GROUP BY PartID) F6A "
                . "ON (F6A.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF7 FROM `SRER_Form7` GROUP BY PartID) F7 "
                . "ON (F7.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8 FROM `SRER_Form8` GROUP BY PartID) F8 "
                . "ON (F8.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8A FROM `SRER_Form8A` GROUP BY PartID) F8A "
                . "ON (F8A.PartID=P.PartID) GROUP BY UserName";
        ShowSRER($Query);
        //echo $Query;
        $Query = "Select SUM(CountF6) as TotalF6,SUM(CountF6A) as TotalF6A,SUM(CountF7) as TotalF7,SUM(CountF8) as TotalF8,SUM(CountF8A) as TotalF8A"
                . ",SUM(Total) as Total FROM ({$Query}) as T";
        ShowSRER($Query);
        //echo $Query;
        break;
      case 'Block AC wise Data Entry Status':
        $Query = "SELECT UserName,ACNo,SUM(CountF6) as CountF6,SUM(CountF6A) as CountF6A,SUM(CountF7) as CountF7,"
                . "SUM(CountF8) as CountF8,SUM(CountF8A) as CountF8A,(IFNULL(SUM(CountF6),0)+IFNULL(SUM(CountF6A),0)+IFNULL(SUM(CountF7),0)+"
                . "IFNULL(SUM(CountF8),0)+IFNULL(SUM(CountF8A),0)) as Total "
                . "FROM SRER_Users U INNER JOIN SRER_PartMap P ON U.PartMapID=P.PartMapID LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6 FROM `SRER_Form6` GROUP BY PartID) F6 "
                . "ON (F6.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6A FROM `SRER_Form6A` GROUP BY PartID) F6A "
                . "ON (F6A.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF7 FROM `SRER_Form7` GROUP BY PartID) F7 "
                . "ON (F7.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8 FROM `SRER_Form8` GROUP BY PartID) F8 "
                . "ON (F8.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8A FROM `SRER_Form8A` GROUP BY PartID) F8A "
                . "ON (F8A.PartID=P.PartID) GROUP BY UserName,ACNo";
        ShowSRER($Query);
        //echo $Query;
        $Query = "Select SUM(CountF6) as TotalF6,SUM(CountF6A) as TotalF6A,SUM(CountF7) as TotalF7,SUM(CountF8) as TotalF8,SUM(CountF8A) as TotalF8A"
                . ",SUM(Total) as Total FROM ({$Query}) as T";
        ShowSRER($Query);
        //echo $Query;
        break;
      case 'Block AC wise Blank Records':
        $Query = "SELECT U.PartMapID as UserID,UserName,ACNo,SUM(CountF6) as CountF6,SUM(CountF6A) as CountF6A,SUM(CountF7) as CountF7,"
                . "SUM(CountF8) as CountF8,SUM(CountF8A) as CountF8A,(IFNULL(SUM(CountF6),0)+IFNULL(SUM(CountF6A),0)+IFNULL(SUM(CountF7),0)+"
                . "IFNULL(SUM(CountF8),0)+IFNULL(SUM(CountF8A),0)) as Total "
                . "FROM SRER_Users U INNER JOIN SRER_PartMap P ON U.PartMapID=P.PartMapID LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6 FROM `SRER_Form6`  where ((`ReceiptDate`='' OR `ReceiptDate` IS NULL) AND (`AppName`='' OR `AppName` IS NULL) AND (`RelationshipName`='' OR `RelationshipName` IS NULL) AND (`Relationship`='' OR `Relationship` IS NULL) AND (`Status`='' OR `Status` IS NULL)) GROUP BY PartID) F6 "
                . "ON (F6.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6A FROM `SRER_Form6A`  where ((`ReceiptDate`='' OR `ReceiptDate` IS NULL) AND (`AppName`='' OR `AppName` IS NULL) AND (`RelationshipName`='' OR `RelationshipName` IS NULL) AND (`Relationship`='' OR `Relationship` IS NULL) AND (`Status`='' OR `Status` IS NULL)) GROUP BY PartID) F6A "
                . "ON (F6A.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF7 FROM `SRER_Form7` Where ((`ReceiptDate`='' OR `ReceiptDate` IS NULL) AND (`ObjectorName`='' OR `ObjectorName` IS NULL) AND (`PartNo`='' OR `PartNo` IS NULL) AND (`SerialNoInPart`='' OR `SerialNoInPart` IS NULL) AND (`DelPersonName`='' OR `DelPersonName` IS NULL) AND (`ObjectReason`='' OR `ObjectReason` IS NULL) AND (`Status` ='' OR `Status` IS NULL)) GROUP BY PartID) F7 "
                . "ON (F7.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8 FROM `SRER_Form8`  where ((`ReceiptDate`='' OR `ReceiptDate` IS NULL) AND (`AppName`='' OR `AppName` IS NULL) AND (`RelationshipName`='' OR `RelationshipName` IS NULL) AND (`Relationship`='' OR `Relationship` IS NULL) AND (`Status`='' OR `Status` IS NULL)) GROUP BY PartID) F8 "
                . "ON (F8.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8A FROM `SRER_Form8A`  where ((`ReceiptDate`='' OR `ReceiptDate` IS NULL) AND (`AppName`='' OR `AppName` IS NULL) AND (`RelationshipName`='' OR `RelationshipName` IS NULL) AND (`Relationship`='' OR `Relationship` IS NULL) AND (`Status`='' OR `Status` IS NULL)) GROUP BY PartID) F8A "
                . "ON (F8A.PartID=P.PartID) GROUP BY UserName,ACNo,U.PartMapID";
        ShowSRER($Query);
        //echo $Query;
        $Query = "Select SUM(CountF6) as TotalF6,SUM(CountF6A) as TotalF6A,SUM(CountF7) as TotalF7,SUM(CountF8) as TotalF8,SUM(CountF8A) as TotalF8A"
                . ",SUM(Total) as Total FROM ({$Query}) as T";
        ShowSRER($Query);
        //echo $Query;
        break;
      case 'Block AC wise Accepted':
        $Query = "SELECT UserName,ACNo,SUM(CountF6) as CountF6,SUM(CountF6A) as CountF6A,SUM(CountF7) as CountF7,"
                . "SUM(CountF8) as CountF8,SUM(CountF8A) as CountF8A,(IFNULL(SUM(CountF6),0)+IFNULL(SUM(CountF6A),0)+IFNULL(SUM(CountF7),0)+"
                . "IFNULL(SUM(CountF8),0)+IFNULL(SUM(CountF8A),0)) as Total "
                . "FROM SRER_Users U INNER JOIN SRER_PartMap P ON U.PartMapID=P.PartMapID LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6 FROM `SRER_Form6`  where (LOWER(TRIM(`Status`))='accepted') GROUP BY PartID) F6 "
                . "ON (F6.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6A FROM `SRER_Form6A`  where (LOWER(TRIM(`Status`))='accepted') GROUP BY PartID) F6A "
                . "ON (F6A.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF7 FROM `SRER_Form7` Where (LOWER(TRIM(`Status`))='accepted') GROUP BY PartID) F7 "
                . "ON (F7.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8 FROM `SRER_Form8`  where (LOWER(TRIM(`Status`))='accepted') GROUP BY PartID) F8 "
                . "ON (F8.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8A FROM `SRER_Form8A`  where (LOWER(TRIM(`Status`))='accepted') GROUP BY PartID) F8A "
                . "ON (F8A.PartID=P.PartID) GROUP BY UserName,ACNo";
        ShowSRER($Query);
        //echo $Query;
        $Query = "Select SUM(CountF6) as TotalF6,SUM(CountF6A) as TotalF6A,SUM(CountF7) as TotalF7,SUM(CountF8) as TotalF8,SUM(CountF8A) as TotalF8A"
                . ",SUM(Total) as Total FROM ({$Query}) as T";
        ShowSRER($Query);
        //echo $Query;
        break;
      case 'Block AC wise Rejected':
        $Query = "SELECT UserName,ACNo,SUM(CountF6) as CountF6,SUM(CountF6A) as CountF6A,SUM(CountF7) as CountF7,"
                . "SUM(CountF8) as CountF8,SUM(CountF8A) as CountF8A,(IFNULL(SUM(CountF6),0)+IFNULL(SUM(CountF6A),0)+IFNULL(SUM(CountF7),0)+"
                . "IFNULL(SUM(CountF8),0)+IFNULL(SUM(CountF8A),0)) as Total "
                . "FROM SRER_Users U INNER JOIN SRER_PartMap P ON U.PartMapID=P.PartMapID LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6 FROM `SRER_Form6`  where (LOWER(TRIM(`Status`))='rejected') GROUP BY PartID) F6 "
                . "ON (F6.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6A FROM `SRER_Form6A`  where (LOWER(TRIM(`Status`))='rejected') GROUP BY PartID) F6A "
                . "ON (F6A.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF7 FROM `SRER_Form7` Where (LOWER(TRIM(`Status`))='rejected') GROUP BY PartID) F7 "
                . "ON (F7.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8 FROM `SRER_Form8`  where (LOWER(TRIM(`Status`))='rejected') GROUP BY PartID) F8 "
                . "ON (F8.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8A FROM `SRER_Form8A`  where (LOWER(TRIM(`Status`))='rejected') GROUP BY PartID) F8A "
                . "ON (F8A.PartID=P.PartID) GROUP BY UserName,ACNo";
        ShowSRER($Query);
        //echo $Query;
        $Query = "Select SUM(CountF6) as TotalF6,SUM(CountF6A) as TotalF6A,SUM(CountF7) as TotalF7,SUM(CountF8) as TotalF8,SUM(CountF8A) as TotalF8A"
                . ",SUM(Total) as Total FROM ({$Query}) as T";
        ShowSRER($Query);
        //echo $Query;
        break;
    }
    ?>
  </div>
  <div class="pageinfo"><?php pageinfo(); ?></div>
  <div class="footer"><?php footerinfo(); ?></div>
</body>
</html>