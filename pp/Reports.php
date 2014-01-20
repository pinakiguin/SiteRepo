<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Reports');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
WebLib::IncludeCSS('DataTables/media/css/jquery.dataTables_themeroller.css');
WebLib::IncludeJS('DataTables/media/js/jquery.dataTables.js');
WebLib::IncludeJS('js/forms.js');
WebLib::IncludeCSS('css/forms.css');
WebLib::IncludeJS('pp/js/Reports.js');
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
  <form method="post"
        action="<?php
        echo WebLib::GetVal($_SERVER, 'PHP_SELF');
        ?>" >
    <div class="jQuery-ButtonSet-Wrapper">
      <div class="jQuery-ButtonSet-Centre">
        <div id="CmdReports" class="jQuery-ButtonSet">
          <input type="radio" id="GetDataPPs"
                 name="CmdReport" value="DataPPs"
                 checked="checked"/>
          <label for="DataPPs">Polling Personnel</label>
          <input type="radio" id="GetDataOffices"
                 name="CmdReport" value="DataOffices"/>
          <label for="DataOffices">Offices</label>
          <input type="radio" id="GetDataPayScales"
                 name="CmdReport" value="DataPayScales"/>
          <label for="DataPayScales">Pay Scales</label>
        </div>
      </div>
      <div class="jQuery-ButtonSet-Wrapper-content" style="font-size: 12px;">
        <table id="ReportDT" cellspacing="0" width="100%"
               class="display stripe row-border hover order-column" >
          <thead>
            <tr>
              <th>Name of the Office</th>
              <th>Designation of Officer-in-Charge</th>
              <th>Para/Tola/Street</th>
              <th>Village/Town/Street</th>
              <th>PostOffice</th>
              <th>PSCode</th>
              <th>PinCode</th>
              <th>Nature</th>
              <th>Status</th>
              <th>Phone</th>
              <th>Fax</th>
              <th>Mobile</th>
              <th>EMail</th>
              <th>Staffs</th>
              <th>ACNo</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>SUB-INSPECTOR OF SCHOOL, BINPUR CIRCLE</td>
              <td>SUB-INSPECTOR OF SCHOOL</td>
              <td>SILDA</td>
              <td>SILDA</td>
              <td>SILDA</td>
              <td>21</td>
              <td>721515</td>
              <td>07</td>
              <td>06</td>
              <td>03221253252</td>
              <td>03221253252</td>
              <td>9433488557</td>
              <td>cpcbelpahari@gmail.com</td>
              <td>184</td>
              <td>237</td>
            </tr>
            <tr>
              <td>ICDS PROJECT BINPUR-I</td>
              <td>CDPO</td>
              <td>BINPUR</td>
              <td>BINPUR</td>
              <td>BINPUR</td>
              <td>21</td>
              <td>721514</td>
              <td>01</td>
              <td>02</td>
              <td>03221260206</td>
              <td>03221260206</td>
              <td>8900189704</td>
              <td>cdpobin1@gmail.com</td>
              <td>11</td>
              <td>222</td>
            </tr>
            <tr>
              <td>LALGARH SARADAMONI BALIKA VIDYALAYA</td>
              <td>Teacher in Charge</td>
              <td>LALGARH</td>
              <td>LALGARH</td>
              <td>LALGARH</td>
              <td>22</td>
              <td>721516</td>
              <td>8</td>
              <td>6</td>
              <td>03221263239</td>
              <td></td>
              <td>9474444484</td>
              <td></td>
              <td>21</td>
              <td>222</td>
            </tr>
            <tr>
              <td>BARKALA JUNIOR HIGH SCHOOL</td>
              <td>Teacher in Charge</td>
              <td>BARKALA</td>
              <td>BARKALA</td>
              <td>DHARAMPUR</td>
              <td>LA</td>
              <td>721516</td>
              <td>08</td>
              <td>6</td>
              <td></td>
              <td></td>
              <td>9474374767</td>
              <td></td>
              <td>5</td>
              <td>222</td>
            </tr>
            <tr>
              <td>MURAR ASHUTHOSH HIGH SCHOOL</td>
              <td>HEADMASTER</td>
              <td>MURAR</td>
              <td>MURAR</td>
              <td>RAMGARH</td>
              <td>LA</td>
              <td>721128</td>
              <td>8</td>
              <td>6</td>
              <td></td>
              <td></td>
              <td>9474825513</td>
              <td></td>
              <td>15</td>
              <td>222</td>
            </tr>
            <tr>
              <td>VIDYASAGAR CENTRAL CO-OPERATIVE BANK,LALGARH</td>
              <td>BRANCH MANAGER</td>
              <td>LALGARH</td>
              <td>LALGARH</td>
              <td>LALGARH</td>
              <td>22</td>
              <td>721516</td>
              <td>4</td>
              <td>02</td>
              <td>03221063287</td>
              <td></td>
              <td></td>
              <td></td>
              <td>5</td>
              <td>222</td>
            </tr>
            <tr>
              <td>DAHIJURI MAHATMA VIDYAPITH</td>
              <td>HEAD MASTER</td>
              <td>DAHIJURI</td>
              <td>DAHIJURI</td>
              <td>DAHIJURI</td>
              <td>BI</td>
              <td>721504</td>
              <td>08</td>
              <td>06</td>
              <td>03221251345</td>
              <td></td>
              <td>9531768512</td>
              <td>dmv_3522@rediffmail.com</td>
              <td>37</td>
              <td>222</td>
            </tr>
            <tr>
              <td>RANARANI ADIBASI HIGH SCHOOL</td>
              <td>HEAD MASTER</td>
              <td>RANARANI</td>
              <td>RANARANI</td>
              <td>RANARANI</td>
              <td>BI</td>
              <td>721504</td>
              <td>08</td>
              <td>06</td>
              <td>03221205866</td>
              <td></td>
              <td>9274303297</td>
              <td></td>
              <td>15</td>
              <td>222</td>
            </tr>
            <tr>
              <td>SUB-INSPECTOR OF SCHOOL, LALGARH CIRCLE</td>
              <td>SUB-INSPECTOR OF SCHOOL</td>
              <td>LALGARH</td>
              <td>LALGARH</td>
              <td>LALGARH</td>
              <td>LA</td>
              <td>721516</td>
              <td>01</td>
              <td>02</td>
              <td>03221263207</td>
              <td>03221263207</td>
              <td>9434325148</td>
              <td>lalgarh.clrc.207@gmail.com</td>
              <td>3</td>
              <td>222</td>
            </tr>
            <tr>
              <td>BAITA SRI GOPAL HIGH SCHOOL</td>
              <td>HEADMASTERTER</td>
              <td>BAITA</td>
              <td>BAITA</td>
              <td>JASHPUR</td>
              <td>22</td>
              <td>721504</td>
              <td>08</td>
              <td>06</td>
              <td></td>
              <td></td>
              <td>9732786023</td>
              <td></td>
              <td>15</td>
              <td>222</td>
            </tr>
            <tr>
              <td>BLOCK LIVESTOCK DEV. OFFICER, BINPUR-I</td>
              <td>B.L.D.O.</td>
              <td></td>
              <td>Sonakhali</td>
              <td>Sonalkali</td>
              <td>18</td>
              <td>721170</td>
              <td>01</td>
              <td>02</td>
              <td></td>
              <td></td>
              <td>9434392127</td>
              <td></td>
              <td>12</td>
              <td>230</td>
            </tr>
            <tr>
              <td>BINPUR HIGH SCHOOL</td>
              <td>HEAD MASTER</td>
              <td>BINPUR</td>
              <td>BINPUR</td>
              <td>BINPUR</td>
              <td>21</td>
              <td>721514</td>
              <td>08</td>
              <td>06</td>
              <td></td>
              <td></td>
              <td>8926454508</td>
              <td>binpur_high@rediffmail.com</td>
              <td>35</td>
              <td>222</td>
            </tr>
            <tr>
              <td>ANDHARIA RAJBALLAV HIGH SCHOOL (HS)</td>
              <td>HEAD MASTER</td>
              <td>ANDHARIA</td>
              <td>ANDHARIA</td>
              <td>ANDHARIA</td>
              <td>21</td>
              <td>721504</td>
              <td>08</td>
              <td>06</td>
              <td>8001532929</td>
              <td></td>
              <td></td>
              <td></td>
              <td>26</td>
              <td>222</td>
            </tr>
            <tr>
              <td>LALGARH RAMKRISHNA VIDYALAYA</td>
              <td>HEAD MASTER</td>
              <td>LALGARH</td>
              <td>LALGARH</td>
              <td>LALGARH</td>
              <td>22</td>
              <td>721516</td>
              <td>08</td>
              <td>06</td>
              <td>03221263253</td>
              <td></td>
              <td>9434990152</td>
              <td></td>
              <td>43</td>
              <td>222</td>
            </tr>
            <tr>
              <td>UCO BANK, BINPUR</td>
              <td>BRANCH MANAGER</td>
              <td>BINPUR</td>
              <td>BINPUR</td>
              <td>BINPUR</td>
              <td>BI</td>
              <td>721502</td>
              <td>04</td>
              <td>03</td>
              <td>03221260205</td>
              <td></td>
              <td></td>
              <td></td>
              <td>4</td>
              <td>222</td>
            </tr>
            <tr>
              <td>BANK OF INDIA, KANTAPAHARI</td>
              <td>Branch Managar</td>
              <td>KANTAPAHARI</td>
              <td>KANTAPAHARI</td>
              <td>SIJUA</td>
              <td>22</td>
              <td>721121</td>
              <td>04</td>
              <td>03</td>
              <td></td>
              <td></td>
              <td>8900351951</td>
              <td></td>
              <td>5</td>
              <td>222</td>
            </tr>
            <tr>
              <td>LALGARH R.K.VIDAYALAYA</td>
              <td>HEAD MASTER </td>
              <td>LALGARH</td>
              <td>LALGARH</td>
              <td>LALGARH</td>
              <td>22</td>
              <td>721516</td>
              <td>08</td>
              <td>04</td>
              <td>03221263253</td>
              <td></td>
              <td>9434990152</td>
              <td></td>
              <td>43</td>
              <td>222</td>
            </tr>
            <tr>
              <td>UNITED BANK OF INDIA ,LALGARH BRANCH</td>
              <td>BRANCH MANAGER </td>
              <td>LALGARH</td>
              <td>LALGARH</td>
              <td>LALGARH</td>
              <td>LA</td>
              <td>721516</td>
              <td>04</td>
              <td>04</td>
              <td>03221263263</td>
              <td></td>
              <td></td>
              <td>bmlgr@unitedbanks.co.in</td>
              <td>4</td>
              <td>222</td>
            </tr>
            <tr>
              <td>RAMGARH MS HIGH SCHOOL</td>
              <td>HEAD MASTER </td>
              <td>RAMGARH</td>
              <td>RAMGARH</td>
              <td>RAMGARH</td>
              <td>22</td>
              <td>721128</td>
              <td>08</td>
              <td>04</td>
              <td>03227256258</td>
              <td></td>
              <td>9932748241</td>
              <td></td>
              <td>30</td>
              <td>222</td>
            </tr>
            <tr>
              <td>SBI, JASHPUR</td>
              <td>BRANCH MANAGER</td>
              <td>JASHPUR</td>
              <td>JASHPUR</td>
              <td>JASHPUR</td>
              <td>22</td>
              <td>721504</td>
              <td>04</td>
              <td>03</td>
              <td>03221205877</td>
              <td></td>
              <td>8001194890</td>
              <td></td>
              <td>4</td>
              <td>222</td>
            </tr>
            <tr>
              <td>BLOCK MEDICAL OFFICER OF HEALTH, BINPUR-I</td>
              <td>BMOH</td>
              <td>BINPUR</td>
              <td>BINPUR</td>
              <td>BINPUR</td>
              <td>21</td>
              <td>721502</td>
              <td>01</td>
              <td>02</td>
              <td>03221260561</td>
              <td></td>
              <td>9474735857</td>
              <td>binpur_rh@rediffmail.com</td>
              <td>37</td>
              <td>222</td>
            </tr>
            <tr>
              <td>OFFICE OF THE BLOCK DEV. OFFICER, BINPUR-I</td>
              <td>BDO</td>
              <td>LALGARH</td>
              <td>LALGARH</td>
              <td>LALGARH</td>
              <td>22</td>
              <td>721516</td>
              <td>01</td>
              <td>02</td>
              <td>03221263260</td>
              <td></td>
              <td>8348691757</td>
              <td>bdolalgarh@gmail.com</td>
              <td>52</td>
              <td>222</td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
  </form>
  <?php
  /**
    $Data = new MySQLiDB();
    echo 'Total Records: ' . $Data->ShowTable(
    'SELECT `OfficeName` as `Name of the Office`, '
    . '`DesgOC` as `Designation of Officer-in-Charge`, '
    . '`AddrPTS` as `Para/Tola/Street`, `AddrVTM` as `Village/Town/Street`, '
    . '`PostOffice`, `PSCode`,`PinCode`, '
    . '`Status` as `Nature`, `TypeCode` as `Status`, `Phone`, `Fax`, '
    . '`Mobile`, `EMail`, `Staffs`, `ACNo` '
    . ' FROM `' . MySQL_Pre . 'PP_Offices` '
    . ' WHERE `UserMapID`=' . $_SESSION['UserMapID']);
    $Data->do_close();
    unset($Data);
   */
  ?>
  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>

