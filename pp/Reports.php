<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Reports');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
WebLib::IncludeCSS('DataTables/media/css/jquery.dataTables_themeroller.css');
WebLib::IncludeJS('DataTables/media/js/jquery.dataTables.js');
WebLib::IncludeJS('js/forms.js');
WebLib::IncludeCSS('css/forms.css');
WebLib::IncludeJS('pp/js/Reports.js');
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
  WebLib::ShowMenuBar('PP');
  ?>
  <form method="post"
        action="<?php
        echo WebLib::GetVal($_SERVER, 'PHP_SELF');
        ?>" >
    <div class="jQuery-ButtonSet-Wrapper">
      <div class="jQuery-ButtonSet-Centre">
        <div id="CmdReports" class="jQuery-ButtonSet">
          <input type="radio" id="DataPPs"
                 name="CmdReport" value="DataPPs"/>
          <label for="DataPPs">Polling Personnel</label>
          <input type="radio" id="DataOffices"
                 name="CmdReport" value="DataOffices"/>
          <label for="DataOffices">Offices</label>
          <!--input type="radio" id="DataPayScales"
                 name="CmdReport" value="DataPayScales"/>
          <label for="DataPayScales">Pay Scales</label-->
        </div>
      </div>
      <div class="jQuery-ButtonSet-Wrapper-content" style="font-size: 12px;">
        <span class="Message" id="Msg" style="float: right;">
          <b>Loading please wait...</b>
        </span>
        <table id="ReportDT" cellspacing="0" width="100%"
               class="display stripe row-border hover order-column" >
          <thead>
            <tr>
              <th>Name of the Office</th>
              <th>Designation of Officer-in-Charge</th>
              <th>Para/Tola/Street</th>
              <th>Village/Town/Street</th>
              <th>PostOffice</th>
              <th>PSCode</th>
              <th>PinCode</th>
              <th>Nature</th>
              <th>Status</th>
              <th>Phone</th>
              <th>Fax</th>
              <th>Mobile</th>
              <th>EMail</th>
              <th>Staffs</th>
              <th>ACNo</th>
            </tr>
          </thead>
        </table>
      </div>
      <pre id="Error">
      </pre>
      <input type="hidden" id="AjaxToken"
             value="<?php
             echo WebLib::GetVal($_SESSION, 'Token');
             ?>" />
    </div>
  </form>
  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>

