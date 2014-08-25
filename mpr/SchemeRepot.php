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
      ?>" id="frmIAP" ><?php
            include __DIR__ . '/DataMPR.php';
            ?>
        <span class="myHeader">Scheme wise Report</span>
        <pre id="Error">
        </pre>
        <input type="submit" name="CreateReport" value="Vew Report" id="CreateReport">
        <input type="button" name="reset" id="reset" value="Reset">
        <input type="hidden" name="FormToken" id="FormToken"
               value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
        <input type="hidden" id="AjaxToken" name="AjaxToken"
               value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
      </form>
      <div style="clear: both;"></div>
      <table id="example" class="display stripe row-border hover order-column"
             cellspacing="0" width="100%" style="
             font-weight:bold;font-family:Calibri;font-size:15px">
        <thead>
          <tr>
            <th>Scheme ID</th>
            <th>Scheme Name</th>
            <th>Report Date</th>
            <th>Physical Progress</th>
            <th>Financial Progress</th>
            <th>Remarks</th>
          </tr>
        </thead>
      </table>
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