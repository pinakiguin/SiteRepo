<?php
/**
 * @todo Cache based Selection of AC and Part
 * @todo Form Selection using jQuery UI Tabs
 */
require_once('srer.lib.php');

WebLib::AuthSession();
WebLib::Html5Header("Data Entry");
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('css/DataEntry.css');
WebLib::IncludeJS('js/DataEntry.js');
WebLib::IncludeCSS('css/chosen.min.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
$Data = new MySQLiDB();
if (WebLib::GetVal($_SESSION, 'ACNo') == "")
  $_SESSION['ACNo'] = "";
if (WebLib::GetVal($_SESSION, 'PartID') == "")
  $_SESSION['PartID'] = "";
if (intval(WebLib::GetVal($_POST, 'PartID')) > 0)
  $_SESSION['PartID'] = intval(WebLib::GetVal($_POST, 'PartID'));
if (WebLib::GetVal($_POST, 'ACNo') != "")
  $_SESSION['ACNo'] = WebLib::GetVal($_POST, 'ACNo');
if (intval(WebLib::GetVal($_REQUEST, 'ID')) > 0)
  $_SESSION['UserMapID'] = intval($_REQUEST['ID']);
?>
</head>
<body>
  <div class="TopPanel">
    <div class="LeftPanelSide"></div>
    <div class="RightPanelSide"></div>
    <h1><?php echo AppTitle; ?></h1>
  </div>
  <div class="Header">
  </div>
  <?php
  WebLib::ShowMenuBar()
  ?>
  <div class="content">
    <h2><?php echo AppTitle; ?></h2>
    <hr/>
    <form name="frmSRER" method="post" action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>">
      <div class="FieldGroup">
        <label for="textfield">AC No.:</label><br/>
        <select name="ACNo" id="ACNo" onChange="document.frmSRER.submit();">
          <?php
          $Query = 'Select ACNo,CONCAT(ACNo,\' - \',ACName) as ACName from `' . MySQL_Pre . 'SRER_ACs`'
                  . ' Where PartMapID=' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE);
          $Data->show_sel('ACNo', 'ACName', $Query, WebLib::GetVal($_SESSION, 'ACNo', TRUE));
          ?>
        </select>
        <?php //echo $Query; ?>
      </div>
      <div class="FieldGroup">
        <label for="textfield">Part No.:</label><br/>
        <select name="PartID" id="PartID" onChange="document.frmSRER.submit();">
          <?php
          $Choice = (WebLib::GetVal($_SESSION, 'PartID') === "") ? '' : WebLib::GetVal($_SESSION, 'PartID');
          $Query = 'Select PartID,CONCAT(PartNo,\' - \',PartName) as PartName from `' . MySQL_Pre . 'SRER_PartMap` '
                  . ' Where ACNo=\'' . WebLib::GetVal($_SESSION, 'ACNo') . '\' and PartMapID=' . WebLib::GetVal($_SESSION, 'UserMapID') . ' group by PartNo';
          $RowCount = $Data->show_sel('PartID', 'PartName', $Query, $Choice);
          ?>
        </select>
      </div>
    </form>
    <div style="clear:both;"></div>
    <hr />
    <?php
    if ((intval(WebLib::GetVal($_SESSION, 'PartID')) > 0) && (WebLib::GetVal($_SESSION, 'TableName') != "")) {
      $RowCount = $Data->do_max_query("Select count(*) from " . WebLib::GetVal($_SESSION, 'TableName') . " Where PartID=" . WebLib::GetVal($_SESSION, 'PartID'));
      $RowCount = $RowCount - 9;
      if ($RowCount < 1)
        $RowCount = 1;
    }

    if (intval(WebLib::GetVal($_SESSION, 'PartID')) > 0) {
      $PartName = GetPartName();
      echo '<h3>Selected Part[' . $PartName . '] '
      . WebLib::GetVal($_SESSION, 'FormName') . '</h3>';
      ?>
      <div id="SRER_Forms" style="text-align:center;width:100%;display:table;">
        <ul>
          <li><a href="#SRER_Form6" >Form 6 </a></li>
          <li><a href="#SRER_Form6A">Form 6A</a></li>
          <li><a href="#SRER_Form7" >Form 7 </a></li>
          <li><a href="#SRER_Form8" >Form 8 </a></li>
          <li><a href="#SRER_Form8A">Form 8A</a></li>
        </ul>
        <div id="SRER_Form6">
          <table class="SRERForm">
            <thead>
              <tr>
                <th class="SLNo">SL No.</th>
                <th class="ReceiptDate">Date of Receipt</th>
                <th class="AppName">Name of Applicant</th>
                <th class="DOB">Date of Birth</th>
                <th class="Sex">Sex</th>
                <th class="RelationshipName">Name of Father/ Mother/ Husband/ Others</th>
                <th class="Relationship">Relationship</th>
                <th class="Status">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 0;
              while ($i < 10) {
                $i++;
                if ($i < 5) {
                  $Class = 'saved';
                } else {
                  $Class = 'new';
                }
                ?>
                <tr class="<?php echo $Class; ?>">
                  <td style="text-align: left;"><input id="RowID1" type="checkbox" /><label for="RowID1"><?php echo $i; ?></label></td>
                  <td><input type="text" class="ReceiptDate" placeholder="dd/mm/yyyy" /></td>
                  <td><input type="text" /></td>
                  <td><input type="text" class="DOB" placeholder="dd/mm/yyyy" readonly="readonly" /></td>
                  <td>
                    <select id="Sex" class="">
                      <option value="M">Male</option>
                      <option value="F">Female</option>
                      <option value="U">Other</option>
                    </select>
                  </td>
                  <td><input type="text" /></td>
                  <td>
                    <select id="Rel">
                      <option value="F">Father</option>
                      <option value="M">Mother</option>
                      <option value="H">Husband</option>
                      <option value="U" selected="selected">Other</option>
                    </select>
                  </td>
                  <td>
                    <select id="Stat">
                      <option value="A">Accepted</option>
                      <option value="R">Rejected</option>
                      <option value="P" selected="selected">Pending</option>
                    </select>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="8" style="text-align: right;"><input type="button" value="New"/><input type="button" value="Save"/><input type="button" value="Delete"/></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <div id="SRER_Form6A">
          <?php
          SetCurrForm('Form 6A');
          $Query = 'Select ' . WebLib::GetVal($_SESSION, 'Fields') . ' from ' . WebLib::GetVal($_SESSION, 'TableName')
                  . ' Where PartID=' . WebLib::GetVal($_SESSION, 'PartID');
          //EditForm($Query);
          ?>
        </div>
        <div id="SRER_Form7">
          <?php
          SetCurrForm('Form 7');
          $Query = 'Select ' . WebLib::GetVal($_SESSION, 'Fields') . ' from ' . WebLib::GetVal($_SESSION, 'TableName')
                  . ' Where PartID=' . WebLib::GetVal($_SESSION, 'PartID');
          //EditForm($Query);
          ?>
        </div>
        <div id="SRER_Form8">
          <?php
          SetCurrForm('Form 8');
          $Query = 'Select ' . WebLib::GetVal($_SESSION, 'Fields') . ' from ' . WebLib::GetVal($_SESSION, 'TableName')
                  . ' Where PartID=' . WebLib::GetVal($_SESSION, 'PartID');
          //EditForm($Query);
          ?>
        </div>
        <div id="SRER_Form8A">
          <?php
          SetCurrForm('Form 8A');
          $Query = 'Select ' . WebLib::GetVal($_SESSION, 'Fields') . ' from ' . WebLib::GetVal($_SESSION, 'TableName')
                  . ' Where PartID=' . WebLib::GetVal($_SESSION, 'PartID');
          //EditForm($Query);
          ?>
        </div>
        <?php
      }
      ?>
    </div>
  </div>
  <div class="pageinfo"><?php WebLib::PageInfo(); ?></div>
  <div class="footer"><?php WebLib::FooterInfo(); ?></div>
</body>
</html>
