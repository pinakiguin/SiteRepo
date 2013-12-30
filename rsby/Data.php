<?php
require_once('../lib.inc.php');

WebLib::SetPATH(13);
WebLib::Html5Header('RSBY-2013 (Round 4)');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('DataTables/media/css/jquery.dataTables_themeroller.css');
//WebLib::IncludeCSS('DataTables/media/css/jquery.dataTables.css');
//WebLib::IncludeJS('DataTables/media/js/jquery.js');
WebLib::IncludeJS('DataTables/media/js/jquery.dataTables.js');
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
WebLib::IncludeJS('rsby/js/Data.js');
WebLib::IncludeCSS('rsby/css/Data.css');
WebLib::IncludeCSS('rsby/css/forms.css');
?>
</head>
<body>
  <div class="TopPanel">
    <div class="LeftPanelSide"></div>
    <div class="RightPanelSide"></div>
    <h1><?php echo AppTitle; ?></h1>
  </div>
  <div class="Header"></div>
  <div class="MenuBar">
    <ul>
      <?php
      WebLib::ShowMenuitem('Home', '../');
      WebLib::ShowMenuitem('RSBY Beneficiary Data(Round 4)', 'rsby/Data.php');
      WebLib::ShowMenuitem('Download', 'rsby/DownloadMDB.php');
      WebLib::ShowMenuitem('Helpline', '../ContactUs.php');
      ?>
    </ul>
  </div>
  <div class="content">
    <?php
    $Data = new MySQLiDB();
    if (WebLib::GetVal($_POST, 'CmdRefresh') === 'Refresh') {
      $_SESSION['RSBY_BlockCode'] = WebLib::GetVal($_POST, 'BlockCode', true);
      $_SESSION['RSBY_PanchayatCode'] = WebLib::GetVal($_POST, 'PanchayatCode', true);
      $_SESSION['RSBY_VillageCode'] = WebLib::GetVal($_POST, 'VillageCode', true);
    }
    ?>
    <div class="formWrapper">
      <h3>Search Approved Beneficiary Data (Round-4)</h3>
      <form id = "frmModify" method = "post" action = "<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>"
            style = "text-align:left;" autocomplete = "off" >
        <div class="FieldGroup">
          <label for = "BlockCode"><strong>Block/Municipality:</strong><br/>
            <select name = "BlockCode" class = "chzn-select">
              <?php
              $QryBlocks = 'Select BlockCode,CONCAT(BlockCode,\'-\',BlockName) as BlockName FROM `' . MySQL_Pre . 'RSBY_MstBlock`';
              $Data->show_sel('BlockCode', 'BlockName', $QryBlocks, WebLib::GetVal($_SESSION, 'RSBY_BlockCode'));
              ?>
            </select>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="PanchayatCode"><strong>Panchayat/Municipality:</strong><br/>
            <select name="PanchayatCode" class="chzn-select">
              <?php
              $QryPanchayats = 'Select Panchayat_TownCode,CONCAT(Panchayat_TownCode,\'-\',Panchayat_TownName) as PanchayatName '
                      . ' FROM `' . MySQL_Pre . 'RSBY_MstPanchayatTown`'
                      . ' Where BlockCode=\'' . WebLib::GetVal($_SESSION, 'RSBY_BlockCode', true) . '\'';
              $Data->show_sel('Panchayat_TownCode', 'PanchayatName', $QryPanchayats, WebLib::GetVal($_SESSION, 'RSBY_PanchayatCode'));
              ?>
            </select>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="VillageCode"><strong>Village/Ward:</strong><br/>
            <select name="VillageCode" class="chzn-select">
              <?php
              $QryVillages = 'Select VillageCode,CONCAT(VillageCode,\'-\',VillageName) as VillageName '
                      . ' FROM `' . MySQL_Pre . 'RSBY_MstVillage`'
                      . ' Where Panchayat_TownCode=\'' . WebLib::GetVal($_SESSION, 'RSBY_PanchayatCode', true) . '\'';
              $Data->show_sel('VillageCode', 'VillageName', $QryVillages, WebLib::GetVal($_SESSION, 'RSBY_VillageCode'));
              ?>
            </select>
          </label>
        </div>
        <div class="FieldGroup">
          <br/>
          <input type="submit" name="CmdRefresh" value="Refresh"/>
        </div>
      </form>
      <div style="clear: both;"></div>
      <br/>
      <?php
      if (WebLib::GetVal($_SESSION, 'RSBY_VillageCode') !== null) {
        ?>
        <table id="example" class="display stripe row-border hover order-column" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>URN</th>
              <th>Name of Household</th>
              <th>Name of Father/Husband</th>
              <th>RSBY Type</th>
              <th>Category Code</th>
              <th>BPL Citizen</th>
              <th>Minority</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>URN</th>
              <th>Name of Household</th>
              <th>Name of Father/Husband</th>
              <th>RSBY Type</th>
              <th>Category Code</th>
              <th>BPL Citizen</th>
              <th>Minority</th>
            </tr>
          </tfoot>
        </table>
        <?php
      }
      ?>
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
