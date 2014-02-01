<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('SMS Template');
WebLib::IncludeCSS();
WebLib::IncludeCSS('css/forms.css');
WebLib::JQueryInclude();
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
    <div class="formWrapper">
      <form method="post" enctype="multipart/form-data"
            action="<?php
            echo WebLib::GetVal($_SERVER, 'PHP_SELF');
            ?>">
        <h3 class="formWrapper-h3">SMS Templates</h3>
        <fieldset class="formWrapper-fieldset">
          <legend class="formWrapper-legend">SMS Message Template</legend>
          <input type="text" class="form-TxtInput" style="width: 500px;"
                 id="GroupName" name="GroupName"
                 placeholder="Type The Name of The Template"/>
          <textarea id="MsgText" class="form-TxtInput" style="width: 500px;"
                    rows="10" cols="120" name="MsgText"></textarea>
          <div id="PreviewDIV" style="margin: 5px;display: none;">
            <h4>SMS Preview</h4>
            <span id="PreviewSMS"></span>
          </div>
          <div class="formControl">
            <input type="button" id="ShowPreview" name="CmdAction" value="Show Preview"/>
          </div>
        </fieldset>
        <fieldset class="formWrapper-fieldset">
          <legend class="formWrapper-legend">Upload Contacts</legend>
          <?php
          if (WebLib::GetVal($_POST, 'CmdUpload') === 'Upload') {
            include __DIR__ . '/../PHPExcel/Classes/PHPExcel.php';
            $inputFileName         = $_FILES['ExcelFile']['tmp_name'];
            $objPHPExcel           = PHPExcel_IOFactory::load($inputFileName);
            $sheetData             = $objPHPExcel->getActiveSheet()->toArray(null,
                                                                             true,
                                                                             true,
                                                                             true);
            $_SESSION['ExcelData'] = $sheetData;
            echo '<!--hr/><table border="1">';
            foreach ($sheetData as $RowIndex => $RowData) {
              echo '<tr>';
              if ($RowIndex === 1) {
                echo '<td></td>';
                foreach ($RowData as $ColIndex => $Cell) {
                  echo '<td>' . $ColIndex . '</td>';
                }
                echo '</tr><tr>';
              }
              foreach ($RowData as $ColIndex => $Cell) {
                if ($ColIndex === 'A') {
                  echo '<td>' . $RowIndex . '</td>';
                }
                echo '<td>' . $Cell . '</td>';
              }
              echo '</tr>';
            }
            echo '</table-->';
          }
          $ExcelJSON = json_encode(WebLib::GetVal($_SESSION, 'ExcelData', false,
                                                  false), JSON_PRETTY_PRINT);
          if ($ExcelJSON !== 'null') {
            echo "<br/>JSON Length:" . strlen($ExcelJSON) . '<br/>';
            echo '<pre>' . $ExcelJSON . '</pre>';
          }
          ?>
          <input name="ExcelFile" type="file"/><br/>
          <label for="RowHeader">
            <input type="checkbox" name="RowHeader" value="1"/>
            <strong>The first line of the file contains the column names</strong>
          </label>
          <hr/>
          <div class="formControl">
            <input type="submit" name="CmdUpload" value="Upload"/>
          </div>
        </fieldset>
        <div class="formWrapper-Clear"></div>
        <hr/>
        <div class="formControl">
          <input type="submit" name="CmdAction" value="Create Template"/>
        </div>
      </form>
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

