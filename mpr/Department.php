<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Departments');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeJS('mpr/js/forms.js');
WebLib::IncludeCSS('mpr/css/forms.css');
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
  WebLib::ShowMenuBar('MPR');
  ?>
  <div class="content">
    <div class="formWrapper">
      <form method="post" action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>">
        <h3>Departments</h3>
        <label for="txtdeptname"><strong>Name of Department</strong></label>
        <input type="text" name ="txtdeptname" id="txtdeptname" placeholder="Name of Department"/>
        <?php
        $Data = new MySQLiDBHelper();
        if (WebLib::GetVal($_POST, 'txtdeptname') !== null) {
          $DataACL['UserMapID'] = $_SESSION['UserMapID'];
          $DataACL['DeptName'] = WebLib::GetVal($_POST, 'txtdeptname');
          $Data->insert(MySQL_Pre . 'MPR_Departments', $DataACL);
          echo'Add Successfully';
          $_SESSION['Msg'] = 'Add Successfully!';
        }
        ?>
        <div class="formControl">
          <input type="submit" id="Cmdsub" name="Cmdsub">
        </div>
      </form>
    </div>
  </div>
  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>

