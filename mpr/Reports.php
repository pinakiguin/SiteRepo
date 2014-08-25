<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Departments');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeJS('mpr/js/IAP.js');
WebLib::IncludeJS('mpr/js/neumeric.js');
WebLib::IncludeCSS('mpr/css/forms.css');
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
WebLib::IncludeCSS('DataTables/media/css/jquery.dataTables_themeroller.css');
WebLib::IncludeJS('DataTables/media/js/jquery.dataTables.js');
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
    <span class="Message" id="Msg" style="float: right;">
      <b>Loading Please Wait...</b>
    </span>

  <div class="formWrapper">
    <form method="post" action="<?php
    echo WebLib::GetVal($_SERVER, 'PHP_SELF');
    ?>" id="frmIAP"><?php
      include __DIR__ . '/DataMPR.php';
      ?>
      <span class="myHeader">MPR Reports</span>
      <hr/>
      <ol>
        <li>
          <a href="<?php echo $_SESSION['BaseURL']; ?>mpr/SchemeRepot.php">
            Scheme Wise Report
          </a>
        </li>
        <li>
          <a href="<?php echo $_SESSION['BaseURL']; ?>mpr/Chart.php">
            Chart Report
          </a>
        </li>
      </ol>
      <br>
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