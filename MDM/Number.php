<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Mid Day Meal');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeJS('MDM/js/Edit.js');
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
      ?>" id="frmedit" >
        <fieldset>
          <legend> Select The School Data </legend>
          <div class="FieldGroup">
            <label for="SchoolID"><span class="myfont">Type Or Select School Name</span>
              <select id="SchoolID" name="SchoolID"
                      data-placeholder="Type School Name"required>
              </select></label>
          </div>
          <div class="FieldGroup">
            <label for="SubDivID"><span class="myfont">Name Of Subdivision</span>
              <input type="text" name="SubDivID" id="SubDivID" style="width: 300px"
                     readonly="readonly" />
            </label>
          </div>
          <div class="FieldGroup">
            <label for="BlockID"><span class="myfont">Name Of Block</span>
              <input type="text" name="BlockID" id="BlockID"style="width: 300px"
                     readonly="readonly" />
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend>Old Record Of the School Teacher</legend>
          <div class="FieldGroup">
            <label for="RegDate">
              <span class="myfont">Registration Date</span>
              <input type="text" id="RegDate" name="RegDate"
                     placeholder="Date" style="width: 100px" required />
            </label>
          </div>
          <div class="FieldGroup">
            <label for="TotalStudent"><span class="myfont">Number Student</span>
              <input type=text name="TotalStudent" id="TotalStudent" value=""
                     placeholder="Total" style="width: 50px" maxlength="4" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="NameID"><span class="myfont">Name of Teacher</span>
              <input type="text" name ="NameID" id="NameID"
                     placeholder="NameID" style="width: 300px" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="DesigID"><span class="myfont">Select Designation Of teacher</span>
              <select id="DesigID" name="DesigID"
                      data-placeholder="Select Designation"required>
                <option value=""></option>
                <option value="HM">Head Teacher</option>
                <option value="TIC">Teacher In Charge</option>
                <option value="Other">Other</option>
              </select>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="Mobile"><span class="myfont">Mobile Number Of Teacher</span>
              <input type=text name="Mobile" id="Mobile" value=""
                     placeholder="Mobile Number" maxlength="10" required/>
            </label>
          </div>
        </fieldset>
        <div style="clear: both;"></div>
        <div class="formControl">
          <input type="submit" name="CmdSubmit" value="Save Data" id="CmdSubmit">
          <input type="button" name="Refresh" value="Refresh" id="Refresh">
          <input type="hidden" name="FormToken" id="FormToken"
                 value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
          <input type="hidden" id="AjaxToken"
                 value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
        </div>
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
