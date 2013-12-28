<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Menu Management');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
WebLib::IncludeCSS('users/css/MenuACL.css');
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
  include __DIR__ . '/MenuData.php';
  WebLib::ShowMenuBar('USER');
  ?>
  <div class="content">
    <?php
    WebLib::ShowMsg();
    $Data = new MySQLiDBHelper();
    $RowsUser = $Data->query('Select `UserMapID`,`UserName` '
            . 'FROM `' . MySQL_Pre . 'Users`');
    $RowsMenu = $Data->query('Select `MenuID`,`AppID`,`Caption` '
            . 'FROM `' . MySQL_Pre . 'MenuItems` Order By `AppID`,`MenuOrder`');
    ?>
    <form method="post" action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>">
      <div class="column">
        <ul>
          <?php
          foreach ($RowsUser as $Index => $User) {
            echo '<li class="ListItem">'
            . '<label for="User' . $User['UserMapID'] . '" >'
            . '<input id="User' . $User['UserMapID'] . '" type="checkbox" name="UserMapID[]" '
            . 'value="' . $User['UserMapID'] . '" />'
            . $User['UserName']
            . '</label></li>';
          }
          ?>
        </ul>
      </div>
      <div class="column">
        <ul>
          <?php
          foreach ($RowsMenu as $Index => $Menu) {
            echo '<li class="ListItem">'
            . '<label for="Menu' . $Menu['MenuID'] . '" >'
            . '<input id="Menu' . $Menu['MenuID'] . '" type="checkbox" name="MenuID[]" '
            . 'value="' . $Menu['MenuID'] . '" />'
            . '<strong>' . $Menu['AppID'] . '=>' . $Menu['Caption'] . '</strong>'
            . '</label></li>';
          }
          ?>
        </ul>
      </div>
      <div  class="column">
        <pre>
          <?php
          print_r($_POST);
          ?>
        </pre>
      </div>
      <div style="clear: both;"></div>
      <input type="submit"  name="CmdMenuAction" value="Allow" />
      <input type="submit"  name="CmdMenuAction" value="Restrict" />
      <input type="submit"  name="CmdMenuAction" value="Activate" />
      <input type="submit"  name="CmdMenuAction" value="Deactivate" />
      <input type="hidden" name="FormToken" value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
    </form>
    <?php
    unset($Data);
    unset($RowsUser);
    unset($RowsMenu);
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

