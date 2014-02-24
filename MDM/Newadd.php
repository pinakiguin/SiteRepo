<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Mid Day Meal');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeJS('MDM/js/AddNew.js');
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
        <h3>Create New Member</h3>
        <div class="FieldGroup">
          <label for="SubDivID"><span class="myfont">Select Name of Subdivition</span>
            <select id="SubDivID" name="SubDivID"
                    data-placeholder="Select Subdivition"required>
            </select>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="BlockID"><span class="myfont">Select Name of Block</span>
            <select id="BlockID" name="BlockID"
                    data-placeholder="Select Block"required>
            </select></label>
        </div>
        <div class="FieldGroup">
          <label for="Schoolname"><span class="myfont">Name of School</span>
            <input type="text" name ="Schoolname" id="Schoolname"
                   placeholder="Name of School"  size="40"required/>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="RegDate">
            <span class="myfont">Registration Date</span>
            <input type="text" id="RegDate" name="RegDate"
                   size="12" required />
          </label>
        </div>
        <div class="FieldGroup">
          <label for="TypeID"><span class="myfont">Select Type Of School</span>
            <select id="TypeID" name="TypeID"
                    data-placeholder="Select Designation"required>
              <option value=""></option>
              <option value="Upper Primary">Upper Primary</option>
              <option value="Primary">Primary</option>
            </select>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="TotalStudent"><span class="myfont">Total Number Student</span>
            <input type=text name="TotalStudent" id="TotalStudent" value=""
                   placeholder="Total" size="20" maxlength="4" required/>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="NameID"><span class="myfont">Name of Teacher</span>
            <input type="text" name ="NameID" id="NameID"
                   placeholder="NameID" size="25"required/>
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

        <div style="clear: both;"></div>
        <div class="formControl">
          <input type="submit" name="CmdSubmit" value="Add Data" id="CmdSubmit">
          <input type="button" name="Refresh" value="Refresh" id="Refresh">
        </div>
        <input type="hidden" name="FormToken"  id="FormToken" value="<?php
        echo WebLib::GetVal($_SESSION, 'FormToken')
        ?>" />
        <input type="hidden" id="AjaxToken"
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
