<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Departments');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeJS('mpr/js/forms.js');
WebLib::IncludeJS('mpr/js/mpr.js');
WebLib::IncludeCSS('mpr/css/forms.css');
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
    <div class="formWrapper">
      <form method="post" action="<?php
      echo WebLib::GetVal($_SERVER, 'PHP_SELF');
      ?>"><?php
              include __DIR__ . '/DataMPR.php';
              WebLib::ShowMsg();
              ?>
        <fieldset>
          <legend><h2>Create New Departments,Sector & Scheme</h2></legend>

          <div class="FieldGroup">
            <label for="DeptName"><h3>Name of Department</h3>
              <input type="text" name ="DeptName" id="DeptName"
                     placeholder="Name of Department"/>
            </label>
            <div class="formControl">
              <input type="submit" name="CmdSubmit" value="Create Department">
              <input type="hidden" name="FormToken"
                     value="<?php echo WebLib::GetVal($_SESSION, 'FormToken')
              ?>
                     " />
            </div>
          </div>
          <div class="FieldGroup">
            <label for="SectorName"><h3>Name of Sector</h3>
              <input type="text" id="SectorName" name="SectorName"
                     placeholder="Name of Sector"/>
            </label>
            <div class="formControl">
              <input type="submit" name="CmdSubmit" value="Create Sector">
              <input type="hidden" name="FormToken"
                     value="<?php
                     echo WebLib::GetVal($_SESSION, 'FormToken')
                     ?>" />
            </div>
          </div>
          <div class="FieldGroup">
            <label for="DeptID"><h3>Select Name of Department</h3>
              <select id="DeptID" name="DeptID"
                      data-placeholder="Select Department"
                      >
              </select></label>
          </div>
          <div class="FieldGroup">
            <label for="SectorID"><h3>Select Name of Sectors</h3>
              <select id="SectorID" name="SectorID"
                      data-placeholder="Select Sector"
                      >
              </select></label>
          </div>
          <div>
            <div class="FieldGroup">
              <label for="SchemeName"><h3>Name of Schemes</h3>
                <input type="text" name="SchemeName" id="SchemeName"
                       placeholder="Name of Schemes"/>
              </label>
              <div class="formControl">
                <input type="submit" name="CmdSubmit" value="Create Scheme">
                <input type="reset" name="CmdReset" value="Reset">
              </div>
            </div>
            <input type="hidden" name="FormToken"
                   value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
          </div>
        </fieldset>
        <fieldset>
          <legend><h2>Create New Project </h2>
          </legend>
          <?php
          $Data  = new MySQLiDB();
          $Data1 = new MySQLiDBHelper();
          ?> <div class="FieldGroup">
            <label for="SchemeName"><h3>Select Scheme</h3>
              <select id="SchemeID" name="SchemeID"
                      data-placeholder="Select Scheme">
                        <?php
                        $Query = 'Select `SchemeID`, `SchemeName` '
                            . ' FROM `' . MySQL_Pre . 'MPR_Schemes` '
                            . ' Order By `SchemeID`';
                        $Data->show_sel('SchemeID', 'SchemeName', $Query,
                                        WebLib::GetVal($_POST, 'SchemeID'));
                        ?>
              </select>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="ProjectName"><h3>Name of Project</h3>
              <input type="text" name="ProjectName" id="ProjectName"
                     placeholder="Name of Projects"/>
            </label>
          </div>

          <div class="FieldGroup">
            <label for="ProjectCost"><h3>Project Cost</h3>
              <input type="text" name="ProjectCost" id="ProjectCost"
                     placeholder="Project Cost"/>
            </label>
          </div>

          <div class="FieldGroup">
            <label for="AlotmentAmount"><h3>Project Allotment Amount
              </h3>
              <input type="text" name="AlotmentAmount" id="AlotmentAmount"
                     placeholder="Project Allotment Amount"/>
            </label>
          </div>

          <div class="FieldGroup">
            <label for="StartDate"><h3>Project Start Date</h3>
              <input type="text" id="StartDate" name="StartDate"
                     placeholder="YYYY-MM-DD" size="12" />
            </label>
          </div>
          <div class="FieldGroup">
            <label for="AlotmentDate"><h3>Project Allotment Date</h3>
              <input type="text" id="AlotmentDate" name="AlotmentDate"
                     placeholder="YYYY-MM-DD" size="12"  />
            </label>
          </div>
          <div class="FieldGroup">
            <label for="TenderDate"><h3>Project Tender Date</h3>
              <input type="text" id="TenderDate" name="TenderDate"
                     placeholder="YYYY-MM-DD" size="12" />
            </label>
          </div>
          <div class="FieldGroup">
            <label for="WorkOrderDate"><h3>Project Work Order Date</h3>
              <input type="text" id="WorkOrderDate" name="WorkOrderDate"
                     placeholder="YYYY-MM-DD"  size="12" />
            </label>
          </div>
          <div style="clear: both;"></div>
          <div class="formControl">
            <input type="submit" name="CmdSubmit" value="Create Project">
            <input type="reset" name="CmdReset" value="Reset">
            <input type="hidden" name="FormToken"
                   value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
          </div>
        </fieldset>
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

