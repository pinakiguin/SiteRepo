<?php
require_once(__DIR__ . '/srer.lib.php');

WebLib::AuthSession();
WebLib::Html5Header("Admin Page");
WebLib::IncludeCSS();

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
    <h1>Summary Revision of Electoral Roll 2013</h1>
  </div>
  <div class="Header">
  </div>
  <?php
  WebLib::ShowMenuBar('SRER')
  ?>
  <div class="content">
    <h2><?php echo AppTitle; ?></h2>
    <hr />
    <form name="frmSRER" method="post" action="<?php WebLib::GetVal($_SERVER, 'PHP_SELF') ?>">
      <input type="submit" name="FormName" value="User Activity" />
      <input type="submit" name="FormName" value="AC wise Data Entry Status" />
      <input type="submit" name="FormName" value="Block wise Data Entry Status" />
      <input type="submit" name="FormName" value="Block AC wise Data Entry Status" />
      <input type="submit" name="FormName" value="Block AC wise Accepted" />
      <input type="submit" name="FormName" value="Block AC wise Rejected" /><hr />
      <label for="ACNo">AC No.:</label>
      <select name="ACNo" id="ACNo">
        <?php
        $Data = new MySQLiDB();
        $Query = 'Select ACNo,CONCAT(ACNo,\' - \',ACName) AS ACName from ' . MySQL_Pre . 'SRER_ACs'
                . ' Where `DistCode`=' . DistCode . ' Order by ACNo';
        $Data->show_sel('ACNo', 'ACName', $Query, WebLib::GetVal($_SESSION, 'ACNo', TRUE));
        ?>
      </select>
      <input type="submit" name="FormName" value="Part wise Data Entry Status" />
      <input type="submit" name="FormName" value="Part wise Accepted" />
      <input type="submit" name="FormName" value="Part wise Rejected" /><hr /><br />
    </form>
    <?php
    if (WebLib::GetVal($_POST, 'FormName') != "")
      $_SESSION['AdminView'] = WebLib::GetVal($_POST, 'FormName');
    echo "<h3>" . WebLib::GetVal($_SESSION, 'AdminView') . "</h3>";
    Switch (WebLib::GetVal($_SESSION, 'AdminView')) {
      case 'User Activity':
        $Query = "Select `UserName` as `User Name`,`LoginCount`,"
                . "CONVERT_TZ(`LastLoginTime`,'+00:00','+05:30') as LastLoginTime,"
                . "CONVERT_TZ(L.`AccessTime`,'+00:00','+05:30') as LastAccessTime,Li.`IP`,Li.`Action`"
                . " from `" . MySQL_Pre . "Users` U,"
                . "(Select UserID,max(`AccessTime`) as AccessTime,max(LogID) as MaxLogID"
                . " from `" . MySQL_Pre . "Logs` Group by UserID ) L"
                . ", `" . MySQL_Pre . "Logs` Li"
                . " where UserMapID=L.UserID AND L.MaxLogID=Li.LogID order by LastLoginTime desc";
        ShowSRER($Query);
        break;
      case 'AC wise Data Entry Status':
        $Query = "SELECT ACNo,SUM(CountF6) as CountF6,SUM(CountF6A) as CountF6A,SUM(CountF7) as CountF7,"
                . "SUM(CountF8) as CountF8,SUM(CountF8A) as CountF8A,"
                . "(IFNULL(SUM(CountF6),0)+IFNULL(SUM(CountF6A),0)+IFNULL(SUM(CountF7),0)+"
                . "IFNULL(SUM(CountF8),0)+IFNULL(SUM(CountF8A),0)) as Total "
                . "FROM `" . MySQL_Pre . "SRER_PartMap` P LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6 FROM `" . MySQL_Pre . "SRER_Form6` GROUP BY PartID) F6 "
                . "ON (F6.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6A FROM `" . MySQL_Pre . "SRER_Form6A` GROUP BY PartID) F6A "
                . "ON (F6A.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF7 FROM `" . MySQL_Pre . "SRER_Form7` GROUP BY PartID) F7 "
                . "ON (F7.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8 FROM `" . MySQL_Pre . "SRER_Form8` GROUP BY PartID) F8 "
                . "ON (F8.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8A FROM `" . MySQL_Pre . "SRER_Form8A` GROUP BY PartID) F8A "
                . "ON (F8A.PartID=P.PartID) GROUP BY ACNo";
        ShowSRER($Query);
        $Query = "Select SUM(CountF6) as TotalF6,SUM(CountF6A) as TotalF6A,SUM(CountF7) as TotalF7,"
                . " SUM(CountF8) as TotalF8,SUM(CountF8A) as TotalF8A,"
                . " SUM(Total) as Total FROM ({$Query}) as T";
        ShowSRER($Query);
        break;
      case 'Part wise Data Entry Status':
        $Query = "SELECT CONCAT(`PartNo`,'-',`PartName`) as `Part Name`,SUM(CountF6) as CountF6,SUM(CountF6A) as CountF6A,SUM(CountF7) as CountF7,"
                . "SUM(CountF8) as CountF8,SUM(CountF8A) as CountF8A,"
                . "(IFNULL(SUM(CountF6),0)+IFNULL(SUM(CountF6A),0)+IFNULL(SUM(CountF7),0)+"
                . "IFNULL(SUM(CountF8),0)+IFNULL(SUM(CountF8A),0)) as Total "
                . "FROM `" . MySQL_Pre . "SRER_PartMap` P LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6 FROM `" . MySQL_Pre . "SRER_Form6` GROUP BY PartID) F6 "
                . "ON (F6.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6A FROM `" . MySQL_Pre . "SRER_Form6A` GROUP BY PartID) F6A "
                . "ON (F6A.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF7 FROM `" . MySQL_Pre . "SRER_Form7` GROUP BY PartID) F7 "
                . "ON (F7.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8 FROM `" . MySQL_Pre . "SRER_Form8` GROUP BY PartID) F8 "
                . "ON (F8.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8A FROM `" . MySQL_Pre . "SRER_Form8A` GROUP BY PartID) F8A "
                . "ON (F8A.PartID=P.PartID) GROUP BY ACNo,PartNo,PartName Having ACNo=" . $_SESSION['ACNo'];
        ShowSRER($Query);
        $Query = "Select SUM(CountF6) as TotalF6,SUM(CountF6A) as TotalF6A,SUM(CountF7) as TotalF7,"
                . " SUM(CountF8) as TotalF8,SUM(CountF8A) as TotalF8A,"
                . " SUM(Total) as Total FROM ({$Query}) as T";
        ShowSRER($Query);
        break;
      case 'Block wise Data Entry Status':
        $Query = "SELECT UserName,SUM(CountF6) as CountF6,SUM(CountF6A) as CountF6A,SUM(CountF7) as CountF7,"
                . "SUM(CountF8) as CountF8,SUM(CountF8A) as CountF8A,"
                . "(IFNULL(SUM(CountF6),0)+IFNULL(SUM(CountF6A),0)+IFNULL(SUM(CountF7),0)+"
                . "IFNULL(SUM(CountF8),0)+IFNULL(SUM(CountF8A),0)) as Total "
                . "FROM `" . MySQL_Pre . "Users` U INNER JOIN " . MySQL_Pre . "SRER_PartMap P "
                . " ON U.UserMapID=P.UserMapID LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6 FROM `" . MySQL_Pre . "SRER_Form6` GROUP BY PartID) F6 "
                . "ON (F6.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6A FROM `" . MySQL_Pre . "SRER_Form6A` GROUP BY PartID) F6A "
                . "ON (F6A.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF7 FROM `" . MySQL_Pre . "SRER_Form7` GROUP BY PartID) F7 "
                . "ON (F7.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8 FROM `" . MySQL_Pre . "SRER_Form8` GROUP BY PartID) F8 "
                . "ON (F8.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8A FROM `" . MySQL_Pre . "SRER_Form8A` GROUP BY PartID) F8A "
                . "ON (F8A.PartID=P.PartID) GROUP BY UserName";
        ShowSRER($Query);
        $Query = "Select SUM(CountF6) as TotalF6,SUM(CountF6A) as TotalF6A,SUM(CountF7) as TotalF7,"
                . " SUM(CountF8) as TotalF8,SUM(CountF8A) as TotalF8A,"
                . " SUM(Total) as Total FROM ({$Query}) as T";
        ShowSRER($Query);
        break;
      case 'Block AC wise Data Entry Status':
        $Query = "SELECT UserName,ACNo,SUM(CountF6) as CountF6,SUM(CountF6A) as CountF6A,SUM(CountF7) as CountF7,"
                . "SUM(CountF8) as CountF8,SUM(CountF8A) as CountF8A,"
                . "(IFNULL(SUM(CountF6),0)+IFNULL(SUM(CountF6A),0)+IFNULL(SUM(CountF7),0)+"
                . "IFNULL(SUM(CountF8),0)+IFNULL(SUM(CountF8A),0)) as Total "
                . "FROM `" . MySQL_Pre . "Users` U INNER JOIN `" . MySQL_Pre . "SRER_PartMap` P "
                . " ON U.UserMapID=P.UserMapID LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6 FROM `" . MySQL_Pre . "SRER_Form6` GROUP BY PartID) F6 "
                . "ON (F6.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6A FROM `" . MySQL_Pre . "SRER_Form6A` GROUP BY PartID) F6A "
                . "ON (F6A.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF7 FROM `" . MySQL_Pre . "SRER_Form7` GROUP BY PartID) F7 "
                . "ON (F7.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8 FROM `" . MySQL_Pre . "SRER_Form8` GROUP BY PartID) F8 "
                . "ON (F8.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8A FROM `" . MySQL_Pre . "SRER_Form8A` GROUP BY PartID) F8A "
                . "ON (F8A.PartID=P.PartID) GROUP BY UserName,ACNo";
        ShowSRER($Query);
        $Query = "Select SUM(CountF6) as TotalF6,SUM(CountF6A) as TotalF6A,SUM(CountF7) as TotalF7,"
                . " SUM(CountF8) as TotalF8,SUM(CountF8A) as TotalF8A,"
                . " SUM(Total) as Total FROM ({$Query}) as T";
        ShowSRER($Query);
        break;
      case 'Block AC wise Accepted':
        $Query = "SELECT UserName,ACNo,SUM(CountF6) as CountF6,SUM(CountF6A) as CountF6A,SUM(CountF7) as CountF7,"
                . "SUM(CountF8) as CountF8,SUM(CountF8A) as CountF8A,(IFNULL(SUM(CountF6),0)+"
                . "IFNULL(SUM(CountF6A),0)+IFNULL(SUM(CountF7),0)+"
                . "IFNULL(SUM(CountF8),0)+IFNULL(SUM(CountF8A),0)) as Total "
                . " FROM `" . MySQL_Pre . "Users` U INNER JOIN `" . MySQL_Pre . "SRER_PartMap` P "
                . " ON (U.UserMapID=P.UserMapID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6 FROM `" . MySQL_Pre . "SRER_Form6`  "
                . " Where (LOWER(TRIM(`Status`))='a') GROUP BY PartID) F6 "
                . " ON (F6.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6A FROM `" . MySQL_Pre . "SRER_Form6A` "
                . " Where (LOWER(TRIM(`Status`))='a') GROUP BY PartID) F6A "
                . " ON (F6A.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF7 FROM `" . MySQL_Pre . "SRER_Form7` "
                . " Where (LOWER(TRIM(`Status`))='a') GROUP BY PartID) F7 "
                . " ON (F7.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8 FROM `" . MySQL_Pre . "SRER_Form8` "
                . " Where (LOWER(TRIM(`Status`))='a') GROUP BY PartID) F8 "
                . " ON (F8.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8A FROM `" . MySQL_Pre . "SRER_Form8A` "
                . " Where (LOWER(TRIM(`Status`))='a') GROUP BY PartID) F8A "
                . " ON (F8A.PartID=P.PartID) GROUP BY UserName,ACNo";
        ShowSRER($Query);
        $Query = "Select SUM(CountF6) as TotalF6,SUM(CountF6A) as TotalF6A,SUM(CountF7) as TotalF7,"
                . " SUM(CountF8) as TotalF8,SUM(CountF8A) as TotalF8A,"
                . " SUM(Total) as Total FROM ({$Query}) as T";
        ShowSRER($Query);
        break;
      case 'Block AC wise Rejected':
        $Query = "SELECT UserName,ACNo,SUM(CountF6) as CountF6,SUM(CountF6A) as CountF6A,SUM(CountF7) as CountF7,"
                . "SUM(CountF8) as CountF8,SUM(CountF8A) as CountF8A,"
                . "(IFNULL(SUM(CountF6),0)+IFNULL(SUM(CountF6A),0)+IFNULL(SUM(CountF7),0)+"
                . "IFNULL(SUM(CountF8),0)+IFNULL(SUM(CountF8A),0)) as Total "
                . "FROM `" . MySQL_Pre . "Users` U INNER JOIN `" . MySQL_Pre . "SRER_PartMap` P "
                . " ON U.UserMapID=P.UserMapID LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6 FROM `" . MySQL_Pre . "SRER_Form6` "
                . " Where (LOWER(TRIM(`Status`))='r') GROUP BY PartID) F6 "
                . " ON (F6.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6A FROM `" . MySQL_Pre . "SRER_Form6A` "
                . " Where (LOWER(TRIM(`Status`))='r') GROUP BY PartID) F6A "
                . " ON (F6A.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF7 FROM `" . MySQL_Pre . "SRER_Form7` "
                . " Where (LOWER(TRIM(`Status`))='r') GROUP BY PartID) F7 "
                . " ON (F7.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8 FROM `" . MySQL_Pre . "SRER_Form8` "
                . " Where (LOWER(TRIM(`Status`))='r') GROUP BY PartID) F8 "
                . " ON (F8.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8A FROM `" . MySQL_Pre . "SRER_Form8A` "
                . " Where (LOWER(TRIM(`Status`))='r') GROUP BY PartID) F8A "
                . " ON (F8A.PartID=P.PartID) GROUP BY UserName,ACNo";
        ShowSRER($Query);
        $Query = "Select SUM(CountF6) as TotalF6,SUM(CountF6A) as TotalF6A,SUM(CountF7) as TotalF7,"
                . " SUM(CountF8) as TotalF8,SUM(CountF8A) as TotalF8A,"
                . " SUM(Total) as Total FROM ({$Query}) as T";
        ShowSRER($Query);
        break;
      case 'Part wise Accepted':
        $Query = "SELECT CONCAT(`PartNo`,'-',`PartName`) as `Part Name`,SUM(CountF6) as CountF6,SUM(CountF6A) as CountF6A,SUM(CountF7) as CountF7,"
                . "SUM(CountF8) as CountF8,SUM(CountF8A) as CountF8A,(IFNULL(SUM(CountF6),0)+"
                . "IFNULL(SUM(CountF6A),0)+IFNULL(SUM(CountF7),0)+"
                . "IFNULL(SUM(CountF8),0)+IFNULL(SUM(CountF8A),0)) as Total "
                . " FROM `" . MySQL_Pre . "Users` U INNER JOIN `" . MySQL_Pre . "SRER_PartMap` P "
                . " ON (U.UserMapID=P.UserMapID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6 FROM `" . MySQL_Pre . "SRER_Form6`  "
                . " Where (LOWER(TRIM(`Status`))='a') GROUP BY PartID) F6 "
                . " ON (F6.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6A FROM `" . MySQL_Pre . "SRER_Form6A` "
                . " Where (LOWER(TRIM(`Status`))='a') GROUP BY PartID) F6A "
                . " ON (F6A.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF7 FROM `" . MySQL_Pre . "SRER_Form7` "
                . " Where (LOWER(TRIM(`Status`))='a') GROUP BY PartID) F7 "
                . " ON (F7.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8 FROM `" . MySQL_Pre . "SRER_Form8` "
                . " Where (LOWER(TRIM(`Status`))='a') GROUP BY PartID) F8 "
                . " ON (F8.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8A FROM `" . MySQL_Pre . "SRER_Form8A` "
                . " Where (LOWER(TRIM(`Status`))='a') GROUP BY PartID) F8A "
                . " ON (F8A.PartID=P.PartID) GROUP BY ACNo,PartNo,PartName Having ACNo=" . $_SESSION['ACNo'];
        ShowSRER($Query);
        $Query = "Select SUM(CountF6) as TotalF6,SUM(CountF6A) as TotalF6A,SUM(CountF7) as TotalF7,"
                . " SUM(CountF8) as TotalF8,SUM(CountF8A) as TotalF8A,"
                . " SUM(Total) as Total FROM ({$Query}) as T";
        ShowSRER($Query);
        break;
      case 'Part wise Rejected':
        $Query = "SELECT CONCAT(`PartNo`,'-',`PartName`) as `Part Name`,SUM(CountF6) as CountF6,SUM(CountF6A) as CountF6A,SUM(CountF7) as CountF7,"
                . "SUM(CountF8) as CountF8,SUM(CountF8A) as CountF8A,"
                . "(IFNULL(SUM(CountF6),0)+IFNULL(SUM(CountF6A),0)+IFNULL(SUM(CountF7),0)+"
                . "IFNULL(SUM(CountF8),0)+IFNULL(SUM(CountF8A),0)) as Total "
                . "FROM `" . MySQL_Pre . "Users` U INNER JOIN `" . MySQL_Pre . "SRER_PartMap` P "
                . " ON U.UserMapID=P.UserMapID LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6 FROM `" . MySQL_Pre . "SRER_Form6` "
                . " Where (LOWER(TRIM(`Status`))='r') GROUP BY PartID) F6 "
                . " ON (F6.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF6A FROM `" . MySQL_Pre . "SRER_Form6A` "
                . " Where (LOWER(TRIM(`Status`))='r') GROUP BY PartID) F6A "
                . " ON (F6A.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF7 FROM `" . MySQL_Pre . "SRER_Form7` "
                . " Where (LOWER(TRIM(`Status`))='r') GROUP BY PartID) F7 "
                . " ON (F7.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8 FROM `" . MySQL_Pre . "SRER_Form8` "
                . " Where (LOWER(TRIM(`Status`))='r') GROUP BY PartID) F8 "
                . " ON (F8.PartID=P.PartID) LEFT JOIN "
                . "(SELECT PartID,Count(*) as CountF8A FROM `" . MySQL_Pre . "SRER_Form8A` "
                . " Where (LOWER(TRIM(`Status`))='r') GROUP BY PartID) F8A "
                . " ON (F8A.PartID=P.PartID) GROUP BY ACNo,PartNo,PartName Having ACNo=" . $_SESSION['ACNo'];
        ShowSRER($Query);
        $Query = "Select SUM(CountF6) as TotalF6,SUM(CountF6A) as TotalF6A,SUM(CountF7) as TotalF7,"
                . " SUM(CountF8) as TotalF8,SUM(CountF8A) as TotalF8A,"
                . " SUM(Total) as Total FROM ({$Query}) as T";
        ShowSRER($Query);
        break;
    }
    ?>
  </div>
  <div class="pageinfo"><?php WebLib::PageInfo(); ?></div>
  <div class="footer"><?php WebLib::FooterInfo(); ?></div>
</body>
</html>