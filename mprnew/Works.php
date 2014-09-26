<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Monthly Performance Report');
WebLib::IncludeCSS();
//WebLib::CreateDB();
WebLib::IncludeCSS('css/forms.css');
WebLib::IncludeCSS('css/Style.css');
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');

if (isset($_POST['BtnWrk']) == 1) {
  require_once __DIR__ . '/../lib.inc.php';
  $DB = new MySQLiDBHelper();
  $insertdata['SchemeID'] = $_POST['Scheme'];
  $insertdata['UserMapID'] = $_SESSION['UserMapID'];
  $insertdata['AllotmentAmount'] = $_POST['txtAmount'];
  $insertdata['WorkDescription'] = $_POST['txtWork'];
  $insertdata['EstimatedCost'] = $_POST['txtCost'];
  $SchemeID = $DB->insert(MySQL_Pre . 'MPR_Works', $insertdata);
}

$DB = new MySQLiDBHelper();
$Schemes = $DB->get(MySQL_Pre . 'MPR_Schemes');
$uid=$_SESSION['UserMapID'];
$DB->where('UserMapID',$uid);
$Works = $DB->get(MySQL_Pre . 'MPR_Works');
$n = count($Works);
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
      <h2>Work</h2></legend>
    <div class="formWrapper-Autofit">
  <fieldset>
    <legend>
  <h3>Create New Work</h3></legend>
  <form action="" method="post">
    Scheme Name:<select name="Scheme" class="form-TxtInput">
      <option>--Select Scheme--</option>
      <?php foreach ($Schemes as $SchemeID) {
        echo '<option value="' . $SchemeID['SchemeID'] . '">' . $SchemeID['SchemeName'] . '</option>';
      } ?>
    </select>
    <div class="FieldGroup">
      <label for="txtWork"><strong>Description of Work:</strong><br/>
        <input id="txtWork" type="text" name="txtWork" class="form-TxtInput">
      </label>
    </div>
    <div class="FieldGroup">
      <label for="txtCost"><strong>Estimated Cost:</strong><br/>
        <input id="txtCost" type="text" name="txtCost" class="form-TxtInput">
      </label>
    </div>
    <div class="FieldGroup">
      <label for="txtAmount"><strong>Released Amount:</strong><br/>
        <input id="txtAmount" type="text" name="txtAmount" class="form-TxtInput">
      </label>
    </div>
   <input type="Submit" value="Create" name="BtnWrk">
  </form></fieldset></div>
    <div class="formWrapper-Autofit">
      <fieldset>
        <legend>
          <h3>Work Lists</h3></legend>
   <table border="1">
    <tr>
      <th>Scheme Name</th>
      <th>Description of Work</th>
      <th>Estimated Cost(Rs.)</th>
      <th>Allotment Amount(Rs.)</th>
      <th>Action</th>
    </tr>
    <?php $i = 0;
    while ($i < $n) {
      $schemeid = $Works[$i]['SchemeID'];
      $DB->where('SchemeID', $schemeid);
      $SchemeName = $DB->get(MySQL_Pre . 'MPR_Schemes'); ?>
      <tr>
        <td><?php echo $SchemeName[0]['SchemeName'] ?></td>
        <td><?php echo $Works[$i]['WorkDescription'] ?></td>
        <td><?php echo $Works[$i]['EstimatedCost'] ?></td>
        <td><?php echo $Works[$i]['AllotmentAmount'] ?></td>
        <td><a href="savesessionwork.php?wid=<?php echo $Works[$i]['WorkID'] ?>">edit</a></td>
      </tr>
      <?php $i++;
    } ?>
  </table></fieldset></div>
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

