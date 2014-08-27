<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Monthly Performance Report');
WebLib::IncludeCSS();
//WebLib::CreateDB();

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
  <h2>Create New Scheme</h2>
  <form action="" method="POST">
    Scheme Name:<input type="text" name="txtSchemeName">
    <input type="Submit" value="Create New Scheme" name="BtnCreScheme">
  </form>
  <h2>Create New Scheme</h2>

  <form action="" method="POST">
    Scheme Name:<select name="Scheme">
      <option>--Select Scheme--</option>
      <?php foreach ($Schemes as $SchemeID) {
        echo '<option value="' . $SchemeID['SchemeID'] . '">' . $SchemeID['SchemeName'] . '</option>';
      } ?>
    </select>
    Allotment Amount:<input type="text" name="txtAmount">
    Order No.:<input type="text" name="txtOrderNo">
    Date:<input type="date" name="txtDate">
    Year:<input type="text" name="txtYear">
    <input type="Submit" value="Save Allotment" name="BtnScheme">
  </form>
</div>
<div class="pageinfo">
  <?php WebLib::PageInfo(); ?>
</div>
<div class="footer">
  <?php WebLib::FooterInfo(); ?>
</div>
</body>
</html>