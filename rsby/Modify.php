<?php
require_once('../lib.inc.php');

WebLib::AuthSession();
WebLib::Html5Header('RSBY-2014');
WebLib::IncludeCSS();
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
    $POST_MouzaCode = WebLib::GetVal($_POST, 'MouzaCode', true);
    $RSBY_UnMatched = "From RSBY_MGNREGA M,RSBY_UnMatched U where U.RegistrationNo=M.RegistrationNo AND ApplicantNo=1 AND U.MouzaCode is null";
    ?>
    <span class="Message"><?php
      if ((WebLib::GetVal($_POST, 'Cmd') == "Save") && (isset($_POST['RegNo']))) {
        $r = 0;
        $Updates = 0;
        while ($r < count($_POST['RegNo'])) {
          $Query = "Update RSBY_UnMatched Set MouzaCode='" . $POST_MouzaCode . "'"
                  . " Where RegistrationNo='" . mysql_real_escape_string($_POST['RegNo'][$r]) . "' LIMIT 1;";
          $Updates+=$Data->do_ins_query($Query);
          //echo $Query;
          $r++;
        }
        echo "Rashtriya Swasthya Bima Yojna - (" . ($Updates) . ") UnMatched Updated!";
      } else {
        if ($POST_PanchayatCode != "") {
          $UnMatchCountBlock = $Data->do_max_query("Select count(*) " . $RSBY_UnMatched . " AND RSBY_BlockCode='" . $POST_BlockCode . "'");
          $UnMatchCount = $Data->do_max_query("Select count(*) " . $RSBY_UnMatched . " AND Panchayat_TownCode='" . $POST_PanchayatCode . "'");
          echo "Rashtriya Swasthya Bima Yojna - UnMatched in Block (" . $UnMatchCountBlock . ") Panchayat (" . $UnMatchCount . ")";
        } else if ($POST_BlockCode != "") {
          $UnMatchCount = $Data->do_max_query("Select count(*) " . $RSBY_UnMatched . " AND RSBY_BlockCode='" . $POST_BlockCode . "'");
          echo "Rashtriya Swasthya Bima Yojna - UnMatched in Block (" . $UnMatchCount . ")";
        }
      }
      ?></span>
    <form id="frmModify" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="text-align:left;" autocomplete="off" >
      <label for="BlockCode"><strong>Block:</strong>
        <select name="BlockCode">
          <?php
          $Data->show_sel('RSBY_BlockCode', 'BlockName', "Select RSBY_BlockCode,BlockName " . $RSBY_UnMatched . " group by BlockName", $POST_BlockCode);
          ?>
        </select>
      </label>
      <label for="PanchayatCode"><strong>Panchayat:</strong>
        <select name="PanchayatCode">
          <?php
          $Data->show_sel('Panchayat_TownCode', 'PanchayatName', "Select Panchayat_TownCode,PanchayatName " . $RSBY_UnMatched . " AND RSBY_BlockCode='" . $POST_BlockCode . "' group by PanchayatName", $POST_PanchayatCode);
          ?>
        </select>
      </label>
      <input type="submit" name="Cmd" value="Refresh"/>
      <?php
      $QryUnMatchedCount = "Select M.`RegistrationNo`,`RH_ID`,`ApplicantName`,`VillageName`,M.MouzaCode " . $RSBY_UnMatched . " AND Panchayat_TownCode='" . $POST_PanchayatCode . "' ORDER BY `VillageName` limit 15";
      //echo $QryUnMatchedCount;
      $Count = $Data->do_sel_query($QryUnMatchedCount);
      ?>
      <table rules="all" frame="box" width="100%" cellpadding="5" cellspacing="1">
        <tr><th align="center" width="20px">Tick</th><th>Village Name - (UnMatched MouzaCode)</th><th>RegistrationNo</th><th>RHS ID</th><th>Applicant Name</th></tr>
        <?php
        for ($i = 0; $i < $Count; $i++) {
          $row = $Data->get_n_row();
          echo '<tr><td  align="center" width="20px"><input type="checkbox" name="RegNo[]" value="' . htmlspecialchars($row[0]) . '"/></td><td>' . htmlspecialchars($row[3]) . " - (" . htmlspecialchars($row[4]) . ")</td><td>" . htmlspecialchars($row[0]) . '</td><td><input type="text" name="RHSID[]" size="25" value="' . htmlspecialchars($row[1]) . '"/></td><td>' . htmlspecialchars($row[2]) . "</td></tr>";
        }
        ?>
      </table>
      <label for="MouzaCode" style="margin-left:11px;"><strong><img src="arrow_ltr.png" />Selected Beneficiaries belongs to Census Mouza:</strong>
        <select name="MouzaCode">
          <?php
          $Qry = "Select VillageCode,concat(`VillageCode`,' - ',`VillageName`) as VillageName from RSBY_MstVillage Where BlockCode='" . $POST_BlockCode . "' AND Panchayat_TownCode='" . $POST_PanchayatCode . "' group by VillageName";
          $Data->show_sel('VillageCode', 'VillageName', $Qry, $POST_MouzaCode);
          ?>
        </select>
      </label>
      <Input type="Submit" name="Cmd" value="Save" />
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
</body>
</html>