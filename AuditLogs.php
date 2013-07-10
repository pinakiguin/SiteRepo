<?php
include_once 'lib.inc.php';

initHTML5page("User Activity");
IncludeCSS();
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
  ShowMenuBar();
  ?>
  <div class="content">
    <h2>Activity Logs</h2>
    <?php
    $Data = new MySQLiDB();
    if (GetVal($_SESSION, 'UserLevel') == '1') {
      ?>
      <form name="frm_activity" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
        <label for="Officer">Officer:</label>
        <select name="User" onChange="javascript:document.frm_activity.submit();">
          <?php
          if (GetVal($_POST, 'User') == "")
            $Choice = "-- Choose --";
          else
            $Choice = GetVal($_POST, 'User');
          $Query = "SELECT `UserMapID`, concat(`UserName`,' [',`UserID`,']') as User FROM " . MySQL_Pre . "Users U"
                  . " Where Activated AND CtrlMapID=" . GetVal($_SESSION, 'UserMapID', TRUE);
          $Data->show_sel("UserMapID", "User", $Query, $Choice);
          ?>
        </select>
      </form>
      <?php
      $Query = "SELECT l.LogID,l.`IP` as `IP Address`,l.`AccessTime` , l.`Action`, l.`SessionID`, l.`Method`"
              . " FROM " . MySQL_Pre . "Logs l Where l.`UserMapID`=" . GetVal($_POST, 'User', TRUE)
              . " ORDER BY l.`LogID` desc limit 50;";
    }
    else
      $Query = "SELECT LogID,`IP` as `IP Address`,AccessTime , Action, SessionID, Method "
              . " FROM " . MySQL_Pre . "Logs "
              . " Where UserID=" . GetVal($_SESSION, 'UserMapID', TRUE) . " ORDER BY LogID desc limit 50;";
    $Data->Debug = 1;
    $Data->ShowTable($Query);
    //echo "<br />" . $Query;
    ?>
  </div>
  <div class="pageinfo">
    <?php pageinfo(); ?>
  </div>
  <div class="footer">
    <?php footerinfo(); ?>
  </div>
</body>
</html>
