<?php
require_once('lib.inc.php');
AuthSession();
Html5Header("Users");
IncludeCSS();
IncludeJS("js/md5.js");
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
  $Data = new MySQLiDB();
  $action = 0;
  if (GetVal($_POST, 'FormToken') !== NULL) {
    if (GetVal($_POST, 'FormToken') !== GetVal($_SESSION, 'FormToken')) {
      $action = 1;
    } else {
      // Authenticated Inputs
      switch (GetVal($_POST, 'CmdSubmit')) {
        case "Create":
          if (strlen(GetVal($_POST, 'UserName')) > 2) {
            $Query = "Insert Into `" . MySQL_Pre . "Users` (`UserName`,`CtrlMapID`,`Registered`,`Activated`)"
                    . " Values('" . GetVal($_POST, 'UserName', TRUE) . "'," . GetVal($_SESSION, 'UserMapID', TRUE) . ",0,0)";
          } else {
            $Query = "";
            $_SESSION['Msg'] = "UserName must be at least 3 characters or more.";
          }
          break;
        case "Activate":
          $Query = "Update `" . MySQL_Pre . "Users` Set `Activated`=1"
                  . " Where `Activated`=0 AND `CtrlMapID`=" . GetVal($_SESSION, 'UserMapID', TRUE)
                  . " AND `UserMapID`=" . GetVal($_POST, 'UserMapID');
          break;
        case "De-Activate":
          $Query = "Update `" . MySQL_Pre . "Users` Set `Activated`=0"
                  . " Where `Activated`=1 AND `CtrlMapID`=" . GetVal($_SESSION, 'UserMapID', TRUE)
                  . " AND `UserMapID`=" . GetVal($_POST, 'UserMapID');
          break;
        case "Un-Register":
          $Query = "Update `" . MySQL_Pre . "Users` Set `Registered`=0,`Activated`=0"
                  . " Where `Registered`=1 AND `CtrlMapID`=" . GetVal($_SESSION, 'UserMapID', TRUE)
                  . " AND `UserMapID`=" . GetVal($_POST, 'UserMapID');
          break;
      }
      if ($Query !== "") {
        $Inserted = $Data->do_ins_query($Query);
        if ($Inserted > 0) {
          $_SESSION['Msg'] = "User " . GetVal($_POST, 'CmdSubmit') . "d Successfully!";
        } else {
          $_SESSION['Msg'] = "Unable to " . GetVal($_POST, 'CmdSubmit') . " User!";
        }
      }
    }
  }
  $_SESSION['FormToken'] = md5($_SERVER['REMOTE_ADDR'] . session_id() . microtime());
  ?>
  <div class="content">
    <?php
    ShowMsg();
    $Msg[0] = "<h2>Manage Users</h2>";
    $Msg[1] = "<h2>Un-Authorised</h2>";
    echo $Msg[$action];
    if ($action == 0) {
      ?>
      <div class="FieldGroup" style="border: 1px solid black">
        <form name="frmCreateUser" id="frmCreateUser" method="post" action="<?php echo GetVal($_SERVER, 'PHP_SELF'); ?>">
          <label for="UserName">User Name:</label><br />
          <input type="text" name="UserName" id="UserName" required="required" />
          <br />
          <input type="hidden" name="FormToken" value="<?php echo GetVal($_SESSION, 'FormToken') ?>" />
          <br />
          <input type="submit" name="CmdSubmit" value="Create" />
        </form>
      </div>
      <div class="FieldGroup" style="border: 1px solid black">
        <form name="frmEditUser" id="frmCreateUser" method="post" action="<?php echo GetVal($_SERVER, 'PHP_SELF'); ?>">
          <label for="UserName">User Name:</label><br />
          <select name="UserMapID">
            <?php
            $Query = "Select `UserMapID`,CONCAT(`UserName`,' [',IFNULL(`UserID`,''),']') as `UserName` "
                    . " FROM `" . MySQL_Pre . "Users` "
                    . " Where `CtrlMapID`=" . GetVal($_SESSION, 'UserMapID', TRUE) . " Order By `UserName`";
            $Data->show_sel("UserMapID", "UserName", $Query, GetVal($_POST, 'UserMapID'));
            ?>
          </select>
          <br />
          <input type="hidden" name="FormToken" value="<?php echo GetVal($_SESSION, 'FormToken') ?>" />
          <br />
          <input type="submit" name="CmdSubmit" value="Activate" />
          <input type="submit" name="CmdSubmit" value="De-Activate" />
          <input type="submit" name="CmdSubmit" value="Un-Register" />
        </form>
      </div>
      <div style="clear:both;"></div>
      <hr />
      <h3>Users:</h3>
      <?php
    }
    $Data->ShowTable("Select `UserID`,`UserName`,`LoginCount`,`LastLoginTime`,`Registered`,`Activated` FROM `" . MySQL_Pre . "Users` Where `CtrlMapID`=" . GetVal($_SESSION, 'UserMapID', TRUE));
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

