<?php
//ini_set('display_errors', '1');
//error_reporting(E_ALL);

require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Projects');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('mpr/js/forms.js');
WebLib::IncludeCSS('mpr/css/forms.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
if (NeedsDB) {
  WebLib::CreateDB('MPR');
}
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
            <label>Name of Projects</label>
            <input type="text" name ="txtproj" id="txtproj" />
          </li>
          <li>
            <label>Name of Scheme</label>
            <select name="SchemeID" data-placeholder="Select Scheme">
              <?php
              $Query = 'Select `SchemeID`, `SchemeName` '
                      . ' FROM `' . MySQL_Pre . 'MPR_Schemes` '
                      . ' Order By `SchemeID`';
              $Data->show_sel('SchemeID', 'SchemeName', $Query, WebLib::GetVal($_POST, 'SchemeID'));
              ?>
            </select>
          </li>

          <li>
            <label>Project Cost</label>
            <input type="text" name ="projcost" id="projcost" />

          </li>
          <li>
            <label>Project Start Date</label>

            <input type="text" id="StartDate"
                   class="DatePicker" placeholder="yyyy-mm-dd" />
          </li>
          <li>
            <label>Project Allotment Amount</label>
            <input type="text" name ="AlotmentAmount" id="AlotmentAmount" />

          </li>
          <li>
            <label>Project Allotment Date</label>

            <input type="text" id="AlotmentDate"
                   class="AlotmentDate" placeholder="yyyy-mm-dd" />
          </li>
          <li>
            <label>Project Tender Date</label>

            <input type="text" id="TenderDate"
                   class="TenderDate" placeholder="yyyy-mm-dd" />
          </li>
          <li>
            <label>Project Work Order Date</label>

            <input type="text" id="WorkOrderDate"
                   class="WorkOrderDate" placeholder="yyyy-mm-dd" />
          </li>
        </ul>


        <?php
        if (WebLib::GetVal($_POST, 'txtproj') == "") {

          print "Blank text box detected";
        } else {

          $DataACL['UserMapID'] = $_SESSION['UserMapID'];
          $DataACL['ProjectName'] = WebLib::GetVal($_POST, 'txtproj');
          $DataACL['ProjectCost'] = WebLib::GetVal($_POST, 'projcost');
          $DataACL['StartDate'] = WebLib::GetVal($_POST, 'StartDate');
          $DataACL['AlotmentAmount'] = WebLib::GetVal($_POST, 'AlotmentAmount');
          $DataACL['AlotmentDate'] = WebLib::GetVal($_POST, 'AlotmentDate');
          $DataACL['TenderDate'] = WebLib::GetVal($_POST, 'TenderDate');
          $DataACL['WorkOrderDate'] = WebLib::GetVal($_POST, 'WorkOrderDate');


          $DataACL['SchemeID'] = WebLib::GetVal($_POST, 'SchemeID');

          $Data1->insert(MySQL_Pre . 'MPR_Projects', $DataACL);
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
