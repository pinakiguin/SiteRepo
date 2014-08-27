<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Monthly Performance Report');
WebLib::IncludeCSS();
WebLib::CreateDB();

if(isset($_POST['BtnPrg'])==1)
{
    require_once __DIR__ . '/../lib.inc.php';
    $DB = new MySQLiDBHelper();
    $insertdata['WorkID']=$_POST['Work'];
    $insertdata['ExpenditureAmount']=$_POST['txtAmount'];
    $insertdata['Balance']=$_POST['txtBalance'];
    $insertdata['Date']=$_POST['txtDate'];
    $insertdata['Remarks']=$_POST['txtRemark'];
    $SchemeID = $DB->insert(MySQL_Pre . 'MPR_Progress', $insertdata);
}

$DB = new MySQLiDBHelper();
$Work = $DB->get(MySQL_Pre . 'MPR_Works');
$prg=$DB->get(MySQL_Pre . 'MPR_Progress');
$n=count($prg);
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
<h2>Create New Progress</h2>
    <form action="" method="post">
  Work:<select name="Work">
    <option>--Select Work--</option>
    <?php foreach ($Work as $WorkID) {
      echo '<option value="' . $WorkID['WorkID'] . '">' . $WorkID['WorkDescription'] . '</option>';
    } ?>
  </select>
    Expenditure Amount:<input type="text" name="txtAmount">
    Balance:<input type="text" name="txtBalance">
    Date:<input type="date" name="txtDate">
    Remarks:<input type="text" name="txtRemark">
    <input type="Submit" value="Create" name="BtnPrg">
    </form>
    <h2>Progress List</h2>
    <table border="1">
      <tr>
        <th>Description of Work</th>
        <th>Expenditure Amount</th>
        <th>Balance</th>
        <th>date</th>
        <th>Remarks</th>
        <th>Action</th>
      </tr>
      <?php $i = 0;
      while ($i < $n) {
        $workid = $prg[$i]['WorkID'];
        $DB->where('WorkID', $workid);
        $WorkName = $DB->get(MySQL_Pre . 'MPR_Works'); ?>
        <tr>
          <td><?php echo $WorkName[0]['WorkDescription']; ?></td>
          <td><?php echo $prg[$i]['ExpenditureAmount']; ?></td>
          <td><?php echo $prg[$i]['Balance']; ?></td>
          <td><?php echo $prg[$i]['Date']; ?></td>
          <td><?php echo $prg[$i]['Remarks']; ?></td>
          <td><a href="savesessionprg.php?pid=<?php echo $prg[$i]['ProgressID'] ?>">edit</a></td>
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

