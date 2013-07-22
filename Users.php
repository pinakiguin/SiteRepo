<?php
/**
 * @todo Integrate SMS Gateway
 * @ todo Working on User Management Module
 */
require_once('lib.inc.php');
include_once 'php-mailer/GMail.lib.php';
WebLib::AuthSession();
WebLib::Html5Header('Users');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('css/chosen.min.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
?>
<script type="text/javascript" >
  $(function() {
    $('#CreateUser-dialog-form').dialog({
      autoOpen: false,
      modal: true
    });
    $('#CmdCreateSubmit').button();
    $('#CmdCreate').bind('click', function() {
      $('#CreateUser-dialog-form').dialog('open');
    });
    $('input[type="submit"]').button();
    $('input[type="button"]').button();
    $('select').chosen({width: '400px'});
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
  include 'UsersData.php';
  WebLib::ShowMenuBar();
  $Data = new MySQLiDB();
  ?>
  <div class="content">
    <?php
    $Msg[0] = '<h2>Manage Users</h2>';
    $Msg[1] = '<h2>Un-Authorised</h2>';
    echo $Msg[$_SESSION['action']];
    WebLib::ShowMsg();
    if ($_SESSION['action'] == 0) {
      ?>
      <div class="FieldGroup" id="CreateUser-dialog-form" style="display:none">
        <form name="frmCreateUser" id="frmCreateUser" method="post" action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>">
          <label for="UserName">User Name: </label>
          <input type="text" name="UserName" id="UserName" required="required" />
          <br />
          <input type="hidden" name="FormToken" value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
          <br />
          <input type="submit" id="CmdCreateSubmit" name="CmdSubmit" value="Create" />
        </form>
      </div>

      <form name="frmEditUser" id="frmCreateUser" method="post" action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>">
        <div class="FieldGroup">
          <label for="UserName">Select User: </label><br/>
          <select name="UserMapID" data-placeholder="Select an User">
            <?php
            $Query = 'Select `UserMapID`,CONCAT(`UserName`,\' [\',IFNULL(`UserID`,\'Un-Registered\'),\']\') as `UserName` '
                    . ' FROM `' . MySQL_Pre . 'Users` '
                    . ' Where `CtrlMapID`=' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE)
                    . ' Order By `UserName`';
            $Data->show_sel('UserMapID', 'UserName', $Query, WebLib::GetVal($_POST, 'UserMapID'));
            ?>
          </select><input type="submit" name="CmdSubmit" value="Show" /><hr/>
          <br />
          <input type="hidden" name="FormToken" value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
          <br />
          <input type="button" id="CmdCreate" value="Create New User" />
          <input type="submit" name="CmdSubmit" value="Impersonate" />
          <?php if (WebLib::GetVal($_SESSION, 'ImpFromUserMapID') !== NULL) { ?>
            <input type="submit" name="CmdSubmit" value="Stop Impersonating" />
          <?php } ?>
          <input type="submit" name="CmdSubmit" value="Activate" />
          <input type="submit" name="CmdSubmit" value="De-Activate" />
          <input type="submit" name="CmdSubmit" value="Un-Register" /><hr/>
          <label for="UserName">District:</label><br/>
          <select name="DistCode" data-placeholder="Select a District" onchange="document.frmEditUser.submit();">
            <?php
            $Query = 'Select `DistCode`,CONCAT(`DistCode`,\' - \',`District`) as `District` '
                    . ' FROM `' . MySQL_Pre . 'SRER_Districts` '
                    . ' Where `UserMapID`=' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE)
                    . ' Order By `District`';
            $Data->show_sel('DistCode', 'District', $Query, WebLib::GetVal($_POST, 'DistCode'));
            ?>
          </select>
          <input type="submit" name="CmdSubmit" value="Assign Whole District" /><br />
          <label for="UserName">Assembly Constituency:</label><br/>
          <select name="ACNo" data-placeholder="Select an Assembly Constituency" onchange="document.frmEditUser.submit();">
            <?php
            $Query = 'Select `ACNo`,CONCAT(`DistCode`,\' - \',`ACNo`,\' - \',`ACName`) as `ACName` '
                    . ' FROM `' . MySQL_Pre . 'SRER_ACs` '
                    . ' Where `DistCode`=\'' . WebLib::GetVal($_POST, 'DistCode') . '\' '
                    . ' Order By `ACNo`';
            $Data->show_sel('ACNo', 'ACName', $Query, WebLib::GetVal($_POST, 'ACNo'));
            ?>
          </select>
          <input type="submit" name="CmdSubmit" value="Assign Whole AC" /><br />
          <label for="UserName">Part:</label><br/>
          <select name="PartID[]" data-placeholder="Select Parts" multiple="multiple" >
            <?php
            $Query = 'Select `PartID`,CONCAT(`PartNo`,\' - \',`PartName`) as `PartName` '
                    . ' FROM `' . MySQL_Pre . 'SRER_PartMap` '
                    . ' Where `ACNo`=\'' . WebLib::GetVal($_POST, 'ACNo') . '\'' // AND `UserMapID`=' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE)
                    . ' Order By `PartNo`';
            $Data->show_sel('PartID', 'PartName', $Query, WebLib::GetVal($_POST, 'PartID'));
            ?>
          </select>
          <input type="submit" name="CmdSubmit" value="Assign Part" />
        </div>
        <?php
        if (WebLib::GetVal($_POST, 'UserMapID') !== NULL) {
          ?>
          <div class="FieldGroup">
            <?php
            $_SESSION['Query'] = 'Select `DistCode`,`District`'
                    . ' FROM `' . MySQL_Pre . 'SRER_Districts` '
                    . ' Where `UserMapID`=' . WebLib::GetVal($_POST, 'UserMapID', TRUE);
            //}
            $Data->ShowTable($_SESSION['Query']);
            ?>
            <?php
            $_SESSION['Query'] = 'Select `District`,`ACNo`,`ACName`'
                    . ' FROM `' . MySQL_Pre . 'SRER_ACs` A '
                    . ' JOIN `' . MySQL_Pre . 'SRER_Districts` D ON(A.`DistCode`=D.`DistCode`)'
                    . ' Where A.`UserMapID`=' . WebLib::GetVal($_POST, 'UserMapID', TRUE);
            $Data->ShowTable($_SESSION['Query']);
            ?>
          </div>
          <div class="FieldGroup"  style="height: 400px;overflow:auto;">
            <?php
            $_SESSION['Query'] = 'Select `ACNo`,`PartNo`,`PartName`'
                    . ' FROM `' . MySQL_Pre . 'SRER_PartMap`'
                    . ' Where `UserMapID`=' . WebLib::GetVal($_POST, 'UserMapID', TRUE);
            $Data->ShowTable($_SESSION['Query']);
            ?>
          </div>
          <?php
        }
        ?>
      </form>
      <div style="clear:both;"></div>
      <hr />
      <h3>Users:</h3>
      <?php
    }
    //if (WebLib::GetVal($_SESSION, 'Query') === NULL) {
    $_SESSION['Query'] = 'Select `UserID` as `E-Mail Address`,`UserName`,`LoginCount`,`LastLoginTime`,`Registered`,`Activated`'
            . ' FROM `' . MySQL_Pre . 'Users` '
            . ' Where `CtrlMapID`=' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE);
    //}
    $Data->ShowTable($_SESSION['Query']);
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

