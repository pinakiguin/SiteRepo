<?php
require_once __DIR__ . '/../lib.inc.php';
WebLib::AuthSession();
WebLib::Html5Header('Mid Day Meal');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('MDM/css/forms.css');
WebLib::IncludeJS('MDM/js/neumeric.js');
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('MDM/js/School.js');
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
  WebLib::ShowMenuBar('MDM');
  ?>
  <div class="content">
    <span class="Message" id="Msg" style="float: right;">
      <b>Loading Please Wait...</b>
    </span>
    <div class="formWrapper">
      <form method="post" action="<?php
      echo WebLib::GetVal($_SERVER, 'PHP_SELF');
      ?>" id="frmlater" >
        <div style="font-size:20px; font-family: Times New Roman;
             color: #0063DC; text-align: center; text-decoration:underline;">
          School Mid Day Meal Report
        </div>
        <div style="text-align: right" class="myfont">
          <?php
          $Dt = date('d-M-Y h:i:s A');
          print_r("$Dt");
          ?>
        </div>
        <div class="FieldGroup">
          <label class="myfont" for="SchoolName">School Name</label>
          <input type="text" name="SchoolName" id="SchoolName" disabled />
        </div>
        <div class="FieldGroup">
          <label class="myfont" for="MealMade">Total Meal Made Today</label>
          <input type="text" name="MealMade" id="MealMade" disabled />
        </div>
        <div class="FieldGroup">
          <label class="myfont" for="TotalStudent">Total Student</label>
          <input type="text" name="TotalStudent" id="TotalStudent" disabled />
        </div>
        <p>Count numbers: <output id="result"></output></p>
        <input type="button" id="startWorker" value="startWorker">
        <input type="button" id="stopWorker" value="stopWorker">
        <br><br>
        <div style="clear: both"></div>

        <pre id="Error">
        </pre>
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
