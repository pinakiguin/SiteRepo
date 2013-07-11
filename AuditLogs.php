<?php
include_once 'lib.inc.php';
AuthSession();
Html5Header("User Activity");
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
    $Query = "SELECT count(*) FROM " . MySQL_Pre . "Users U"
            . " Where CtrlMapID=" . GetVal($_SESSION, 'UserMapID', TRUE);
    if ($Data->do_max_query($Query) > 0) {
      ?>
      <form name="frm_activity" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
        <label for="User">Select User:</label>
        <select name="User" onChange="javascript:document.frm_activity.submit();">
          <?php
          if (GetVal($_POST, 'User') == "")
            $Choice = "-- Choose --";
          else
            $Choice = GetVal($_POST, 'User');
          $Query = "SELECT `UserMapID`, concat(`UserName`,' [',`UserID`,']') as `User`"
                  . " FROM `" . MySQL_Pre . "Users`"
                  . " Where `CtrlMapID`=" . GetVal($_SESSION, 'UserMapID', TRUE);
          $Data->show_sel("UserMapID", "User", $Query, $Choice);
          ?>
        </select>
      </form>
      <?php
      $UserID = GetVal($_POST, 'User', TRUE);
    }
    else {
      $UserID = GetVal($_SESSION, 'UserMapID', TRUE);
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
    <?php pageinfo(); ?>
  </div>
  <div class="footer">
    <?php footerinfo(); ?>
  </div>
</body>
</html>
