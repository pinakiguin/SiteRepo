<?php
require_once __DIR__ . '/../lib.inc.php';
WebLib::AuthSession();
WebLib::Html5Header('Mid Day Meal');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeJS('MDM/js/neumeric.js');
WebLib::IncludeCSS('MDM/css/forms.css');
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
WebLib::IncludeCSS('DataTables/media/css/jquery.dataTables_themeroller.css');
WebLib::IncludeJS('DataTables/media/js/jquery.dataTables.js');
WebLib::IncludeJS('MDM/js/Report.js');
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
  WebLib::ShowMenuBar('MDM');
  ?>
  <div class="content">
    <span class="Message" id="Msg" style="float: right;">
      <b>Loading Please Wait...</b>
    </span>
    <div class="formWrapper">
      <form method="post" action="<?php
      echo WebLib::GetVal($_SERVER, 'PHP_SELF');
      ?>" id="frmNewAdd" >
        <h3>Report Mid Day Meal Data</h3>
        <div class="FieldGroup">
          <label for="SubDivID"><span class="myfont">Select The SubDivision Name</span>
            <select id="SubDivID" name="SubDivID"
                    data-placeholder="Select SubDiv Name">
            </select>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="BlockID"><span class="myfont">Select The Block Name</span>
            <select id="BlockID" name="BlockID"
                    data-placeholder="Select Block">
            </select>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="SchoolID"><span class="myfont">Select Name of School Name</span>
            <select id="SchoolID" name="SchoolID"
                    data-placeholder="Select SchoolName">
            </select>
          </label>
        </div>

        <table id="Mdmreport" class="display stripe row-border hover order-column"
               cellspacing="0" width="100%" style="
               font-weight:bold;font-family:Calibri;font-size:15px">
          <thead>
            <tr class="myfont">
              <th>School Name</th>
              <th>Type of School</th>
              <th>Report Date</th>
              <th>Number Of Present</th>
              <th>Total Number Of Student</th>
            </tr>
          </thead>
        </table>
        <div style="clear: both;"></div>
        <div class="formControl">
          <input type="submit" name="CmdSubmit" value="Show Data" id="CmdSaveUpdate">
          <input type="hidden" id="TxtAction" name="CmdSubmit" value="" />
          <input type="button" name="Refresh" value="Refresh" id="Refresh">
        </div>
        <input type="hidden" name="FormToken" id="FormToken"
               value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
        <input type="hidden" name="AjaxToken" id="AjaxToken"
               value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
      </form>
      <pre id="Error">
      </pre>
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
