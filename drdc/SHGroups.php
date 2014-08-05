<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('SHG MIS');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeJS('drdc/js/SHGroups.js');
WebLib::IncludeJS('drdc/js/neumeric.js');
WebLib::IncludeCSS('drdc/css/forms.css');
WebLib::CreateDB();
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
  WebLib::ShowMenuBar('DRDC');
  ?>
  <div class="content">
    <div class="formWrapper">
      <form method="post" action="<?php
      echo WebLib::GetVal($_SERVER, 'PHP_SELF');
      ?>" id="frmDepartment" >
        <span class="Message" id="Msg" style="float: right;">
          <b>Loading Please Wait...</b>
        </span>
        <h3>Self-Help Groups</h3>
        <div class="FieldGroup">
          <label for="DeptName"><span>Name of SHG</span>
            <input type="text" name ="DeptName" id="DeptName"
                   placeholder="SHG Name or Code" required/>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="DeptName"><span>Name of Department</span>
            <input type="text" name ="DeptName" id="DeptName"
                   placeholder="Name of Department" required/>
          </label>
        </div>
        <div style="clear: both;"></div>
        <h3>Members</h3>
        <div class="FieldGroup">
          <label for="DeptName"><span>Name of SHG</span>
            <input type="text" name ="DeptName" id="DeptName"
                   placeholder="SHG Name or Code" required/>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="DeptName"><span>Name of Department</span>
            <input type="text" name ="DeptName" id="DeptName"
                   placeholder="Name of Department" required/>
          </label>
        </div>
        <div style="clear: both;"></div>
        <h3>Group Status</h3>
        <div class="FieldGroup">
          <label for="DeptName"><span>Name of SHG</span>
            <input type="text" name ="DeptName" id="DeptName"
                   placeholder="SHG Name or Code" required/>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="DeptName"><span>Name of Department</span>
            <input type="text" name ="DeptName" id="DeptName"
                   placeholder="Name of Department" required/>
          </label>
        </div>
        <div style="clear: both;"></div>
        <h3>Bank Accounts</h3>
        <div class="FieldGroup">
          <label for="DeptName"><span>Name of SHG</span>
            <input type="text" name ="DeptName" id="DeptName"
                   placeholder="SHG Name or Code" required/>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="DeptName"><span>Name of Department</span>
            <input type="text" name ="DeptName" id="DeptName"
                   placeholder="Name of Department" required/>
          </label>
        </div>
        <div style="clear: both;"></div>
        <hr/>
        <div class="formControl">
          <input type="submit" name="CmdSubmit" value="Search" id="CmdSearch">
          <input type="hidden" id="TxtAction" name="CmdSubmit" value="" />
          <input type="reset" name="CmdReset" value="Reset">
        </div>
        <input type="hidden" name="FormToken" id="FormToken"
               value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
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

