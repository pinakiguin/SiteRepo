<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Monthly Performance Report');
WebLib::JQueryInclude();
WebLib::IncludeCSS();
//WebLib::CreateDB();
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
WebLib::IncludeCSS('css/forms.css');
WebLib::IncludeCSS('css/Style.css');

if (isset($_POST['BtnPrg']) == 1) {
  require_once __DIR__ . '/../lib.inc.php';
  $DB = new MySQLiDBHelper();
  $insertdata['WorkID'] = $_POST['Work'];
  $insertdata['ExpenditureAmount'] = $_POST['txtAmount'];
  $insertdata['Balance'] = $_POST['txtBalance'];
  $insertdata['Date'] = $_POST['txtDate'];
  $insertdata['Remarks'] = $_POST['txtRemark'];
  $insertdata['UserMapID'] = $_SESSION['UserMapID'];
  $SchemeID = $DB->insert(MySQL_Pre . 'MPR_Progress', $insertdata);
}

$DB = new MySQLiDBHelper();
$uid = $_SESSION['UserMapID'];
$DB->where('UserMapID', $uid);
$Work = $DB->get(MySQL_Pre . 'MPR_Works');
$DB->where('UserMapID', $uid);
$prg = $DB->get(MySQL_Pre . 'MPR_Progress');
$n = count($prg);
$Schemes = $DB->get(MySQL_Pre . 'MPR_Schemes');

$DB = new MySQLiDBHelper();
$DB->where('UserMapID', $uid);
$DB->where('SchemeID', $_POST['SchemeID']);
$Work = $DB->get(MySQL_Pre . 'MPR_Works');
?>
<script type="text/javascript">
  $(function(){
    $('.chzn-select')
        .chosen({width: "300px",
          no_results_text: "Oops, nothing found!"
        });
    $("#cmbScheme").change(function () {
      $("#frmscheme").submit();
    });
  });
</script>
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

      <h3>Work Progress</h3>
    <div class="formWrapper-Autofit">

          <h3  class="formWrapper-h3">Create New Progress</h3>
        <form method="post" id="frmscheme">
          Scheme Name:<select name="SchemeID" class="chzn-select" id="cmbScheme">
            <option>--Select Scheme--</option>
            <?php foreach ($Schemes as $SchemeID) {
              $Selected="";
              if($_POST['SchemeID']==$SchemeID['SchemeID']){
                $Selected=" selected ";
              }
              echo '<option value="' . $SchemeID['SchemeID'] . '" '.$Selected.'>'
                  . $SchemeID['SchemeName'] . '</option>';
            } ?>
          </select><br/>
          Work:
          <select name="Work" class="chzn-select" id="target">
            <option>--Select Work--</option>
            <?php foreach ($Work as $WorkID) {
              echo '<option value="' . $WorkID['WorkID'] . '">' . $WorkID['WorkDescription'] . '</option>';
            } ?>
          </select><br/>
          <div class="FieldGroup">
            <label for="txtPhyP"><strong>Physical Progress:(%)</strong><br/>
              <input id="txtPhyP" type="text" name="txtPhyP" class="form-TxtInput">
            </label>
          </div>
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
          <div class="FieldGroup">
            <label for="txtDate"><strong>Date:</strong><br/>
              <input id="txtDate" type="text" name="txtDate" class="form-TxtInput">
            </label>
          </div>
          <div class="FieldGroup">
            <label for="txtRemark"><strong>Remarks:</strong><br/>
              <input id="txtRemark" type="text" name="txtRemark" class="form-TxtInput">
            </label>
          </div>
          <div class="formControl">
            <hr/>
            <input type="Submit" value="Create" name="BtnPrg">
          </div>
        </form>
    </div>
    <div class="formWrapper">
          <h3 class="formWrapper-h3">Progress Details</h3>
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

</div>
<div class="pageinfo">
  <?php WebLib::PageInfo(); ?>
</div>
<div class="footer">
  <?php WebLib::FooterInfo(); ?>
</div>
</body>
</html>

