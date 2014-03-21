<?php
require_once __DIR__ . '/../lib.inc.php';
WebLib::AuthSession();
WebLib::Html5Header('Mid Day Meal');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('MDM/css/forms.css');
WebLib::IncludeJS('MDM/js/neumeric.js');
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
WebLib::IncludeJS('MDM/js/School.js');
?>
</head>
<body onload="startWorker()">
  <div id="txt"></div>
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
      ?>" id="Schoolfrom" >
        <span style="text-align: center"><h3> School Mid Day Meal Report</h3></span>
        <div style="text-align: right" class="myfont">
          <p>Current Time Is: <output id="result"></output></p>
          <br><br>
          <script>
            var w;
            function startWorker()
            {
              if (typeof (Worker) !== "undefined")
              {
                if (typeof (w) === "undefined")
                {
                  w = new Worker("time.js");
                }
                w.onmessage = function(event) {
                  document.getElementById("result").innerHTML = event.data;
                };
              }
              else
              {
                document.getElementById("result").innerHTML =
                        "Sorry, your browser does not support Web Workers...";
              }
            }

            function stopWorker()
            {
              w.terminate();
            }
          </script>
        </div>

        <div class="FieldGroup">
          <label for="SubDivID"><span class="myfont">Select The SubDivision Name</span>
            <select id="SubDivID" name="SubDivID"
                    data-placeholder="Select SubDiv Name">
            </select>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="BlockID"><span class="myfont">Select The Block Name</span>
            <select id="BlockID" name="BlockID"
                    data-placeholder="Select Block">
            </select>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="SchoolID"><span class="myfont">Select Name of School Name</span>
            <select id="SchoolID" name="SchoolID"
                    data-placeholder="Select SchoolName">
            </select>
          </label>
        </div>
        <div style="clear: both"></div>
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
        <br><br>
        <div class="FieldGroup">
          <input type="hidden" id="SchoolReportID" name="SchoolReportID"/>
        </div>
        <div style="clear: both">
          <div class="formControl">
  <!--          <input type="button" id="show" value="Show Data">-->

            <hr/>
            <input type="button" id="Refresh" value="Refresh">
            <input type="reset" id="Reset" value="Reset">
          </div>
          <div style="clear: both"></div>
          <input type="hidden" name="FormToken" id="FormToken"
                 value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
          <input type="hidden" name="AjaxToken" id="AjaxToken"
                 value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />

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
