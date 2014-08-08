<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('SHG MIS');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
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
    ?>" id="frmDepartment">
        <span class="Message" id="Msg" style="float: right;">
          <b>Loading Please Wait...</b>
        </span>

      <h3>Self-Help Groups</h3>

      <div class="FieldGroup">
        <label for="SHGID">
          <span class="FieldLabel">Self-Help Group</span>
          <input type="text" name="SHGID" id="SHGID"
                 placeholder="SHG Name or Code" required/>
        </label>
      </div>
      <div class="FieldGroup">
        <label for="SHGType">
          <span class="FieldLabel">SHG Type</span>
          <input type="text" name="SHGType" id="SHGType"
                 placeholder="SHG Type" required/>
        </label>
      </div>
      <div class="FieldGroup">
        <label for="FormedOn">
          <span class="FieldLabel">Formation Date</span>
          <input type="text" name="FormedOn" id="FormedOn" class="DateField"
                 placeholder="yyyy-mm-dd" required/>
        </label>
      </div>
      <div class="FieldGroup">
        <label for="Scheme">
          <span class="FieldLabel">Scheme</span>
          <select id="Scheme" name="Scheme" class="chosen-select">
            <option value="1">NRLM</option>
            <option value="2">NABARD</option>
            <option value="3">CO-OP</option>
            <option value="4">Bank</option>
            <option value="5">GP</option>
          </select>
        </label>
      </div>
      <div class="FieldGroup">
        <label for="GP">
          <span class="FieldLabel">Gram Panchayat</span>
          <select id="GP" name="GP" class="chosen-select">
          </select>
        </label>
      </div>
      <div class="FieldGroup">
        <label for="Sansad">
          <span class="FieldLabel">Sansad</span>
          <select id="Sansad" name="Sansad" class="chosen-select">
          </select>
        </label>
      </div>
      <div class="FieldGroup">
        <label for="OldSHGID">
          <span class="FieldLabel">Old SHG Code</span>
          <input type="text" name="OldSHGID" id="OldSHGID"
                 placeholder="Old SHG Code" required/>
        </label>
      </div>

      <div style="clear: both;"></div>
      <h3>Members</h3>

      <div class="FieldGroup">
        <label for="MemberName">
          <span class="FieldLabel">Name of the Member</span>
          <input type="text" name="MemberName" id="MemberName"
                 placeholder="Member Name" required/>
        </label>
      </div>
      <div class="FieldGroup">
        <label for="FHName">
          <span class="FieldLabel">Name of Father/Husband</span>
          <input type="text" name="FHName" id="FHName"
                 placeholder="Father/Husband Name" required/>
        </label>
      </div>
      <div class="FieldGroup">
        <label for="Gender">
          <span class="FieldLabel">Gender</span>
          <select id="Gender" name="Gender" class="chosen-select">
            <option value="1">Male</option>
            <option value="2">Female</option>
          </select>
        </label>
      </div>
      <div class="FieldGroup">
        <label for="Category">
          <span class="FieldLabel">Category</span>
          <select id="Category" name="Category" class="chosen-select">
            <option value="1">General</option>
            <option value="2">SC</option>
            <option value="3">ST</option>
            <option value="4">OBC</option>
          </select>
        </label>
      </div>
      <div class="FieldGroup">
        <label for="PWD">
          <span class="FieldLabel">Person with disability</span>
          <select id="PWD" name="PWD" class="chosen-select">
            <option value="1">Yes</option>
            <option value="0">No</option>
          </select>
        </label>
      </div>
      <div class="FieldGroup">
        <label for="BPL">
          <span class="FieldLabel">BPL</span>
          <select id="BPL" name="BPL" class="chosen-select">
            <option value="1">Yes</option>
            <option value="0">No</option>
          </select>
        </label>
      </div>
      <div class="FieldGroup">
        <label for="EPICNo">
          <span class="FieldLabel">EPIC No.</span>
          <input type="text" name="EPICNo" id="EPICNo"
                 placeholder="Voter Card No" required/>
        </label>
      </div>
      <div class="FieldGroup">
        <label for="Activity">
          <span class="FieldLabel">Activity</span>
          <select id="Activity" name="Activity" class="chosen-select">
            <option value="1">COW</option>
            <option value="2">GOAT</option>
            <option value="3">CULTIVATION</option>
            <option value="4">FISHERY</option>
          </select>
        </label>
      </div>
      <div class="FieldGroup">
        <label for="MonthlyIncome">
          <span class="FieldLabel">Monthly Income</span>
          <input type="text" name="MonthlyIncome" id="MonthlyIncome"
                 placeholder="Monthly Income" required/>
        </label>
      </div>
      <div class="FieldGroup">
        <label for="MIAsOn">
          <span class="FieldLabel">As On Date</span>
          <input type="text" name="MIAsOn" id="MIAsOn" class="DateField"
                 placeholder="yyyy-mm-dd" required/>
        </label>
      </div>

      <div style="clear: both;"></div>
      <h3>Group Status</h3>

      <div class="FieldGroup">
        <label for="MIAsOn">
          <span class="FieldLabel">As On Date</span>
          <input type="text" name="MIAsOn" id="MIAsOn" class="DateField"
                 placeholder="yyyy-mm-dd" required/>
        </label>
      </div>
      <div class="FieldGroup">
        <label for="DeptName"><span>Name of Department</span>
          <input type="text" name="DeptName" id="DeptName"
                 placeholder="Name of Department" required/>
        </label>
      </div>
      <div style="clear: both;"></div>
      <h3>Bank Accounts</h3>

      <div class="FieldGroup">
        <label for="DeptName"><span>Name of SHG</span>
          <input type="text" name="DeptName" id="DeptName"
                 placeholder="SHG Name or Code" required/>
        </label>
      </div>
      <div class="FieldGroup">
        <label for="DeptName"><span>Name of Department</span>
          <input type="text" name="DeptName" id="DeptName"
                 placeholder="Name of Department" required/>
        </label>
      </div>
      <div style="clear: both;"></div>
      <hr/>
      <div class="formControl">
        <input type="submit" name="CmdSubmit" value="Search" id="CmdSearch">
        <input type="hidden" id="TxtAction" name="CmdSubmit" value=""/>
        <input type="reset" name="CmdReset" value="Reset">
      </div>
      <input type="hidden" name="FormToken" id="FormToken"
             value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>"/>
      <input type="hidden" id="AjaxToken"
             value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>"/>
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

