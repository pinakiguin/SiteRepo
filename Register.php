<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once 'lib.inc.php';
require_once 'php-mailer/GMail.lib.php';
require_once 'smsgw/smsgw.inc.php';
WebLib::initHTML5page("Home");
WebLib::IncludeCSS();
WebLib::IncludeJS("js/md5.js");
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
  WebLib::ShowMenuBar('WebSite');
  ?>
  <div class="content">
    <h2>User Registration</h2>
    <?php
    $Data = new MySQLiDB();
    $UnregisteredUsers = $Data->do_sel_query('Select `UserMapID`,`UserName` '
            . ' FROM `' . MySQL_Pre . 'Users` '
            . ' Where `Registered`=0 AND `Activated`=0;');
    if (WebLib::GetVal($_POST, 'UserID') !== NULL) {
      $email = WebLib::GetVal($_POST, 'UserID', TRUE);
      $MobileNo = WebLib::GetVal($_POST, 'MobileNo', TRUE);
      //@ todo Send Email after registration Specifing UserID for verification and password.
      $Pass = WebLib::GeneratePassword(10, 2, 2, 2);
      $UserMapID = WebLib::GetVal($_POST, 'UserMapID', TRUE);
      if (WebLib::StaticCaptcha()) {
        $Qry = "Update `" . MySQL_Pre . "Users` "
                . " SET `UserID`='{$email}',`UserPass`=MD5('{$Pass}'),`MobileNo`='{$MobileNo}',`Registered`=1"
                . " Where Registered=0 AND Activated=0 AND UserMapID='{$UserMapID}'";
        $Submitted = $Data->do_ins_query($Qry);
        if ($Submitted > 0) {

          $UserName = $Data->do_max_query("Select `UserName` FROM `" . MySQL_Pre . "Users`"
                  . " Where UserMapID='{$UserMapID}'");
          $Subject = "User Account Details - SRER 2014";
          $Body = "<b>UserID: </b><span> {$email}</span><br/>"
                  . "<b>Password: </b><span> {$Pass}</span>";
          $TxtBody = 'UserID: ' . $email . "\r\n" . 'Password: ' . $Pass;
          $SentSMS = '';
          if (UseSMSGW === true) {
            SMSGW::SendSMS($TxtBody, $MobileNo);
            $SentSMS = ' and ' . $MobileNo;
          }
          $MailSent = json_decode(GMailSMTP($email, $UserName, $Subject, $Body, $TxtBody));

          WebLib::ShowMsg();
          if ($MailSent->Sent) {
            $_SESSION['Msg'] = "<h3>Regristration successful.</h3>"
                    . "<b>Please Note: </b>Password is sent to: {$email}" . $SentSMS;
          }
          WebLib::ShowMsg();
        } else {
          echo "<h3>Unable to send request.</h3>";
        }
      } else {
        echo "<h3>You solution of the Math in the image is wrong.</h3>";
      }
    } elseif ($UnregisteredUsers > 0) {
      ?>
      <form name="feed_frm" method="post" action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF', FALSE); ?>" >
        <div class="FieldGroup">
          <h3>User:</h3>
          <select name="UserMapID">
            <?php
            $Data->show_sel("UserMapID", "UserName", "Select `UserMapID`,`UserName` "
                    . " FROM `" . MySQL_Pre . "Users` "
                    . " Where NOT `Registered` AND NOT `Activated`;", WebLib::GetVal($_POST, 'UserMapID', TRUE));
            ?>
          </select>
        </div>
        <div style="clear:both;"></div>
        <div class="FieldGroup">
          <h3>E-Mail Address:</h3>
          <input placeholder="Valid e-Mail Address" size="35" maxlength="35"	type="email" name="UserID"
                 value="<?php echo WebLib::GetVal($_POST, 'UserID'); ?>" required />
        </div>
        <div class="FieldGroup">
          <h3>Mobile No:</h3>
          <input placeholder="Mobile Number" size="15" maxlength="10"	min="7000000000" type="number" name="MobileNo"
                 value="<?php echo WebLib::GetVal($_POST, 'MobileNo'); ?>" required />
        </div>
        <div style="clear:both;"></div>
        <div class="FieldGroup">
          <input type="hidden" name="LoginToken" value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
        </div>
        <div class="FieldGroup">
          <?php WebLib::StaticCaptcha(TRUE); ?>
          <input style="width:80px;" type="submit" value="Register"/>
        </div>
      </form>
      <?php
    } else {
      echo "<h3>All Users are registered.</h3>";
    }
    ?>
    <div style="clear:both;"></div>
  </div>
  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>
