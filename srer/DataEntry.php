<?php
/**
 * @todo All SRER Forms to be generated using same function depending upon table structure
 *
 */
require_once(__DIR__ . '/srer.lib.php');

WebLib::AuthSession();
WebLib::Html5Header("Data Entry");
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('srer/css/DataEntry.css');
WebLib::IncludeJS('srer/js/DataEntry.js');
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
WebLib::IncludeJS('js/jquery.validate.min.js');
WebLib::IncludeJS('js/additional-methods.min.js');

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
  WebLib::ShowMenuBar('SRER')
  ?>
  <div class="content" style="padding-top: 10px;">
    <span class="Message" id="Msg" style="float: right;">
      <b>Loading please wait...</b>
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
    <?php // @todo Change type="hidden" remove styles ?>
    <input type="hidden" id="ActivePartID" />
    <input type="hidden" id="ActiveSRERForm" value="SRERForm6I" />

    <div id="SRER_Forms" style="text-align:center;width:100%;display:none;">
      <ul>
        <li><a href="#SRERForm6I" >Form 6 </a></li>
        <li><a href="#SRERForm6A">Form 6A</a></li>
        <li><a href="#SRERForm7I" >Form 7 </a></li>
        <li><a href="#SRERForm8I" >Form 8 </a></li>
        <li><a href="#SRERForm8A">Form 8A</a></li>
      </ul>
      <input type="hidden" id="AjaxToken"
             value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
      <div id="SRERForm6I">
        <?php
        SRERForm('SRERForm6I');
        ?>
      </div>
      <div id="SRERForm6A">
        <?php
        SRERForm('SRERForm6A');
        ?>
      </div>
      <div id="SRERForm7I">
        <?php
        SRERForm('SRERForm7I');
        ?>
      </div>
      <div id="SRERForm8I">
        <?php
        SRERForm('SRERForm8I');
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
