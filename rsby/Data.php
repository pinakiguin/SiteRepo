<?php
require_once('../lib.inc.php');

WebLib::SetPATH(13);
WebLib::Html5Header('RSBY-2013 (Round 4)');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('DataTables/media/css/jquery.dataTables_themeroller.css');
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
    if (WebLib::GetVal($_SESSION, 'Token') === null) {
      $_SESSION['Token'] = md5($_SERVER['REMOTE_ADDR'] . session_id() . $_SESSION['ET']);
    }
    ?>
    <div class="formWrapper">
      <h3>Search Approved Beneficiary Data (Round-4)</h3>
      <form id="frmModify" method="post" action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>"
            style="text-align:left;" autocomplete="off" >
        <div class="FieldGroup">
          <label for="CmbBlockCode"><strong>Block/Municipality:</strong><br/>
            <select id="CmbBlockCode" name="BlockCode">
              <option value=""></option>
            </select>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="CmbPanchayatCode"><strong>Panchayat/Municipality:</strong><br/>
            <select id="CmbPanchayatCode" name="PanchayatCode">
              <option value=""></option>
            </select>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="CmbVillageCode"><strong>Village/Ward:</strong><br/>
            <select id="CmbVillageCode" name="VillageCode">
              <option value=""></option>
            </select>
          </label>
        </div>
        <div class="FieldGroup">
          <br/>
          <input type="submit" id="CmdRefreshRSBY" name="CmdRefresh" value="Refresh"/>
          <input type="hidden" id="AjaxToken"
                 value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
        </div>
        <span class="Message" id="Msg" style="float: right;">
          <b>Loading please wait...</b>
        </span>
      </form>
      <div style="clear: both;"></div>
      <br/>
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
      </table>
    </div>
    <pre id="Error">
    </pre>
  </div>
  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>
