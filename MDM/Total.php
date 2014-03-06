<?php
/**
 * @todo All SRER Forms to be generated using same function depending upon table structure
 *
 */
require_once(__DIR__ . '/MDM.lib.php');

WebLib::AuthSession();
WebLib::Html5Header("Data Entry");
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('css/forms.css');
WebLib::IncludeCSS('MDM/css/forms.css');
WebLib::IncludeCSS('MDM/css/DataEntry.css');
WebLib::IncludeJS('MDM/js/DataEntry.js');
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
WebLib::IncludeJS('js/jquery.validate.min.js');
WebLib::IncludeJS('js/additional-methods.min.js');
session_start();
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
  WebLib::ShowMenuBar('MDM')
  ?>
  <div class="content" style="padding-top: 10px;">
    <span class="Message" id="Msg" style="float: right;">
      <b>Loading please wait...</b>
    </span>
    <form name="frmMealReport" method="post" action="<?php
    echo WebLib::GetVal($_SERVER, 'PHP_SELF');
    ?>">
      <div class="FieldGroup">
        <select id="SchoolName" name="SchoolName"
                data-placeholder="Select SchoolName">
        </select>
      </div>
      <div class="FieldGroup">
        <input type="text" name="TotalStudent" id="TotalStudent" value=""
               placeholder="Total Student" disabled/>
      </div>
    </form>
    <div style="clear:both;"></div>
    <hr />

    <input type="hidden" id="ActivePartID" />
    <input type="hidden" id="ActiveMealReportForm" value="Primary
           <?php echo "$Month"; ?>" />

    <div id="SRER_Forms" style="text-align:center;width:100%;display:none;">
      <ul>
        <li><a href="#B01" >
            B01 </a>
        </li>
        <li><a href="#B02" >
            B02</a>
        </li>
<!--        <li><a href="#Primary<?php echo "$PreMonth"; ?>" >
            Primary <?php echo "$PreMonth"; ?></a>
        </li>
        <li><a href="#UpperPrimary<?php echo "$PreMonth"; ?>" >
            Upper Primary <?php echo "$PreMonth"; ?></a>
        </li>
        <li><a href="#Primary<?php echo "$Month"; ?>" >
            Primary <?php echo "$Month"; ?></a>
        </li>
        <li><a href="#UpperPrimary<?php echo "$Month"; ?>" >
            Upper Primary <?php echo "$Month"; ?></a>
        </li>-->
      </ul>

      <input type="hidden" id="AjaxToken"
             value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
      <div id="B01">
        <?php MealReportForm("B01"); ?>
      </div>
      <div id="UpperPrimary<?php echo $SecPreMonth; ?>">
        <?php
        MealReportForm("UpperPrimary$SecPreMonth");
        ?>
      </div>
      <div id="Primary<?php echo "$PreMonth"; ?>">
        <?php
        MealReportForm("Primary$PreMonth");
        ?>
      </div>
      <div id="UpperPrimary<?php echo "$PreMonth"; ?>">
        <?php
        MealReportForm("UpperPrimary$PreMonth");
        ?>
      </div>
      <div id="Primary<?php echo "$Month"; ?>">
        <?php
        MealReportForm("Primary$Month");
        ?>
      </div>
      <div id="UpperPrimary<?php echo "$Month"; ?>">
        <?php
        MealReportForm("UpperPrimary$Month");
        ?>
      </div>
    </div>
    <pre id="Error"></pre>
  </div>
  <div class="pageinfo"><?php WebLib::PageInfo(); ?></div>
  <div class="footer"><?php WebLib::FooterInfo(); ?></div>
</body>
</html>
