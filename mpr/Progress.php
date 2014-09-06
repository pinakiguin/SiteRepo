<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Monthly Performance Report');
WebLib::JQueryInclude();
WebLib::IncludeCSS();
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
WebLib::IncludeCSS('mpr/css/forms.css');

if (isset($_POST['BtnPrg']) == 1) {
  require_once __DIR__ . '/../lib.inc.php';
  $DB = new MySQLiDBHelper();
  $tableData['WorkID'] = $_POST['Work'];
  $tableData['ExpenditureAmount'] = $_POST['txtAmount'];
  $tableData['Progress'] = $_POST['PhyPrgValue'];
  $tableData['Balance'] = $_POST['txtBalance'];
  $tableData['ReportDate'] = WebLib::ToDBDate($_POST['txtDate']);
  $tableData['Remarks'] = $_POST['txtRemark'];
  $SchemeID = $DB->insert(MySQL_Pre . 'MPR_Progress', $tableData);
}
?>
<script type="text/javascript">
  $(function () {
    $('.chzn')
      .chosen({width: "200px",
        no_results_text: "Oops, nothing found!"
      });
    $("#cmbScheme").change(function () {
      $("#frmProgress").submit();
    });

    $(".datePick").datepicker().css({"width": "80px"});

    $("#PhyPrgSlider").slider({
      range: "min",
      value: 37,
      min: 1,
      max: 100,
      slide: function (event, ui) {
        $("#PhyPrgValue").val(ui.value);
        $("#PhyPrgLbl").html(ui.value);
      }
    }).next().find('.ui-slider-handle').hide();
  });
</script>
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
<div class="content">
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
          $Schemes = $DB->get(MySQL_Pre . 'MPR_WorkerSchemes');
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
        <select id="Work" name="Work" class="chzn">
          <option></option>
          <?php
          $DB = new MySQLiDBHelper();
          $DB->where('UserMapID', $_SESSION['UserMapID']);
          $Schemes = $DB->get(MySQL_Pre . 'MPR_UserWorks');
          foreach ($Schemes as $SchemeID) {
            echo '<option value="' . $SchemeID['WorkID'] . '">' . $SchemeID['Work'] . '</option>';
          } ?>
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
          <input id="txtBalance" type="text" name="txtBalance" class="form-TxtInput">
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
  <div class="formWrapper-Autofit">
    <h3 class="formWrapper-h3">Progress Details</h3>
    <table rules="all" frame="box" width="100%" cellpadding="5" cellspacing="2">
      <tr>
        <th>Description of Work</th>
        <th>Expenditure Amount</th>
        <th>Balance</th>
        <th>date</th>
        <th>Remarks</th>
        <th>Action</th>
      </tr>
      <?php
      $DB = new MySQLiDBHelper();
      $DB->where('UserMapID', $_SESSION['UserMapID']);
      $DB->where('SchemeID', WebLib::GetVal($_POST, 'Scheme'));
      $Works = $DB->get(MySQL_Pre . 'MPR_UserWorks');
      foreach ($Works as $Work) {
        $DB->where('WorkID', $Work['WorkID']);
        $Progress = $DB->get(MySQL_Pre . 'MPR_Progress'); ?>
        <tr>
          <td><?php echo $Work['Work']; ?></td>
          <td><?php echo $Progress[0]['ExpenditureAmount']; ?></td>
          <td><?php echo $Progress[0]['Balance']; ?></td>
          <td><?php echo $Progress[0]['ReportDate']; ?></td>
          <td><?php echo $Progress[0]['Remarks']; ?></td>
          <td><a href="savesessionprg.php?pid=<?php echo $Progress[0]['ProgressID'] ?>">Details</a></td>
        </tr>
      <?php
      } ?>
    </table>

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

