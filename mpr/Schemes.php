<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Schemes');
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
      <form method="post" action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>">
        <h3>Schemes</h3>
        <?php
        include __DIR__ . '/DataMPR.php';
        WebLib::ShowMsg();
        $Data = new MySQLiDB();
        $Data1 = new MySQLiDBHelper();
        ?>
        <div class="FieldGroup">
          <label for="DeptID"><strong>Name of Department</strong></label><br/>
          <select id="DeptID" name="DeptID" data-placeholder="Select Department" class="chzn-select">
            <?php
            $Query = 'Select `DeptID`, `DeptName` '
                    . ' FROM `' . MySQL_Pre . 'MPR_Departments` '
                    . ' Order By `DeptID`';
            $Data->show_sel('DeptID', 'DeptName', $Query, WebLib::GetVal($_POST, 'DeptID'));
            ?>
          </select>
        </div>
        <div class="FieldGroup">
          <label for="SectorID"><strong>Name of Sectors</strong></label><br/>
          <select id="SectorID" name="SectorID" data-placeholder="Select Sector" class="chzn-select">
            <?php
            $Query = 'Select `SectorID`, `SectorName` '
                    . ' FROM `' . MySQL_Pre . 'MPR_Sectors` '
                    . ' Order By `SectorID`';
            $Data->show_sel('SectorID', 'SectorName', $Query, WebLib::GetVal($_POST, 'SectorID'));
            ?>
          </select>
        </div>
        <div style="clear: both;"></div>
        <div class="FieldGroup">
          <label for="SchemeName"><strong>Name of Schemes</strong></label>
          <input type="text" name="SchemeName" id="SchemeName" placeholder="Name of Schemes"/>
        </div>
        <div class="formControl">
          <br/>
          <input type="submit" name="CmdSubmit" value="Create Scheme">
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

