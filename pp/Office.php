<?php
require_once __DIR__ . '/../lib.inc.php';
require_once __DIR__ . '/pp.lib.php';

WebLib::AuthSession();
WebLib::Html5Header('Format PP1');
WebLib::IncludeCSS();
WebLib::IncludeCSS('pp/css/Office.css');
WebLib::JQueryInclude();
WebLib::IncludeJS('pp/js/Office.js');
if (NeedsDB) {
  WebLib::CreateDB('PP');
}
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
  if (WebLib::GetVal($_POST, 'FormToken') !== null) {
    $_SESSION['PostData'] = WebLib::InpSanitize($_POST);
  } elseif (!isset($_SESSION['PostData'])) {
    $_SESSION['PostData'] = array('CmdAction' => 'Save');
  }
  include __DIR__ . '/OfficeData.php';
  WebLib::ShowMenuBar('PP');
  ?>
  <div class="content">
    <h2>Office Information</h2>
    <?php WebLib::ShowMsg(); ?>
    <form class="FieldGroup" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
      <div class="FieldGroup">
        <label for="OfficeName"><strong>Name of the Office:</strong></label>
        <input id="OfficeName" name="OfficeName" type="text" maxlength="50"
               value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'OfficeName') ?>"/>
        <input id="OfficeSL" name="OfficeSL" type="hidden" maxlength="5"
               value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'OfficeSL') ?>"/>
        <label for="DesgOC">Designation of Officer-in-Charge:</label>
        <input id="DesgOC" name="DesgOC" type="text" maxlength="30"
               value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'DesgOC') ?>"/>
      </div>
      <div style="clear: both;"></div>
      <div class="FieldGroup">
        <fieldset>
          <legend><strong>Office Address</strong></legend>
          <label for="AddrPTS">Para/Tola/Street:</label>
          <input id="AddrPTS" name="AddrPTS" type="text" maxlength="50"
                 value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'AddrPTS') ?>"/><br/>
          <label for="AddrVTM">Village/Town/Metro:</label>
          <input id="AddrVTM" name="AddrVTM" type="text" maxlength="50"
                 value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'AddrVTM') ?>"/><br/>
          <label for="PostOffice">Post Office:</label>
          <input id="PostOffice" name="PostOffice" type="text" maxlength="20"
                 value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'PostOffice') ?>"/><br/>
          <label for="PSCode">Police Station:</label>
          <input id="PSCode" name="PSCode" type="text" maxlength="50"
                 value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'PSCode') ?>"/><br/>
          <label for="PinCode">Pin Code:</label>
          <input id="PinCode" name="PinCode" type="text" maxlength="6"
                 value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'PinCode') ?>"/><br/>
        </fieldset>
      </div>
      <div class="FieldGroup">
        <fieldset>
          <legend>Category</legend>
          <label for="Status">Status:</label>
          <input id="Status" name="Status" type="text" maxlength="50"
                 value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'Status') ?>"/><br/>
          <label for="TypeCode">Nature of Office:</label>
          <input id="TypeCode" name="TypeCode" type="text" maxlength="50"
                 value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'TypeCode') ?>"/><br/>
        </fieldset>
        <fieldset>
          <legend>Contact Number</legend>
          <div class="FieldGroup">
            <label for="Phone">Phone:</label>
            <input id="Phone" name="Phone" type="text" maxlength="11"
                   value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'Phone') ?>"/>
          </div>
          <div class="FieldGroup">
            <label for="Fax">Fax:</label>
            <input id="Fax" name="Fax" type="text" maxlength="11"
                   value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'Fax') ?>"/>
          </div>
          <div style="clear: both;"></div>
          <div class="FieldGroup">
            <label for="Mobile">Mobile:</label>
            <input id="Mobile" name="Mobile" type="text" maxlength="10"
                   value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'Mobile') ?>"/>
          </div>
          <div class="FieldGroup">
            <label for="EMail Address">E-Mail Address:</label>
            <input id="EMail" name="EMail" type="text" maxlength="25"
                   value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'EMail') ?>"/>
          </div>
        </fieldset>
      </div>
      <div style="clear: both;"></div>
      <div class="FieldGroup">
        <label for="ACNo">Assembly Constituency:</label>
        <input id="ACNo" name="ACNo" type="text" maxlength="3"
               value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'ACNo') ?>"/>
      </div>
      <div class="FieldGroup">
        <label for="Staffs">Total no. of Staffs:</label>
        <input id="Staffs" name="Staffs" type="text" maxlength="4"
               value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'Staffs') ?>"/>
      </div>
      <br/>
      <input id="CmdSaveUpdate" type="submit" name="CmdAction"
             value="<?php echo WebLib::GetVal($_SESSION['PostData'], 'CmdAction') ?>" />
      <input id="CmdDel" type="submit" name="CmdAction" value="Delete" />
      <input type="hidden" name="FormToken" value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
      <input type="hidden" id="AjaxToken" value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
    </form>
    <?php if (isset($_GET['Debug'])) { ?>
      <div id="Debug" style="float: left;text-align: left; width: 400px;">
        <p>
        <pre>
          <?php
          print_r($_POST);
          print_r($_SESSION);
          ?>
        </pre>
        <?php
        $Data = new MySQLiDBHelper(HOST_Name, MySQL_User, MySQL_Pass, MySQL_DB);
        $Rows = $Data->rawQuery('Select `ACNo` as `value`,concat(`ACNo`,\'-\',`ACName`) as `label` from `' . MySQL_Pre . "PP_ACs`");
        echo json_encode($Rows);
        ?>
        </p>
      </div>
      <?php
    }
    ?>
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

