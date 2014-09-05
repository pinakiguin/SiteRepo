<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Monthly Performance Report');
WebLib::IncludeCSS();
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
WebLib::IncludeCSS('css/forms.css');
WebLib::IncludeCSS('css/Style.css');
//WebLib::CreateDB();
$DB = new MySQLiDBHelper();
$Schemes = $DB->get(MySQL_Pre . 'MPR_Schemes');
$Block = $DB->get(MySQL_Pre . 'MPR_Blocks');
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
  <div class="content">
    <h3>Work Progress</h3>
    <div class="formWrapper-Autofit">

      <h3  class="formWrapper-h3">Create New Progress</h3>
      <form method="post" id="frmscheme">
        Scheme Name:<select name="SchemeID" class="form-TxtInput" id="cmbScheme">
          <option>--Select Scheme--</option>
          <?php foreach ($Schemes as $SchemeID) {
            $Selected="";
            if($_POST['SchemeID']==$SchemeID['SchemeID']){
              $Selected=" selected ";
            }
            echo '<option value="' . $SchemeID['SchemeID'] . '" '.$Selected.'>'
                . $SchemeID['SchemeName'] . '</option>';
          } ?>
        </select>
        Block Name:<select name="Block" class="form-TxtInput">
          <option>--Select Block--</option>
          <?php foreach ($Block as $BlockID) {
            echo '<option value="' . $BlockID['BlockID'] . '">' . $BlockID['BlockName'] . '</option>';
          } ?>
        </select>
        </form>
      </div>
    <div class="formWrapper">
      <h3 class="formWrapper-h3">Report Details</h3>

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

