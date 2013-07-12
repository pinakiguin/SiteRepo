<?php
include_once 'lib.inc.php';

initHTML5page("Home");
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
  <div class="Header"></div>
  <?php
  ShowMenuBar();
  ?>
  <div class="content">
    <h2>User Registration</h2>
    <?php
    $Data = new MySQLiDB();
    if (GetVal($_POST, 'UserID') !== NULL) {
      $email = GetVal($_POST, 'UserID', TRUE);
      $MobileNo = GetVal($_POST, 'MobileNo', TRUE);
      //@todo Send Email after registration Specifing UserID for verification and password.
      //@todo Password not to be asked in the form if asked should be sent encrypted Activation Should not be here
      $Pass = GetVal($_POST, 'UserPass', TRUE);
      $PartMapID = GetVal($_POST, 'PartMapID', TRUE);
      if (StaticCaptcha()) {

        $Qry = "Update `" . MySQL_Pre . "Users` "
                . " SET `UserID`='{$email}',`UserPass`=MD5('{$Pass}'),`MobileNo`='{$MobileNo}',`Registered`=1"
                . " Where Registered=0 AND Activated=0 AND UserMapID='{$PartMapID}'";
        $Submitted = $Data->do_ins_query($Qry);
        $_SESSION['Msg'] = $Qry;
        if ($Submitted > 0) {
          $_SESSION['Msg'] = "<h3>Regristration successful.</h3><b>Please Note: </b>Password will be sent to: {$email}";
          ShowMsg();
        } else {
          echo "<h3>Unable to send request.</h3>";
        }
      } else {
        echo "<h3>You solution of the Math in the image is wrong.</h3>";
      }
    } else {
      ?>
      <form name="feed_frm" method="post" action="<?php echo GetVal($_SERVER, 'PHP_SELF', FALSE); ?>" >
        <div class="FieldGroup">
          <h3>User:</h3>
          <select name="PartMapID">
            <?php
            $Data->show_sel("UserMapID", "UserName", "Select `UserMapID`,`UserName` "
                    . " FROM `" . MySQL_Pre . "Users` "
                    . " Where NOT `Registered` AND NOT `Activated`;", GetVal($_POST, 'PartMapID', TRUE));
            ?>
          </select>
        </div>
        <div style="clear:both;"></div>
        <div class="FieldGroup">
          <h3>E-Mail Address:</h3>
          <input size="35" maxlength="35"	type="text" name="UserID" value="<?php echo GetVal($_POST, 'UserID'); ?>" />
        </div>
        <div class="FieldGroup">
          <h3>Mobile No:</h3>
          <input size="35" maxlength="35"	type="text" name="MobileNo" value="<?php echo GetVal($_POST, 'MobileNo'); ?>" />
        </div>
        <div style="clear:both;"></div>
        <div class="FieldGroup">
          <input type="hidden" name="LoginToken" value="<?php echo GetVal($_SESSION, 'Token'); ?>" />
        </div>
        <div class="FieldGroup">
          <?php StaticCaptcha(TRUE); ?>
          <input style="width:80px;" type="submit" value="Register"/>
        </div>
      </form>
      <?php
    }
    ?>
    <div style="clear:both;"></div>
  </div>
  <div class="pageinfo">
    <?php pageinfo(); ?>
  </div>
  <div class="footer">
    <?php footerinfo(); ?>
  </div>
</body>
</html>
