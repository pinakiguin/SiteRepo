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
  <div class="content" style="padding-top: 10px;">
    <span id="Error"></span>
    <span class="Message" id="Msg" style="float: right;">
      <b>Message: </b> All messages will be shown here.
    </span>
    <form name="frmSRER" method="post" action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>">
      <div class="FieldGroup">
        <label for="textfield">AC No.:</label><br/>
        <select name="ACNo" id="ACNo" data-placeholder="Select an Assembly Constituency" >
        </select>
        <?php //echo $Query; ?>
      </div>
      <div class="FieldGroup">
        <label for="textfield">Part No.:</label><br/>
        <select name="PartID" id="PartID" data-placeholder="Select a Part of Assembly Constituency" >
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
    ?>
    <!-- // @todo Change type="hidden" remove styles -->
    <input type="text" id="ActivePartID" style="width:50px;" />
    <input type="text" id="ActiveSRERForm" style="width:100px;" value="SRERForm6" />

    <div id="SRER_Forms" style="text-align:center;width:100%;display:table;">

      <ul>
        <li><a href="#SRERForm6" >Form 6 </a></li>
        <li><a href="#SRERForm6A">Form 6A</a></li>
        <li><a href="#SRERForm7" >Form 7 </a></li>
        <li><a href="#SRERForm8" >Form 8 </a></li>
        <li><a href="#SRERForm8A">Form 8A</a></li>
      </ul>
      <input type="hidden" id="AjaxToken"
             value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
      <div id="SRERForm6">
        <table class="SRERForm">
          <thead>
            <tr>
              <th colspan="2" class="SlNo">Sl No.</th>
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
                <td style="text-align: left;">
                  <input id="RowID1" type="checkbox" />
                </td>
                <td>
                  <input type="text" id="SRERForm6SlNo<?php echo $i; ?>" class="SlNo" />
                </td>
                <td><input type="text" class="ReceiptDate" id="SRERForm6ReceiptDate<?php echo $i; ?>" placeholder="dd/mm/yyyy"
                           readonly="readonly" /></td>
                <td><input type="text" id="SRERForm6AppName<?php echo $i - 1; ?>" /></td>
                <td><input type="text" id="SRERForm6DOB<?php echo $i - 1; ?>" class="DOB" placeholder="dd/mm/yyyy" /></td>
                <td>
                  <select id="SRERForm6Sex<?php echo $i - 1; ?>">
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                    <option value="U">Other</option>
                  </select>
                </td>
                <td><input type="text" id="SRERForm6RelationshipName<?php echo $i - 1; ?>" /></td>
                <td>
                  <select id="SRERForm6Relationship<?php echo $i - 1; ?>">
                    <option value="F">Father</option>
                    <option value="M">Mother</option>
                    <option value="H">Husband</option>
                    <option value="U" selected="selected">Other</option>
                  </select>
                </td>
                <td>
                  <select id="SRERForm6Status<?php echo $i - 1; ?>">
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
              <td colspan="6" style="text-align: left;">
                <span>Show 10 Rows Starting From: </span>
                <input type="text" id="FromRow" style="width: 50px;" />
                <input type="button" id="CmdEdit"  value="Edit"/>
              </td>
              <td colspan="3" style="text-align: right;">
                <input type="button" id="CmdNew"  value="New"/>
                <input type="button" id="CmdSave" value="Save"/>
                <input type="button" id="CmdDel"  value="Delete"/>
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div id="SRERForm6A">
      </div>
      <div id="SRERForm7">
      </div>
      <div id="SRERForm8">
      </div>
      <div id="SRERForm8A">
      </div>
    </div>
  </div>
  <div class="pageinfo"><?php WebLib::PageInfo(); ?></div>
  <div class="footer"><?php WebLib::FooterInfo(); ?></div>
</body>
</html>
