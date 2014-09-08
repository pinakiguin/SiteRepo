<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Monthly Performance Report');
WebLib::JQueryInclude();
WebLib::IncludeCSS();
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
WebLib::IncludeJS('mpr/js/Progress.js');
WebLib::IncludeCSS('mpr/css/forms.css');

if (isset($_POST['BtnPrg']) == 1) {
  require_once __DIR__ . '/../lib.inc.php';
  $DB = new MySQLiDBHelper();
  $tableData['WorkID'] = WebLib::GetVal($_POST,'Work');
  $tableData['ExpenditureAmount'] = $_POST['txtAmount'];
  $tableData['Progress'] = $_POST['PhyPrgValue'];
  $tableData['Balance'] = $_POST['txtBalance'];
  $tableData['ReportDate'] = WebLib::ToDBDate($_POST['txtDate']);
  $tableData['Remarks'] = $_POST['txtRemark'];
  $SchemeID = $DB->insert(MySQL_Pre . 'MPR_Progress', $tableData);
  unset($tableData);
  $tableData['TenderDate'] = WebLib::ToDBDate($_POST['txtTenderDate']);
  $tableData['WorkOrderDate'] = WebLib::ToDBDate($_POST['txtWorkOrderDate']);
  $DB->where('WorkID',WebLib::GetVal($_POST,'Work'));
  $SchemeID = $DB->update(MySQL_Pre . 'MPR_Works', $tableData);
  unset($tableData);
}
?>
</head>
<body>
<div class="TopPanel">
  <div class="LeftPanelSide"></div>
  <div class="RightPanelSide"></div>
  <h1><?php echo $_SESSION['UserName']; ?></h1>
</div>
<div class="Header"></div>
<?php
WebLib::ShowMenuBar('MPR');
?>
<div class="content" style="display: block;">
  <div class="formWrapper-Autofit">
    <h3 class="formWrapper-h3">Progress Report</h3>

    <form method="post" id="frmProgress">
      <div class="FieldGroup">
        <label for="cmbScheme"><strong>Scheme:</strong></label><br/>
        <select id="cmbScheme" name="Scheme" class="chzn">
          <option></option>
          <?php
          $DB = new MySQLiDBHelper();
          $DB->where('UserMapID', $_SESSION['UserMapID']);
          $Schemes = $DB->get(MySQL_Pre . 'MPR_ViewWorkerSchemes');
          foreach ($Schemes as $Scheme) {
            $Sel = '';
            if ($Scheme['SchemeID'] == WebLib::GetVal($_POST, 'Scheme')) {
              $Sel = 'Selected';
            }
            echo '<option value="' . $Scheme['SchemeID'] . '" ' . $Sel . '>'
              . $Scheme['SchemeName'] . '</option>';
          } ?>
        </select>
      </div>
      <div class="FieldGroup">
        <label for="Work"><strong>Work:</strong></label><br/>
        <select id="Work" name="Work">
          <option></option>
        </select>
      </div>
      <div style="clear: both;"></div>
      <div style="padding: 20px 5px;">
        <label for="PhyPrgSlider" style="padding-bottom: 10px;">
          <strong>Physical Progress:(<span id="PhyPrgLbl"></span>%)</strong>
        </label>

        <div id="PhyPrgSlider"></div>
        <input type="hidden" id="PhyPrgValue" name="PhyPrgValue">
      </div>
      <div style="clear: both;"></div>
      <div class="FieldGroup">
        <label for="txtAmount"><strong>Expenditure Amount:</strong><br/>
          <input id="txtAmount" type="text" name="txtAmount" class="form-TxtInput">
        </label>
      </div>
      <div class="FieldGroup">
        <label for="txtBalance"><strong>Balance:</strong><br/>
          <?php
          $DB = new MySQLiDBHelper();
          $DB->where('UserMapID', $_SESSION['UserMapID']);
          $DB->where('WorkID', WebLib::GetVal($_POST, 'Work'));
          $PrgBalances = $DB->get(MySQL_Pre . 'MPR_ViewUserWorks');
          $Balance = 0;
          if (count($PrgBalances) > 0) {
            $Balance = WebLib::GetVal($PrgBalances[0], 'Balance');
          }
          ?>
          <input id="txtBalance" type="text" name="txtBalance"
                 value="<?php echo $Balance; ?>"
                 class="form-TxtInput">
        </label>
      </div>
      <div class="FieldGroup">
        <label for="txtTenderDate"><strong>Tender Date:</strong><br/>
          <input id="txtTenderDate" type="text" name="txtTenderDate" class="form-TxtInput datePick">
        </label>
      </div>
      <div class="FieldGroup">
        <label for="txtWorkOrderDate"><strong>Work Order Date:</strong><br/>
          <input id="txtWorkOrderDate" type="text" name="txtWorkOrderDate" class="form-TxtInput datePick">
        </label>
      </div>
      <div style="clear: both;"></div>
      <div class="FieldGroup">
        <label for="txtDate"><strong>Report Date:</strong><br/>
          <input id="txtDate" type="text" name="txtDate" class="form-TxtInput datePick">
        </label>
      </div>
      <div class="FieldGroup">
        <label for="txtRemark"><strong>Remarks:</strong><br/>
          <input id="txtRemark" type="text" name="txtRemark" class="form-TxtInput">
        </label>
      </div>
      <div style="clear: both;"></div>
      <hr/>
      <div class="formControl">
        <input type="Submit" value="Save Report" name="BtnPrg">
      </div>
    </form>
  </div>
  <div id="ProgressTable"></div>
  <div class="formWrapper-Clear"></div>
  <div id="DataTable"></div>
  <div class="formWrapper-Clear"></div>
</div>
<div class="pageinfo">
  <?php WebLib::PageInfo(); ?>
</div>
<div class="footer">
  <?php WebLib::FooterInfo(); ?>
</div>
</body>
</html>

