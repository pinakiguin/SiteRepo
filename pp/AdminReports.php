<?php
require_once __DIR__ . '/../lib.inc.php';
require_once __DIR__ . '/pp.lib.php';

WebLib::AuthSession();
WebLib::Html5Header('Format PP1');
WebLib::IncludeCSS();
WebLib::IncludeCSS('pp/css/Office.css');
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('pp/js/forms.js');
WebLib::IncludeCSS('pp/css/forms.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
WebLib::JQueryInclude();
WebLib::IncludeJS('pp/js/Office.js');
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
  LibPP::SetUserEnv();
  include __DIR__ . '/OfficeData.php';
  WebLib::ShowMenuBar('PP');
  ?>
  <div class="content">
    <h2>Check List</h2>
    <?php WebLib::ShowMsg(); ?>
    <form  name="Checklist" class="FieldGroup" method="post" target="_blank"
           action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> ">


      <div class="FieldGroup">
        <input type="button" name="CheckListOffice" id="CheckListOffice"
               value="CheckListOffice"/>
        <input type="hidden" name="FormToken" id="FormToken"
               value="<?php
               echo WebLib::GetVal($_SESSION, 'FormToken');
               ?>" />
        <input type="hidden" id="AjaxToken"
               value="<?php
               echo WebLib::GetVal($_SESSION, 'Token');
               ?>" />

      </div>
      <?php
      $Query                 = 'SELECT `OfficeSL`, `OfficeName` ,`AddrPTS`,`AddrVTM`,'
          . '`PostOffice`,`PSCode`,`SubDivnCode`,`DistCode`,` PinCode`,`Phone`'
          . ',`Fax`,`Mobile`,`EMail`,`StaffsACNo`'
          . ' FROM `' . MySQL_Pre . 'PP_Offices` '
          . ' Where `UserMapID`=?'
          . ' Order by `OfficeSL`';
      $DataResp['CheckData'] = array();
      doQuery($DataResp['CheckData'], $Query);
      ?>
      <div style="clear: both"></div>
      <hr/>
      <div class="FieldGroup">
        <label for="BlockCode">Select The Block Name</label>
        <select name="BlockCode" id="BlockCode">
          <option value=""></option>
        </select>
      </div>
      <div class="FieldGroup">
        <label for="OfficeName">Select the Office Name
          <select name="OfficeName" id="OfficeName">
            <option value=""></option>
          </select>
      </div>
      <div class="FieldGroup">
        <input type="button" name="ChecklistPP" id="CheckListPP"
               value="ChecklistPP2">
        <input type="hidden" name="FormToken" id="FormToken"
               value="<?php
               echo WebLib::GetVal($_SESSION, 'FormToken');
               ?>" />
        <input type="hidden" id="AjaxToken"
               value="<?php
               echo WebLib::GetVal($_SESSION, 'Token');
               ?>" />
      </div>
    </form>
    <span class="Message" id="Msg" style="float: left;">
      <b>Loading please wait...</b>
    </span>
    <pre id="Error"></pre>
    <div style="clear: both;"></div>

  </div>
  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>
