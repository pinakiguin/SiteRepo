<?php
require_once('../lib.inc.php');

WebLib::AuthSession();
WebLib::Html5Header('RSBY-2014');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
WebLib::IncludeJS('rsby/js/Modify.js');
WebLib::IncludeCSS('rsby/css/Modify.css');
if (NeedsDB) {
  WebLib::CreateDB('RSBY');
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
  WebLib::ShowMenuBar('RSBY');
  ?>
  <div class="content">
    <?php
    $Data = new MySQLiDB();
    $POST_BlockCode = WebLib::GetVal($_POST, 'BlockCode', true);
    $POST_PanchayatCode = WebLib::GetVal($_POST, 'PanchayatCode', true);
    $POST_SansadCode = WebLib::GetVal($_POST, 'SansadCode', true);
    $POST_MouzaCode = WebLib::GetVal($_POST, 'MouzaCode', true);
    $RSBY_UnMatched = 'From `' . MySQL_Pre . 'RSBY_NREGA` Where MouzaCode is null';
    ?>
    <span class="Message"><?php
      if ((WebLib::GetVal($_POST, 'Cmd') == "Save") && (isset($_POST['RegNo']))) {
        if (strlen(WebLib::GetVal($_POST, 'MouzaCode')) < 8) {
          echo 'Please Select the Census Mouza!';
        } else {
          $r = 0;
          $Updates = 0;
          while ($r < count($_POST['RegNo'])) {
            $Query = 'Update `' . MySQL_Pre . 'RSBY_MGNREGA` Set MouzaCode=\'' . $POST_MouzaCode . '\''
                    . ' Where RegistrationNo=\'' . WebLib::GetVal($_POST['RegNo'], $r, true) . '\' LIMIT 1;';
            $Updates+=$Data->do_ins_query($Query);
            //echo $Query;
            $r++;
          }
          echo "Total - (" . ($Updates) . ") UnMatched Updated!";
        }
      } else {
        if ($POST_PanchayatCode != "") {
          $UnMatchCountBlock = $Data->do_max_query("Select count(*) " . $RSBY_UnMatched . " AND RSBY_BlockCode='" . $POST_BlockCode . "'");
          $UnMatchCount = $Data->do_max_query("Select count(*) " . $RSBY_UnMatched . " AND Panchayat_TownCode='" . $POST_PanchayatCode . "'");
          echo "Total - UnMatched in Block (" . $UnMatchCountBlock . ") Panchayat (" . $UnMatchCount . ")";
        } else if ($POST_BlockCode != "") {
          $UnMatchCount = $Data->do_max_query("Select count(*) " . $RSBY_UnMatched . " AND RSBY_BlockCode='" . $POST_BlockCode . "'");
          echo "Total - UnMatched in Block (" . $UnMatchCount . ")";
        }
      }
      ?></span>
    <form id="frmModify" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="text-align:left;" autocomplete="off" >
      <label for="BlockCode"><strong>Block:</strong>
        <select name="BlockCode" class="chzn-select">
<?php
$QryBlocks = 'Select RSBY_BlockCode,CONCAT(RSBY_BlockCode,\'-\',BlockName) as BlockName ' . $RSBY_UnMatched . ' group by BlockName';
$Data->show_sel('RSBY_BlockCode', 'BlockName', $QryBlocks, $POST_BlockCode);
?>
        </select>
      </label>
      <label for="PanchayatCode"><strong>Panchayat:</strong>
        <select name="PanchayatCode" class="chzn-select">
<?php
$QryPanchayats = 'Select Panchayat_TownCode,CONCAT(Panchayat_TownCode,\'-\',PanchayatName) as PanchayatName ' . $RSBY_UnMatched
        . ' AND RSBY_BlockCode=\'' . $POST_BlockCode . '\' group by PanchayatName';
$Data->show_sel('Panchayat_TownCode', 'PanchayatName', $QryPanchayats, $POST_PanchayatCode);
?>
        </select>
      </label>
      <label for="SansadCode"><strong>Sansad:</strong>
        <select name="SansadCode" class="chzn-select">
<?php
$QryVillages = 'Select VillageName,VillageName ' . $RSBY_UnMatched
        . ' AND Panchayat_TownCode=\'' . $POST_PanchayatCode . '\' group by VillageName';
$Data->show_sel('VillageName', 'VillageName', $QryVillages, $POST_SansadCode);
?>
        </select>
      </label>
      <input type="submit" name="Cmd" class="button" value="Refresh"/>
<?php
$QryUnMatchedCount = 'Select `VillageName`,`MouzaCode`,`RegistrationNo`,`ApplicantName`,`FatherHusbandName`,`Gender`,`Age`,`Caste` '
        . $RSBY_UnMatched . ' AND Panchayat_TownCode = \'' . $POST_PanchayatCode
        . '\' AND VillageName=\'' . $POST_SansadCode . '\' ORDER BY `VillageName` limit 15';
$Count = $Data->do_sel_query($QryUnMatchedCount);
?>
      <table rules="all" frame="box" width="100%" cellpadding="5" cellspacing="1">
        <tr><th align="center" width="20px">Tick</th>
          <th>Village Name - (MouzaCode)</th>
          <th>RegistrationNo</th>
          <th>Applicant Name</th>
          <th>Father/Husband Name</th>
          <th>Gender</th>
          <th>Age</th>
          <th>Caste</th>
        </tr>
<?php
for ($i = 0; $i < $Count; $i++) {
  $row = $Data->get_row();
  echo '<tr><td  align="center" width="20px">'
  . '<input type="checkbox" name="RegNo[]" value="' . htmlspecialchars($row['RegistrationNo']) . '"/></td>'
  . '<td>' . htmlspecialchars($row['VillageName']) . ' - (' . htmlspecialchars($row['MouzaCode']) . ')</td>'
  . '<td>' . htmlspecialchars($row['RegistrationNo']) . '</td>'
  . '<td>' . htmlspecialchars($row['ApplicantName']) . '</td>'
  . '<td>' . htmlspecialchars($row['FatherHusbandName']) . '</td>'
  . '<td>' . htmlspecialchars($row['Gender']) . '</td>'
  . '<td>' . htmlspecialchars($row['Age']) . '</td>'
  . '<td>' . htmlspecialchars($row['Caste']) . '</td></tr>';
}
?>
      </table>
      <label for="MouzaCode" style="margin-left:11px;
             "><strong><img src="arrow_ltr.png" />Selected Beneficiaries belongs to Census Mouza:</strong>
        <select name="MouzaCode" class="chzn-select">
<?php
$Qry = "Select VillageCode, concat(`VillageCode`, ' - ', `VillageName`) as VillageName from `" . MySQL_Pre . "RSBY_MstVillage` Where BlockCode = '" . $POST_BlockCode . "' AND Panchayat_TownCode = '" . $POST_PanchayatCode . "' group by VillageName";
$Data->show_sel('VillageCode', 'VillageName', $Qry, $POST_MouzaCode);
?>
        </select>
      </label>
      <Input type="Submit" name="Cmd" value="Save" class="button"/>
<?php
//echo $Qry;
//echo $QryBlocks;
//echo $QryPanchayats;
//echo $QryUnMatchedCount;
?>
    </form>
      <?php
//$Data->ShowTable('select BlockCode,BlockName from RSBY_MstBlock order by BlockName');
      ?>
  </div>
  <div class="pageinfo">
<?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
<?php WebLib::FooterInfo(); ?>
  </div>
  <script>
    $('.chzn-select')
            .chosen({width: "300px",
      no_results_text: "Oops, nothing found!"
    });
  </script>
</body>
</html>
