<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Polling Personnel 2014');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('pp/js/forms.js');
WebLib::IncludeCSS('pp/css/forms.css');
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
  WebLib::ShowMenuBar('PP');
  ?>
  <div class="formWrapper" style="font-size: 12px;">
    <form method="post"
          action="<?php
          echo WebLib::GetVal($_SERVER, 'PHP_SELF');
          ?>" >
      <h3>Bank Branch Information</h3>
      <?php
      include __DIR__ . '/BranchData.php';
      WebLib::ShowMsg();
      ?>
      <fieldset>
        <legend>Branch Details</legend>
        <div class="FieldGroup">
          <label for="BankSL">
            <strong>Bank Name</strong>
          </label>
          <select id="BankSL" name="BankSL" class="chzn-select"
                  data-placeholder="Select Bank Name" required />
                  <?php
                  $Data  = new MySQLiDBHelper();
                  $Query = 'SELECT `BankSL`, `BankName` '
                      . ' FROM `' . MySQL_Pre . 'PP_Banks` '
                      . ' Order by `BankName`';
                  $Banks = $Data->query($Query);
                  foreach ($Banks as $Bank) {
                    echo '<option value="' . $Bank['BankSL'] . '">'
                    . $Bank['BankSL'] . '-' . $Bank['BankName']
                    . '</option>';
                  }
                  ?>
          </select>
        </div>
        <div class="FieldGroup">
          <label for="IFSC">
            <strong>IFSC Code</strong>
          </label>
          <input type="text" name="IFSC" id="IFSC" maxlength="11"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'IFSC');
                 ?>" style="padding-right: 9px;width:135px;" required/>
        </div>
        <div style="clear: both;"></div>
        <div class="FieldGroup" style="padding-bottom: 10px;">
          <label for="BranchName">
            <strong>Branch Name</strong>
          </label>
          <input type="text" name="BranchName" id="BranchName" maxlength="30"
                 value="<?php
                 echo WebLib::GetVal($_SESSION['PostData'], 'BranchName');
                 ?>" style="padding-right: 9px;width:400px;" required/>
        </div>
      </fieldset>
      <div style="clear: both;"></div>
      <hr/>
      <div class="formControl">
        <input type="submit" name="CmdSubmit" id="CmdSave" value="Save"/>
        <input type="hidden" name="FormToken"
               value="<?php
               echo WebLib::GetVal($_SESSION, 'FormToken');
               ?>" />
      </div>
    </form>
  </div>
  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>

