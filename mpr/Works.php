<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Monthly Performance Report');
WebLib::IncludeCSS();
//WebLib::CreateDB();

if (isset($_POST['BtnWrk']) == 1) {
  require_once __DIR__ . '/../lib.inc.php';
  $DB = new MySQLiDBHelper();
  $insertdata['SchemeID'] = $_POST['Scheme'];
  $insertdata['UserMapID'] = "2";
  $insertdata['AllotmentAmount'] = $_POST['txtAmount'];
  $insertdata['WorkDescription'] = $_POST['txtWork'];
  $insertdata['EstimatedCost'] = $_POST['txtCost'];
  $SchemeID = $DB->insert(MySQL_Pre . 'MPR_Works', $insertdata);
}

$DB = new MySQLiDBHelper();
$Schemes = $DB->get(MySQL_Pre . 'MPR_Schemes');
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
  <h2>Create New Work</h2>

  <form action="" method="post">
    Scheme Name:<select name="Scheme">
      <option>--Select Scheme--</option>
      <?php foreach ($Schemes as $SchemeID) {
        echo '<option value="' . $SchemeID['SchemeID'] . '">' . $SchemeID['SchemeName'] . '</option>';
      } ?>
    </select>
    Description of Work:<input type="text" name="txtWork">
    Estimated Cost:<input type="text" name="txtCost">
    Allotment Amount:<input type="text" name="txtAmount">
    <input type="Submit" value="Create" name="BtnWrk">
  </form>
  <h2>Works List</h2>
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
  </table>
</div>
<div class="pageinfo">
  <?php WebLib::PageInfo(); ?>
</div>
<div class="footer">
  <?php WebLib::FooterInfo(); ?>
</div>
</body>
</html>

