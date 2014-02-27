<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Mid Day Meal');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeJS('MDM/js/Entry.js');
WebLib::IncludeJS('MDM/js/neumeric.js');
WebLib::IncludeCSS('MDM/css/forms.css');
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
$_SESSION['FormToken'] = md5($_SERVER['REMOTE_ADDR']
    . session_id() . microtime());
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
      ?>" id="frmMealData" >
        <h3>Enter Meal Details of School</h3>

        <div class="FieldGroup">
          <label for="SchoolName"><span class="myfont">Select Name of School Name</span>
            <select id="SchoolName" name="SchoolName"
                    data-placeholder="Select SchoolName">
            </select>
          </label>
          <label for="TotalStudent" class="myfont">Total Student
          </label>
          <input type="text" name="TotalStudent" id="TotalStudent" value=""
                 placeholder="Total Student" disabled/>
        </div>
        <div class="FieldGroup">

          <label for="ReportDate">
            <span class="myfont">Report Date</span>
          </label>
          <input type="text" id="ReportDate" name="ReportDate"
                 placeholder="Date" style="width: 100px"  />
          <label for="Meal" class="myfont">Total Meal</label>
          <input type="text" name="Meal" id="Meal" value=""
                 placeholder="Total Meal"required/>
          <input type="button" id="Pre" name="Pre" value="Previous">
          <input type="button" id="Next" name="Next" value="Next">
        </div>
        <div style="clear: both;"></div>
        <hr/>
        <div class="formControl">
          <input type="button" name="Refresh" value="Refresh" id="Refresh">
          <input type="hidden" name="CmdSubmit" id="Txtaction"/>
          <input type="hidden" name="FormToken" id="FormToken"
                 value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
          <input type="hidden" id="AjaxToken"
                 value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
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

