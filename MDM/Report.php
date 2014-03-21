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
WebLib::IncludeJS('MDM/js/Report.js');
?>
</head>
<body>
  <script src="js/defer.js" defer></script>
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

        <label for="DistResult" style="text-align: center">
          <h3> Mid Day Meal Report Table</h3></label>
        <div>
          <table class="table" border="2px" cellpadding="10px"
                 cellspacing="2px" id="TotalReport" align="center";>
            <tr class="table-header">
              <th >SL.No</th>
              <th>Name of SubDiv</th>
              <th>Reported Blocks</th>
              <th>Number Of Blocks</th>
              <th>Meal Maid</th>
              <th>Total Student</th>
            </tr>
          </table>
        </div>
        <div style="clear: both"></div>
        <label for="DistResult" style="text-align: center">
          <h3>District Mid Day Meal Report</h3></label>

        <div class="FieldGroup">
          <label for="TotalMeal" class="myfont">Total Number Of Meal Made
            <input type="text" name="TotalMeal" id="TotalMeal" disabled />
          </label></div>
        <div class="FieldGroup">
          <label for="TotalStudent" class="myfont">Total Number Of Student
            <input type="text" name="TotalStudent" id="TotalStudent" disabled />
          </label></div>
        <div class="FieldGroup">
          <label for="ReportedSchool" class="myfont">Total Reported School
            <input type="text" name="ReportedSchool" id="ReportedSchool" disabled />
          </label></div>
        <div class="FieldGroup">
          <label for="TotalSchool" class="myfont">Total Number Of School
            <input type="text" name="TotalSchool" id="TotalSchool" disabled />
          </label> </div>
        <div style="clear: both"></div>
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
