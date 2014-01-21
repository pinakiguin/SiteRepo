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
  <div class="Header"></div>
  <?php
  WebLib::ShowMenuBar('MPR');
  ?>
  <div class="content">
    <div class="formWrapper">
      <form method="post"
            action="<?php
            echo WebLib::GetVal($_SERVER, 'PHP_SELF');
            ?>">
        <h3>Process </h3>
        <?php
        include __DIR__ . '/DataMPR.php';
        WebLib::ShowMsg();
        $Data  = new MySQLiDB();
        $Data1 = new MySQLiDBHelper();
        ?>
        <div class="FieldGroup">
          <label for="ProjectName">
            <strong>Project Name</strong>
            <select name="ProjectID" data-placeholder="Select Project">
              <?php
              $Query = 'Select `ProjectID`, `ProjectName` '
                  . ' FROM `' . MySQL_Pre . 'MPR_Projects` '
                  . ' Order By `ProjectID`';
              $Data->show_sel('ProjectID', 'ProjectName', $Query,
                              WebLib::GetVal($_POST, 'ProjectID'));
              ?>
            </select>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="ReportDate">
            <strong>Report Date</strong>
            <input type="text" id="ReportDate" name="ReportDate"
                   class="DatePicker" placeholder="YYYY-MM-DD" />
          </label>
        </div>
        <div class="FieldGroup">
          <label for="PhysicalProgress">
            <strong>Physical Progress in %</strong>
            <input type="text" name="PhysicalProgress" id="PhysicalProgress"
                   placeholder="Physical Progress"/>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="FinancialProgress">
            <strong>Financial Progress in %</strong>
            <input type="text" name="FinancialProgress" id="FinancialProgress"
                   placeholder="Financial Progress"/>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="Remarks">
            <strong>Remarks</strong>
            <input type="text" name="Remarks" id="Remarks"
                   placeholder="Remarks"/>
          </label>
        </div>
        <div class="formControl">
          <input type="hidden" name="FormToken"
                 value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
          <input type="submit" name="CmdSubmit" value="Create Progress">
        </div>
      </form>
    </div>
    <?php
    unset($Data);
    unset($Data1);
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