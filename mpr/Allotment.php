<?php
require_once __DIR__ . '/../lib.inc.php';
WebLib::AuthSession();
WebLib::Html5Header('Monthly Performance Report');
WebLib::IncludeCSS();
//WebLib::CreateDB();


if(isset($_POST['BtnAll'])==1)
{
  require_once __DIR__ . '/../lib.inc.php';
  $DB = new MySQLiDBHelper();
  $insertdata['SchemeID']=$_POST['Scheme'];
  $insertdata['BlockID']=$_POST['Block'];
  $insertdata['AllotmentDate']=$_POST['txtDate'];
  $insertdata['Amount']=$_POST['txtAmount'];
  $insertdata['UserMapID']="2";
  $SchemeID = $DB->insert(MySQL_Pre . 'MPR_Allotment', $insertdata);
}
$DB = new MySQLiDBHelper();
$Schemes = $DB->get(MySQL_Pre . 'MPR_Schemes');
$Block = $DB->get(MySQL_Pre . 'MPR_Blocks');
$All = $DB->get(MySQL_Pre . 'MPR_Allotment');
$n = count($All);
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
  <h2>Create New Allotment</h2>
  <form action="" method="post">
  Scheme Name:<select name="Scheme">
    <option>--Select Scheme--</option>
    <?php foreach ($Schemes as $SchemeID) {
      echo '<option value="' . $SchemeID['SchemeID'] . '">' . $SchemeID['SchemeName'] . '</option>';
    } ?>
  </select>
  Block Name:<select name="Block">
    <option>--Select Block--</option>
    <?php foreach ($Block as $BlockID) {
      echo '<option value="' . $BlockID['BlockID'] . '">' . $BlockID['BlockName'] . '</option>';
    } ?>
  </select>
  Allotment Amount:<input type="text" name="txtAmount">
  Date of Allotment:<input type="date" name="txtDate">
  <input type="Submit" value="Create" name="BtnAll">
  </form>
  <h2>Allotment List</h2>
  <table border="1">
    <tr>
      <th>Scheme Name</th>
      <th>Block Name</th>
      <th>Allotment Amount(Rs.)</th>
      <th>Allotment Date</th>
      <th>Action</th>
    </tr>
    <?php $i = 0;
    while ($i < $n) {
      $schemeid = $All[$i]['SchemeID'];
      $DB->where('SchemeID', $schemeid);
      $SchemeName = $DB->get(MySQL_Pre . 'MPR_Schemes'); ?>
      <tr>
        <td><?php echo $SchemeName[0]['SchemeName'] ?></td>
        <td><?php echo $All[$i]['Amount'] ?></td>
        <td><?php echo $All[$i]['Amount'] ?></td>
        <td><?php echo $All[$i]['Amount'] ?></td>
        <td><a href="savesessionall.php?aid=<?php echo $All[$i]['AllotmentID'] ?>">edit</a></td>
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

