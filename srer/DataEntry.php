<?php
/**
 * @todo All SRER Forms to be generated using same function depending upon table structure
 *
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
        <?php
        SRERForm('SRERForm6');
        ?>
      </div>
      <div id="SRERForm6A">
        <?php
        SRERForm('SRERForm6A');
        ?>
      </div>
      <div id="SRERForm7">
      </div>
      <div id="SRERForm8">
        <?php
        SRERForm('SRERForm8');
        ?>
      </div>
      <div id="SRERForm8A">
        <?php
        SRERForm('SRERForm8A');
        ?>
      </div>
    </div>
    <pre id="Error"></pre>
  </div>
  <div class="pageinfo"><?php WebLib::PageInfo(); ?></div>
  <div class="footer"><?php WebLib::FooterInfo(); ?></div>
</body>
</html>
