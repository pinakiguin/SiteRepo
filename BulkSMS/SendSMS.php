<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Send Bulk SMS');
WebLib::IncludeCSS();
WebLib::IncludeCSS('css/forms.css');
WebLib::IncludeCSS('BulkSMS/css/Compose.css');
WebLib::JQueryInclude();
WebLib::IncludeJS('BulkSMS/js/SendSMS.js');
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
  WebLib::ShowMenuBar('SMS');
  ?>
  <div class="content">
    <span class="Message" id="Msg" style="float: right;">
      <b>Loading please wait...</b>
    </span>
    <div class="formWrapper">
      <form method="post" enctype="application/x-www-form-urlencoded"
            action="<?php
            echo WebLib::GetVal($_SERVER, 'PHP_SELF');
            ?>">
        <h3 class="formWrapper-h3">Send Bulk SMS</h3>
        <fieldset class="formWrapper-fieldset">
          <legend class="formWrapper-legend">SMS Message Template</legend>
          <input type="text" class="form-TxtInput" style="width: 500px;"
                 id="GroupName" name="GroupName"
                 value="<?php
                 echo WebLib::GetVal($_SESSION, 'TmplName');
                 ?>" placeholder="Type The Name of The Template"/>
          <pre id="MsgText" class="form-TxtInput" style="width: 500px;"><?php
            echo WebLib::GetVal($_SESSION, 'TxtSMS');
            ?></pre>
          <div id="PreviewDIV" style="margin: 5px;display: none;">
            <h4>SMS Preview</h4>
            <pre id="PreviewSMS"></pre>
          </div>
          <div class="formControl">
            <input type="button" id="ShowPreview" name="CmdAction"
                   value="Show Preview"/>
          </div>
        </fieldset>
        <?php
        $Contacts = WebLib::GetVal($_SESSION, 'ExcelData', false, false);
        if (is_array($Contacts)) {
          ?>
          <fieldset class="formWrapper-fieldset">
            <legend class="formWrapper-legend">Review Contacts</legend>
            <div style="margin:5px;">
              <?php
              foreach ($Contacts as $RowIndex => $Row) {
                if ($RowIndex === 1) {
                  echo '<h4>Columns:</h4>';
                  foreach ($Row as $ColIndex => $Cell) {
                    echo '<input type="button" class="TmplCol" '
                    . ' value="' . $Cell . ':{' . $ColIndex . '}"'
                    . ' data-tmpl="{' . $ColIndex . '}" disabled/>';
                  }
                  echo '<h4>Contacts:</h4>',
                  '<div id="ListData">';
                } else {
                  echo '<input type="checkbox" value="'
                  . $RowIndex . '" checked/>' . ($RowIndex - 1) . ' : ';
                  foreach ($Row as $Col) {
                    echo '[' . $Col . '], ';
                  }
                  echo '<br/>';
                }
              }
              echo '<em>Total Rows:</em> ' . (count($Contacts) - 1),
              '</div>';
              ?>
            </div>
          </fieldset>
          <?php
        }
        ?>

        <div class="formWrapper-Clear"></div>
        <hr/>
        <div class="formControl">
          <input type="submit" name="CmdAction" value="Send SMS"
                 onclick="SendSms($Mobile, $Sms)"/>
        </div>
        <?php

        function SendSms($Mobile,
                         $Sms) {
          echo "$Mobile , $Sms . <br>";
        }
        ?>
      </form>
    </div>
    <pre id="Error"></pre>
  </div>
  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>

