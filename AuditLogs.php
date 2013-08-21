<?php
require_once 'lib.inc.php';
WebLib::AuthSession();
WebLib::Html5Header("User Activity");
WebLib::IncludeCSS();
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
  WebLib::ShowMenuBar('WebSite');
  ?>
  <div class="content">
    <h2>Activity Logs</h2>
    <?php
    $Data = new MySQLiDB();
    $Query = "SELECT count(*) FROM " . MySQL_Pre . "Users U"
            . " Where CtrlMapID=" . WebLib::GetVal($_SESSION, 'UserMapID', TRUE);
    if ($Data->do_max_query($Query) > 0) {
      ?>
      <form name="frm_activity" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
        <label for="User">Select User:</label>
        <select name="User" onChange="javascript:document.frm_activity.submit();">
          <?php
          if (WebLib::GetVal($_POST, 'User') == "")
            $Choice = "-- Choose --";
          else
            $Choice = WebLib::GetVal($_POST, 'User');
          $Query = "SELECT `UserMapID`, concat(`UserName`,' [',IFNULL(`UserID`,''),']') as `User`"
                  . " FROM `" . MySQL_Pre . "Users`"
                  . " Where `CtrlMapID`=" . WebLib::GetVal($_SESSION, 'UserMapID', TRUE);
          $Data->show_sel("UserMapID", "User", $Query, $Choice);
          ?>
        </select>
      </form>
      <?php
      $Query = 'Select `W`.`UserID`,`Action`,`AccessTime` FROM '
              . '(Select `UserID`,Max(`LogID`) as `LogID` FROM `' . MySQL_Pre . 'Logs`'
              . ' Group By `UserID`) as `L` JOIN `' . MySQL_Pre . 'Logs` as `W` '
              . ' ON (`W`.`LogID`=`L`.`LogID` AND `Action` NOT LIKE \'LogOut:%\')';
      echo "<b>Currently Active Users: </b>" . $Data->do_sel_query($Query);
    }
    if (WebLib::GetVal($_POST, 'User')) {
      $UserID = WebLib::GetVal($_POST, 'User', TRUE);
    } else {
      $UserID = WebLib::GetVal($_SESSION, 'UserMapID', TRUE);
    }
    $Query = "SELECT `LogID`,`IP` as `IP Address`,`AccessTime`,`Action`,`SessionID`,`Method`"
            . " FROM `" . MySQL_Pre . "Logs` "
            . " Where UserID='" . $UserID . "'"
            . " ORDER BY `LogID` desc limit 50;";
    $Data->ShowTable($Query);
    //echo "<br />" . $Query;
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
