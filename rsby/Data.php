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
WebLib::IncludeJS('rsby/js/Data.js');
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
    <h2>Approved Beneficiary Data</h2>
    <table id="example" class="display stripe row-border hover order-column" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>URN</th>
          <th>EName</th>
          <th>Father_HusbandName</th>
          <th>Door_HouseNo</th>
          <th>VillageCode</th>
          <th>Panchayat_TownCode</th>
          <th>BlockCode</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th>URN</th>
          <th>EName</th>
          <th>Father_HusbandName</th>
          <th>Door_HouseNo</th>
          <th>VillageCode</th>
          <th>Panchayat_TownCode</th>
          <th>BlockCode</th>
        </tr>
      </tfoot>
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
