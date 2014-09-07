<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Monthly Performance Report');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('mpr/css/forms.css');
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
WebLib::IncludeJS('mpr/js/Works.js');

if (isset($_POST['BtnWrk']) == 1) {
  $DB = new MySQLiDBHelper();
  $tableData['SchemeID'] = $_POST['Scheme'];
  $tableData['MprMapID'] = $_POST['UserID'];
  $tableData['AsOnDate'] = WebLib::ToDBDate($_POST['txtDate']);
  $tableData['AllotmentAmount'] = $_POST['txtAmount'];
  $tableData['WorkDescription'] = $_POST['txtWork'];
  $tableData['EstimatedCost'] = $_POST['txtCost'];
  $SchemeID = $DB->insert(MySQL_Pre . 'MPR_Works', $tableData);
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
<div class="content">
  <div class="formWrapper-Autofit">
    <h3 class="formWrapper-h3">Sanction of Work for Schemes</h3>

    <form action="" method="post">
      <div class="FieldGroup">
        <label for="Scheme"><strong>Scheme:</strong></label><br/>
        <select id="Scheme" name="Scheme">
          <option></option>
          <?php
          $DB = new MySQLiDBHelper();
          $DB->where('UserMapID', $_SESSION['UserMapID']);
          $Schemes = $DB->get(MySQL_Pre . 'MPR_Schemes');
          foreach ($Schemes as $Scheme) {
            echo '<option value="' . $Scheme['SchemeID'] . '">' . $Scheme['SchemeName'] . '</option>';
          } ?>
        </select>
      </div>
      <div class="FieldGroup">
        <label for="UserID"><strong>Executing Agency:</strong></label><br/>
        <select id="UserID" name="UserID">
          <option></option>
          <?php
          $DB = new MySQLiDBHelper();
          $DB->where('CtrlMapID', $_SESSION['UserMapID']);
          $Users = $DB->get(MySQL_Pre . 'MPR_MappedUsers');
          foreach ($Users as $User) {
            echo '<option value="' . $User['MprMapID'] . '">' . $User['UserName'] . '</option>';
          } ?>
        </select>
      </div>
      <br/>

      <div class="FieldGroup">
        <label for="txtWork"><strong>Description of Work:</strong><br/>
          <input id="txtWork" type="text" name="txtWork" class="form-TxtInput" style="width: 410px;">
        </label>
      </div>
      <br/>

      <div class="FieldGroup">
        <label for="txtCost"><strong>Estimated Cost:</strong><br/>
          <input id="txtCost" type="text" name="txtCost" class="form-TxtInput" style="width: 80px;">
        </label>
      </div>
      <div class="FieldGroup">
        <label for="txtAmount"><strong>Funds Released:</strong><br/>
          <input id="txtAmount" type="text" name="txtAmount" class="form-TxtInput" style="width: 80px;">
        </label>
      </div>
      <div class="FieldGroup">
        <label for="txtDate"><strong>Till Dated:</strong><br/>
          <input id="txtDate" type="text" name="txtDate" class="form-TxtInput datePicker">
        </label>
      </div>
      <div style="clear: both;"></div>
      <hr/>
      <div class="formControl">
        <input type="Submit" value="Create" name="BtnWrk">
      </div>
    </form>
  </div>
  <div class="formWrapper-Clear"></div>
  <div id="DataTable"></div>
</div>
<div class="pageinfo">
  <?php WebLib::PageInfo(); ?>
</div>
<div class="footer">
  <?php WebLib::FooterInfo(); ?>
</div>
</body>
</html>
