<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Departments');
WebLib::IncludeCSS();
if (NeedsDB) {
  WebLib::CreateDB('MPR');
}
?>
</head>
<body>
  <div class="TopPanel">
    <div class="LeftPanelSide"></div>
    <div class="RightPanelSide"></div>
    <h1><?php echo AppTitle; ?></h1>
  </div>
  <div class="Header"></div>
  <form method="post" action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>">
    <div>
      <div style="height: 200px;overflow-y: scroll;float: left;border:1px solid;">
        <ul>
          <label>Name of Department</label>
          <input textbox name ="txtdeptname" id="txtdeptname"/>
          <input type="submit" id="Cmdsub" name="Cmdsub">
        </ul>
      </div>
  </form>

  <?php
  WebLib::ShowMenuBar('MPR');
  ?>
  <div class="content">
    <?php
    $Data = new MySQLiDBHelper();
    $DataACL['UserMapID'] = $_SESSION['UserMapID'];
    $DataACL['DeptName'] = $_POST['DeptName'];
    $Data->insert(MySQL_Pre . 'Departments', $DataACL);
    //echo'Add';
    $_SESSION['Msg'] = 'Add Successfully!';
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

