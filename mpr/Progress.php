<?php
//ini_set('display_errors', '1');
//error_reporting(E_ALL);

require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Progress');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('mpr/js/forms.js');
WebLib::IncludeCSS('mpr/css/forms.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
?>
</head>
<body>
  <div class="TopPanel">
    <div class="LeftPanelSide"></div>
    <div class="RightPanelSide"></div>
    <h1><?php echo AppTitle; ?></h1>
  </div>
  <div class="Header">

  </div>
  <?php
  WebLib::ShowMenuBar('MPR');
  ?>

  <div class="content">
    <div class="formWrapper">
      <form method="post" action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>">
        <h3>Process </h3>
        <?php
        include __DIR__ . '/DataMPR.php';
        $Data = new MySQLiDB();
        $Data1 = new MySQLiDBHelper();
        ?>
        <div class="FieldGroup">
          <label for="ProjectName"><strong>Project Name</strong></label><br/>
          <select name="ProjectID" data-placeholder="Select Project">
            <?php
            $Query = 'Select `ProjectID`, `ProjectName` '
                    . ' FROM `' . MySQL_Pre . 'MPR_Projects` '
                    . ' Order By `ProjectID`';
            $Data->show_sel('ProjectID', 'ProjectName', $Query, WebLib::GetVal($_POST, 'ProjectID'));
            ?>
          </select>
        </div>


        <div class="FieldGroup">
          <label for="ReportDate"><strong>Report Date</strong></label>

          <input type="text" id="ReportDate"
                 class="DatePicker" placeholder="YYYY-MM-DD" />
        </div>

        <div class="FieldGroup">
          <label for="PhysicalProgress"><strong>Physical Progress</strong></label>
          <input type="text" name="PhysicalProgress" id="PhysicalProgress" placeholder="Physical Progress"/>
        </div>

        <div class="FieldGroup">
          <label for="FinancialProgress"><strong>Financial Progress</strong></label>
          <input type="text" name="FinancialProgress" id="FinancialProgress" placeholder="Financial Progress"/>
        </div>

        <div class="FieldGroup">
          <label for="Remarks"><strong>Remarks</strong></label>
          <input type="text" name="Remarks" id="Remarks" placeholder="Remarks"/>
        </div>
        <div class="formControl">
          <br/>
          <input type="submit" name="CmdSubmit" value="Create Progress">
        </div>
        <input type="hidden" name="FormToken"
               value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
      </form>
    </div>
    <?php
    unset($Data);
    unset($Data1);
    WebLib::ShowMsg();
    ?>

  </div>


  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>