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
        <?php
        include __DIR__ . '/DataMPR.php';
        WebLib::ShowMsg();
        ?>
        <label for="DeptName"><strong>Name of Department</strong></label>
        <input type="text" name ="DeptName" id="DeptName" placeholder="Name of Department"/>
        <div class="formControl">
          <input type="submit" name="CmdSubmit" value="Create Department">
        </div>
        <input type="hidden" name="FormToken"
               value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
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

