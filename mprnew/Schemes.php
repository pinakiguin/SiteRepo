<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Monthly Performance Report');
WebLib::IncludeCSS();
//WebLib::CreateDB();
WebLib::IncludeCSS('css/forms.css');
WebLib::IncludeCSS('css/Style.css');
if (isset($_POST['BtnCreScheme']) == 1) {
  require_once __DIR__ . '/../lib.inc.php';
  $DB = new MySQLiDBHelper();
  $insertdata['SchemeName'] = $_POST['txtSchemeName'];
  $SchemeID = $DB->insert(MySQL_Pre . 'MPR_Schemes', $insertdata);
}
if (isset($_POST['BtnScheme']) == 1) {
  require_once __DIR__ . '/../lib.inc.php';
  $DB = new MySQLiDBHelper();
  $insertdata['SchemeID'] = $_POST['Scheme'];
  $insertdata['Amount'] = $_POST['txtAmount'];
  $insertdata['OrderNo'] = $_POST['txtOrderNo'];
  $insertdata['Date'] = $_POST['txtDate'];
  $insertdata['Year'] = $_POST['txtYear'];
  $SchemeID = $DB->insert(MySQL_Pre . 'MPR_SchemesAllotment', $insertdata);
}

$DB = new MySQLiDBHelper();
$Schemes = $DB->get(MySQL_Pre . 'MPR_Schemes');
$balance=$DB->get('Scheme_Progress');
$n=count($balance);
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
  <fieldset>
    <legend>
      <h2>Scheme Allotment</h2></legend>
  <div class="formWrapper-Autofit">
  <fieldset>
    <legend>
  <h3>Create New Scheme</h3></legend>
  <form action="" method="POST">
    <div class="FieldGroup">
      <label for="txtSchemeName"><strong>Scheme Name:</strong><br/>
        <input id="txtSchemeName" type="text" name="txtSchemeName" class="form-TxtInput">
      </label>
    </div>
    <input type="Submit" value="Create New Scheme" name="BtnCreScheme">
  </form></fieldset>
  </div>
  <div class="formWrapper-Autofit">
  <fieldset>
    <legend>
      <h3>Allotment for a Scheme</h3></legend>
    <form action="" method="POST">
    Scheme Name:<select name="Scheme" class="form-TxtInput">
      <option>--Select Scheme--</option>
      <?php foreach ($Schemes as $SchemeID) {
        echo '<option value="' . $SchemeID['SchemeID'] . '">' . $SchemeID['SchemeName'] . '</option>';
      } ?>
    </select>
      <div class="FieldGroup">
        <label for="txtAmount"><strong>Allotment Amount:</strong><br/>
          <input id="txtAmount" type="text" name="txtAmount" class="form-TxtInput">
        </label>
      </div>
      <div class="FieldGroup">
        <label for="txtOrderNo"><strong>Order No.:</strong><br/>
          <input id="txtOrderNo" type="text" name="txtOrderNo" class="form-TxtInput">
        </label>
      </div>
      <div class="FieldGroup">
        <label for="txtDate"><strong>Date:</strong><br/>
          <input id="txtDate" type="text" name="txtDate" class="form-TxtInput">
        </label>
      </div>
      <div class="FieldGroup">
        <label for="txtYear"><strong>Year:</strong><br/>
          <input id="txtYear" type="text" name="txtYear" class="form-TxtInput">
        </label>
      </div>
        <input type="Submit" value="Save Allotment" name="BtnScheme" class="form-TxtInput">
  </form></fieldset>
    </div><br>
  <div class="formWrapper-Autofit">
  <fieldset>
    <legend>
      <h3>Scheme Wise Progress List</h3></legend>
    <table border="1" class="table">
    <tr>
      <th>Scheme Name</th>
      <th>Allotment Amount(Rs.)</th>
      <th>Expenditure Amount(Rs.)</th>
      <th>Balance(Rs.)</th>
   </tr>
    <?php $i = 0;
    while ($i < $n) {
      $schemeid = $balance[$i]['SchemeID'];
      $DB->where('SchemeID', $schemeid);
      $SchemeName = $DB->get(MySQL_Pre . 'MPR_Schemes'); ?>
      <tr>
        <td><?php echo $SchemeName[0]['SchemeName']; ?></td>
        <td><?php echo $balance[$i]['Amount']; ?></td>
        <td><?php echo $balance[$i]['SumOfExpenditureAmount']; ?></td>
        <td><?php $bal=$balance[$i]['Amount']-$balance[$i]['SumOfExpenditureAmount']; echo $bal; ?></td>
     </tr>
      <?php $i++;
    } ?>
  </table>
    </fieldset>
    </div>
    </fieldset>
</div>
<div class="pageinfo">
  <?php WebLib::PageInfo(); ?>
</div>
<div class="footer">
  <?php WebLib::FooterInfo(); ?>
</div>
</body>
</html>