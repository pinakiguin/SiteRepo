<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Mid Day Meal');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeJS('MDM/js/New.js');
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
      ?>" id="frmNewAdd" >
        <h3>Register School And Teacher Details</h3>
        <fieldset>
          <legend> Register School Details </legend>
          <div class="FieldGroup">
            <label for="SubDivID"><span class="myfont">Select Name of Subdivition</span>
              <select id="SubDivID" name="SubDivID"
                      data-placeholder="Select Subdivition">
              </select>
            </label>
            <label for="BlockID"><span class="myfont">Select Name of Block</span>
              <select id="BlockID" name="BlockID"
                      data-placeholder="Select Block">
              </select></label>
            <label for="Schoolname"><span class="myfont">Name of School</span>
              <input type="text" name ="Schoolname" id="Schoolname"
                     placeholder="Name of School"  size="40"/>
            </label>
            <label for="TypeID"><span class="myfont">Select Type of School</span>
              <select id="TypeID" name="TypeID"
                      data-placeholder="Select Type">
                <option value=""></option>
                <option value="Primary">Primary</option>
                <option value="UppPrimary">Upper Primary</option>
              </select></label>
          </div>
          <div style="clear: both;"></div>
          <div class="formControl">
            <input type="button" name="CmdSubmit" value="Add Data" id="CmdSchool">
            <input type="button" name="Refresh" value="Refresh" id="RefreshSchool">
            <input type="hidden" name="CmdSubmit" id="Txtaction"/>
            <input type="hidden" name="FormToken" id="FormToken"
                   value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
            <input type="hidden" id="AjaxToken"
                   value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
          </div>
        </fieldset>
        <fieldset>
          <legend>Add/Update Teacher Details</legend>

          <label for="SchoolID"><span class="myfont">Type Or Select School Name</span>
            <select id="SchoolID" name="SchoolID"
                    data-placeholder="Type School Name">
            </select>
          </label>
          <div class="FieldGroup">
            <label for="RegDate">
              <span class="myfont">Registration Date</span>
            </label>
            <input type="text" id="RegDate" name="RegDate"
                   placeholder="Date" style="width: 100px"  />
          </div>
          <div class="FieldGroup">
            </label>
            <label for="TotalStudent"><span class="myfont">Number Student</span>
            </label>
            <input type=text name="TotalStudent" id="TotalStudent" value=""
                   placeholder="Total" style="width: 50px" maxlength="4" />

          </div>
          <div style="clear: both;"></div>
          <div class="FieldGroup">
            <label for="NameID"><span class="myfont">Name</span>
              <input type="text" name ="NameID" id="NameID"
                     placeholder="Name" style="width: 300px" />
            </label>

            <label for="DesigID"><span class="myfont">Select Designation </span>
              <select id="DesigID" name="DesigID"
                      data-placeholder="Select Designation">
                <option value=""></option>
                <option value="HM">Head Teacher</option>
                <option value="TIC">Teacher In Charge</option>
                <option value="Other">Other</option>
              </select>
            </label>
            <label for="Mobile"><span class="myfont">Mobile Number</span>
              <input type=text name="Mobile" id="Mobile" value=""
                     placeholder="Mobile Number" maxlength="10" />
            </label>
          </div>
          <div style="clear: both;"></div>
          <div class="formControl">
            <input type="button" name="CmdSubmit" value="Save Data" id="CmdTeacher">
            <input type="button" name="Refresh" value="Refresh" id="RefreshTeacher">
            <input type="hidden" name="CmdSubmit" id="Txtaction"/>
            <input type="hidden" name="FormToken" id="FormToken"
                   value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
            <input type="hidden" id="AjaxToken"
                   value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
          </div>
        </fieldset>
      </form>
      <pre id="Error">
      </pre>
      <div style="clear: both;"></div>
      <hr/>
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
