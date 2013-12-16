<?php
require_once __DIR__ . '/../lib.inc.php';

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
  include __DIR__ . '/OfficeData.php';
  WebLib::ShowMenuBar('PP');
  ?>
  <div class="content">
    <h2>Office Information</h2>
    <form class="FieldGroup" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
      <div class="FieldGroup">
        <label for="OfficeCode"><strong>Name of the Office:</strong></label>
        <input id="OfficeCode" name="OfficeCode" type="text" maxlength="50"/>
        <label for="DesgOC">Designation of Officer-in-Charge:</label>
        <input id="DesgOC" name="DesgOC" type="text" maxlength="30"/>
      </div>
      <div style="clear: both;"></div>
      <div class="FieldGroup">
        <fieldset>
          <legend><strong>Office Address</strong></legend>
          <label for="AddrPTS">Para/Tola/Street:</label>
          <input id="AddrPTS" name="AddrPTS" type="text" maxlength="50"/><br/>
          <label for="AddrVTM">Village/Town/Metro:</label>
          <input id="AddrVTM" name="AddrVTM" type="text" maxlength="50"/><br/>
          <label for="PostOffice">Post Office:</label>
          <input id="PostOffice" name="PostOffice" type="text" maxlength="20"/><br/>
          <label for="PSCode">Police Station:</label>
          <input id="PSCode" name="PSCode" type="text" maxlength="50"/><br/>
          <label for="PinCode">Pin Code:</label>
          <input id="PinCode" name="PinCode" type="text" maxlength="6"/><br/>
        </fieldset>
      </div>
      <div class="FieldGroup">
        <fieldset>
          <legend>Category</legend>
          <label for="Status">Status:</label>
          <input id="Status" name="Status" type="text" maxlength="50"/><br/>
          <label for="InstType">Nature of Office:</label>
          <input id="InstType" name="InstType" type="text" maxlength="50"/><br/>
        </fieldset>
        <fieldset>
          <legend>Contact Number</legend>
          <div class="FieldGroup">
            <label for="Phone">Phone:</label>
            <input id="Phone" name="Phone" type="text" maxlength="11"/>
          </div>
          <div class="FieldGroup">
            <label for="Fax">Fax:</label>
            <input id="Fax" name="Fax" type="text" maxlength="11"/>
          </div>
          <div style="clear: both;"></div>
          <div class="FieldGroup">
            <label for="Mobile">Mobile:</label>
            <input id="Mobile" name="Mobile" type="text" maxlength="10"/>
          </div>
          <div class="FieldGroup">
            <label for="EMail Address">E-Mail Address:</label>
            <input id="EMail" name="EMail" type="text" maxlength="25"/>
          </div>
        </fieldset>
      </div>
      <div style="clear: both;"></div>
      <div class="FieldGroup">
        <label for="ACNo">Assembly Constituency:</label>
        <input id="ACNo" name="ACNo" type="text" maxlength="3"/>
      </div>
      <div class="FieldGroup">
        <label for="Staffs">Total no. of Staffs:</label>
        <input id="Staffs" name="Staffs" type="text" maxlength="4"/>
      </div>
      <br/>
      <input id="CmdSaveUpdate" type="submit" name="CmdAction" value="Save" />
      <input id="CmdDel" type="submit" name="CmdAction" value="Delete" />
      <input type="hidden" name="FormToken" value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
    </form>
    <div style="float: left;text-align: left; width: 400px;">
      <p>
      <pre>
        <?php
        print_r($_POST);
        ?>
      </pre>
      <?php
      $Data = new MySQLiDBHelper(HOST_Name, MySQL_User, MySQL_Pass, MySQL_DB);
      $Rows = $Data->get(MySQL_Pre . "PP_InstType");
      echo json_encode($Rows);
      ?>
      </p>
    </div>
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

