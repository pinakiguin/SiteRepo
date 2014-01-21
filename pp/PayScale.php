<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Polling Personnel 2014');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
WebLib::IncludeJS('pp/js/forms.js');
WebLib::IncludeCSS('pp/css/forms.css');
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
  <div class="content">
    <div class="formWrapper">
      <form method="post" action="<?php
      echo WebLib::GetVal($_SERVER,
                          'PHP_SELF');
      ?>" >
        <h3>Scale Of Pay</h3>
        <div class="FieldGroup">
          <lebel for="ScaleType"><strong>Scale Type</strong>
            <select>
              <option value="1">1-State Govt.</option>
              <option value="2">2-Central Govt.</option>

            </select>
          </lebel>
          <label for="PayBand"><strong>Pay Band</strong>
            <select id="PayBand" name="PayBand" class="chzn-select"
                    data-placeholder="Select Pay Band">
              <option value="0"></option>
              <option value="Pb1">Pay Band-1</option>
              <option value="Pb2">Pay Band-2</option>
              <option value="Pb3">Pay Band-3</option>
              <option value="Pb4">Pay Band-4</option>
              <option value="Pb5">Pay Band-4A</option>
              <option value="Pb6">Pay Band-4B</option>
              <option value="Pb7">Pay Band-5</option>
              <option value="Pb8">Others Gr-A Equivalent</option>
              <option value="Pb9">Others Gr-B Equivalent</option>
              <option value="Pb10">Others Gr-C Equivalent</option>
              <option value="Pb11">Others Gr-D Equivalent</option>
            </select>
          </label>
          <strong>Scale</strong>
        </div>
        <div style="clear: both;"></div>
        <div class="FieldGroup" style="">
          <input type="text" id="Scale" name="Scale" value=""
                 placeholder="Starting Range" size="8"/>
        </div>
        <div class="FieldGroup"
             style="margin-top: 20px;border:1px solid black;width: 10px;">
        </div>
        <div class="FieldGroup">
          <input type="text" id="Scale" name="Scale" value=""
                 placeholder="Ending Range" size="8"/>
        </div>
        <label for="GradePay">
          <strong>Grade Pay</strong>
          <input type="text" name="GradePay" id="GradePay" value="" />
        </label>
        <hr style="clear: both;"/>
        <div style="display: inline-block; float: right;">
          <input type="submit" name="CmdSubmit" value="Save"/>
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


