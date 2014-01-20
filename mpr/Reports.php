<?php
//ini_set('display_errors', '1');
//error_reporting(E_ALL);

require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Reports');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('mpr/js/forms.js');
WebLib::IncludeCSS('mpr/css/forms.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
?>

<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">

  // Load the Visualization API and the piechart package.
  google.load('visualization', '1.0', {'packages': ['corechart']});

  // Set a callback to run when the Google Visualization API is loaded.
  google.setOnLoadCallback(drawChart);


  // Callback that creates and populates a data table,
  // instantiates the pie chart, passes in the data and
  // draws it.
  function drawChart() {

    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Topping');
    data.addColumn('number', 'Slices');

    data.addRows([
      ['Mushrooms', 3],
      ['Onions', 1],
      ['Olives', 1],
      ['Zucchini', 1],
      ['Pepperoni', 2]
    ]);

    // Set chart options
    var options = {'title': 'Monthly Progress Report',
      'width': 400,
      'height': 300, orientation: 'horizontal'};

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
</script>
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
  WebLib::ShowMenuBar('MPR');
  ?>
  <div class="content">
    <?php
    if (WebLib::GetVal($_SESSION, 'Token') === null) {
      $_SESSION['Token'] = md5($_SERVER['REMOTE_ADDR'] . session_id() . $_SESSION['ET']);
    }
    ?>

    <form id="frmModify" method="post" action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>"
          style="text-align:left;" autocomplete="off" >
      <h3>Process </h3>
      <?php
      include __DIR__ . '/DataMPR.php';
      $Data = new MySQLiDB();
      $Data1 = new MySQLiDBHelper();
      ?>
      <div class="FieldGroup">
        <label for="ProjectName"><strong>Project Name</strong></label><br/>
        <select name="ProjectID" data-placeholder="Select Project">
          <?php
          $Query = 'Select `ProjectID`, `ProjectName` '
                  . ' FROM `' . MySQL_Pre . 'MPR_Projects` '
                  . ' Order By `ProjectID`';
          $Data->show_sel('ProjectID', 'ProjectName', $Query, WebLib::GetVal($_POST, 'ProjectID'));
          ?>
        </select>
      </div>
      <pre>
        

        <!--Div that will hold the pie chart-->
        <div id="chart_div" style="width:400; height:300"></div>
 <div class="FieldGroup">
          <label for="CmbDeptID"><strong>Department:</strong><br/>
            <select id="CmbBlockCode" name="DeptID">
              <option value=""></option>
            </select>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="CmbSectorID"><strong>Sector:</strong><br/>
            <select id="CmbSectorID" name="SectorID">
              <option value=""></option>
            </select>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="CmbSchemeID"><strong>Scheme:</strong><br/>
            <select id="CmbSchemeID" name="SchemeID">
              <option value=""></option>
            </select>
          </label>
        </div>
<div class="FieldGroup">
          <label for="CmbProjectID"><strong>Project:</strong><br/>
            <select id="CmbProjectID" name="ProjectID">
              <option value=""></option>
            </select>
          </label>
        </div>
        <div class="FieldGroup">
          <br/>
          <input type="submit" id="CmdRefreshRSBY" name="CmdRefresh" value="Refresh"/>
          <input type="hidden" id="AjaxToken"
                 value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
        </div>
        <span class="Message" id="Msg" style="float: right;">
          <b>Loading please wait...</b>
        </span>
     </form>
        <div style="clear: both;"></div>
      <br/>
      <table id="example" class="display stripe row-border hover order-column" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>URN</th>
            <th>Name of Household</th>
            <th>Name of Father/Husband</th>
            <th>RSBY Type</th>
            <th>Category Code</th>
            <th>BPL Citizen</th>
            <th>Minority</th>
          </tr>
        </thead>
      </table>

    <pre id="Error">
    </pre>
  </div>

</body>
</html>