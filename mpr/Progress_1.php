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
  $Data = new MySQLiDB();
  $Data1 = new MySQLiDBHelper();
  ?>

  <div class="content">
    <form method="post" name="formname" action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>">
      <div style="height: 200px;overflow-y: scroll;float: left;border:1px solid;">
        <ul>
          <li>
            <label>Name of Project</label>
            <select name="ProjectID" data-placeholder="Select Project">
              <?php
              $Query = 'Select `ProjectID`, `ProjectName` '
                      . ' FROM `' . MySQL_Pre . 'MPR_Projects` '
                      . ' Order By `ProjectID`';
              $Data->show_sel('ProjectID', 'ProjectName', $Query, WebLib::GetVal($_POST, 'ProjectID'));
              ?>
            </select>
          </li>

          <li>
            <label>Report Date</label>

            <input type="text" id="ReportDate"
                   class="ReportDate" placeholder="yyyy-mm-dd" />
          </li>
          <li>
            <label>Physical Progress</label>
            <input type="text" name ="PhysicalProgress" id="PhysicalProgress" />
          </li>
          <li>
            <label>Financial Progress</label>
            <input type="text" name ="FinancialProgress" id="FinancialProgress" />
          </li>
          <li>
            <label>Remarks</label>
            <input type="text" name ="Remarks" id="Remarks" />
          </li>


        </ul>


        <?php
        if (WebLib::GetVal($_POST, 'PhysicalProgress') == "") {

          print "Blank text box detected";
        } else {

          $DataACL['UserMapID'] = $_SESSION['UserMapID'];
          $DataACL['ProjectID'] = WebLib::GetVal($_POST, 'ProjectID');
          $DataACL['ReportDate'] = WebLib::GetVal($_POST, 'ReportDate');
          $DataACL['PhysicalProgress'] = WebLib::GetVal($_POST, 'PhysicalProgress');
          $DataACL['FinancialProgress'] = WebLib::GetVal($_POST, 'FinancialProgress');
          $DataACL['Remarks'] = WebLib::GetVal($_POST, 'Remarks');

          $Data1->insert(MySQL_Pre . 'MPR_Progress', $DataACL);
          echo'Add Successfully';
          $_SESSION['Msg'] = 'Add Successfully!';
        }
        ?>
        <input type="submit" id="Cmdsub" name="Cmdsub">
      </div>


    </form>

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