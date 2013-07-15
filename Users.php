<?php
require_once('lib.inc.php');
include_once 'php-mailer/GMail.lib.php';
WebLib::AuthSession();
WebLib::Html5Header('Users');
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
  WebLib::ShowMenuBar();
  $Data = new MySQLiDB();
  $action = 0;
  if (WebLib::GetVal($_POST, 'FormToken') !== NULL) {
    if (WebLib::GetVal($_POST, 'FormToken') !== WebLib::GetVal($_SESSION, 'FormToken')) {
      $action = 1;
    } else {
      // Authenticated Inputs
      switch (WebLib::GetVal($_POST, 'CmdSubmit')) {
        case 'Create':
          if (strlen(WebLib::GetVal($_POST, 'UserName')) > 2) {
            $Query = 'Insert Into `' . MySQL_Pre . 'Users` (`UserName`,`CtrlMapID`,`Registered`,`Activated`)'
                    . ' Values(\'' . WebLib::GetVal($_POST, 'UserName', TRUE) . '\',' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE) . ',0,0)';
          } else {
            $Query = '';
            $_SESSION['Msg'] = 'UserName must be at least 3 characters or more.';
          }
          break;
        case 'Activate':
          $Query = 'Update `' . MySQL_Pre . 'Users` Set `Activated`=1'
                  . ' Where `Activated`=0 AND `CtrlMapID`=' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE)
                  . ' AND `UserMapID`=' . WebLib::GetVal($_POST, 'UserMapID');
          $User = $Data->do_max_query('Select CONCAT(`UserName`,\'|\',`UserID`) FROM `' . MySQL_Pre . 'Users`'
                  . ' Where UserMapID=\'' . WebLib::GetVal($_POST, 'UserMapID') . '\'');
          $User = explode('|', $User);
          $Subject = 'User Account Activated - SRER 2014';
          $Body = '<span>Your UserID: <b>' . $User[1] . '</b> is now Activated</span>';
          $Mail = json_decode(GMailSMTP($User[1], $User[0], $Subject, $Body));
          break;
        case 'De-Activate':
          $Query = 'Update `' . MySQL_Pre . 'Users` Set `Activated`=0'
                  . ' Where `Activated`=1 AND `CtrlMapID`=' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE)
                  . ' AND `UserMapID`=' . WebLib::GetVal($_POST, 'UserMapID');
          $User = $Data->do_max_query('Select CONCAT(`UserName`,\'|\',`UserID`) FROM `' . MySQL_Pre . 'Users`'
                  . ' Where UserMapID=\'' . WebLib::GetVal($_POST, 'UserMapID') . '\'');
          $User = explode('|', $User);
          $Subject = 'User Account De-Activated - SRER 2014';
          $Body = '<span>Your UserID: <b>' . $User[1] . '</b> is now De-Activated</span>';
          $Mail = json_decode(GMailSMTP($User[1], $User[0], $Subject, $Body));
          break;
        case 'Un-Register':
          $Query = 'Update `' . MySQL_Pre . 'Users` Set `Registered`=0,`Activated`=0'
                  . ' Where `Registered`=1 AND `CtrlMapID`=' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE)
                  . ' AND `UserMapID`=' . WebLib::GetVal($_POST, 'UserMapID');
          $User = $Data->do_max_query('Select CONCAT(`UserName`,\'|\',`UserID`) FROM `' . MySQL_Pre . 'Users`'
                  . ' Where UserMapID=\'' . WebLib::GetVal($_POST, 'UserMapID') . '\'');
          $User = explode('|', $User);
          $Subject = 'User Account Un-Registered - SRER 2014';
          $Body = '<span>Your UserID: <b>' . $User[1] . '</b> is now Un-Registered</span><br/>'
                  . '<b>Please Register again to change EmailID and Password</b>';
          $Mail = json_decode(GMailSMTP($User[1], $User[0], $Subject, $Body));
          break;
      }
      if ($Query !== '') {
        $Inserted = $Data->do_ins_query($Query);
        if ($Inserted > 0) {
          if (WebLib::GetVal($_POST, 'CmdSubmit') === 'Create') {
            $_SESSION['Msg'] = 'User Created Successfully!';
          } else {
            if ($Mail->Sent === TRUE) {
              $_SESSION['Msg'] = 'User ' . WebLib::GetVal($_POST, 'CmdSubmit') . 'd Successfully!';
            } else {
              $_SESSION['Msg'] = 'User ' . WebLib::GetVal($_POST, 'CmdSubmit') . 'd Successfully! But Unable to Send eMail!';
            }
          }
        } else {
          $_SESSION['Msg'] = 'Unable to ' . WebLib::GetVal($_POST, 'CmdSubmit') . ' User!';
        }
      }
    }
  }
  $_SESSION['FormToken'] = md5($_SERVER['REMOTE_ADDR'] . session_id() . microtime());
  ?>
  <div class="content">
    <?php
    $Msg[0] = '<h2>Manage Users</h2>';
    $Msg[1] = '<h2>Un-Authorised</h2>';
    echo $Msg[$action];
    WebLib::ShowMsg();
    if ($action == 0) {
      ?>
      <div class="FieldGroup" id="dialog-form" style="border: 1px solid black">
        <form name="frmCreateUser" id="frmCreateUser" method="post" action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>">
          <label for="UserName">User Name:</label><br />
          <input type="text" name="UserName" id="UserName" required="required" />
          <br />
          <input type="hidden" name="FormToken" value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
          <br />
          <input type="submit" name="CmdSubmit" value="Create" />
        </form>
      </div>
      <div class="FieldGroup" style="border: 1px solid black">
        <form name="frmEditUser" id="frmCreateUser" method="post" action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>">
          <label for="UserName">User Name:</label><br />
          <select name="UserMapID">
            <?php
            $Query = 'Select `UserMapID`,CONCAT(`UserName`,\' [\',IFNULL(`UserID`,\'\'),\']\') as `UserName` '
                    . ' FROM `' . MySQL_Pre . 'Users` '
                    . ' Where `CtrlMapID`=' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE)
                    . ' Order By `UserName`';
            $Data->show_sel('UserMapID', 'UserName', $Query, WebLib::GetVal($_POST, 'UserMapID'));
            ?>
          </select>
          <br />
          <input type="hidden" name="FormToken" value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
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
    $Data->ShowTable('Select `UserID` as `E-Mail Address`,`UserName`,`LoginCount`,`LastLoginTime`,`Registered`,`Activated`'
            . ' FROM `' . MySQL_Pre . 'Users` '
            . ' Where `CtrlMapID`=' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE));
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

