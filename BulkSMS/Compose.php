<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('SMS Template');
WebLib::IncludeCSS();
WebLib::IncludeCSS('css/forms.css');
WebLib::IncludeCSS('BulkSMS/css/Compose.css');
WebLib::JQueryInclude();
WebLib::IncludeJS('BulkSMS/js/json-template.js');
WebLib::IncludeJS('BulkSMS/js/Compose.js');
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
      <form method="post" enctype="multipart/form-data"
            action="<?php
            echo WebLib::GetVal($_SERVER, 'PHP_SELF');
            ?>">
        <h3 class="formWrapper-h3">SMS Templates</h3>
        <fieldset class="formWrapper-fieldset">
          <legend class="formWrapper-legend">Upload Contacts</legend>
          <?php
          include 'ParseExcel.php';
          ?>
          <span class="Message">
            <strong>Note:</strong>
            Only 200 rows from the first sheet will be uploaded.
          </span><br/>
          <div style="margin:5px;">
            <div id="ListData">
              <?php
              $Contacts = WebLib::GetVal($_SESSION, 'ExcelData', false, false);
              if (is_array($Contacts)) {
                foreach ($Contacts as $RowIndex => $Row) {
                  if ($RowIndex === 1) {
                    echo '<h4>Columns:</h4>';
                    foreach ($Row as $ColIndex => $Cell) {
                      echo '<input type="button" class="TmplCol" '
                      . ' value="' . $Cell . '"'
                      . ' data-tmpl="{' . $ColIndex . '}" />';
                    }
                  }
                  if ($RowIndex === 2) {
                    echo '<h4>Sample Data:</h4>';
                    foreach ($Row as $Col) {
                      echo '[' . $Col . '], ';
                    }
                  }
                }
                echo '<em>Total Rows:</em> ' . count($Contacts);
              }
              ?>
              <pre id="ShowJSON"></pre>
            </div>
            <label for="ExcelFile">
              <h4>Select Spreadsheet:</h4>
            </label>
            <input id="ExcelFile" name="ExcelFile" type="file"
                   accept="application/vnd.ms-excel" />
          </div>
          <div style="margin:5px;">
            <label for="FileType"><h4>File Type:</h4></label>
            <select id="FileType" name="FileType">
              <option value="OOCalc">Open Document Spreadsheet (*.ods)</option>
              <option value="Excel2007">Microsoft Excel 2007/2010 XML (*.xlsx)</option>
              <option value="Excel5">Microsoft Excel 97/2000/XP/2003 (*.xls)</option>
            </select>
          </div>
          <div style="margin:5px;">
            <input type="checkbox"  style="vertical-align: -20%;"
                   id="RowHeader" name="RowHeader" value="1"/>
            <label for="RowHeader">
              The first line of the file contains the column names.
            </label>
          </div>
          <hr/>
          <div class="formControl">
            <input type="submit" name="CmdUpload" value="Upload"/>
          </div>
        </fieldset>
        <fieldset class="formWrapper-fieldset">
          <legend class="formWrapper-legend">SMS Message Template</legend>
          <input type="text" class="form-TxtInput" style="width: 500px;"
                 id="GroupName" name="GroupName"
                 placeholder="Type The Name of The Template"/>
          <textarea id="MsgText" class="form-TxtInput" style="width: 500px;"
                    rows="10" cols="120" name="MsgText"></textarea>
          <div id="PreviewDIV" style="margin: 5px;display: none;">
            <h4>SMS Preview</h4>
            <pre id="PreviewSMS"></pre>
          </div>
          <div class="formControl">
            <input type="button" id="ShowPreview" name="CmdAction"
                   value="Show Preview"/>
          </div>
        </fieldset>
        <div class="formWrapper-Clear"></div>
        <hr/>
        <div class="formControl">
          <input type="submit" name="CmdAction" value="Create Template"/>
        </div>
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