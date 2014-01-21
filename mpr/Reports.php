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

  google.load('visualization', '1.0', {'packages': ['corechart']});
  google.setOnLoadCallback(drawChart);
  function drawChart() {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Topping');
    data.addColumn('number', 'Slices');

    data.addRows([
      ['Financial Progress', 3],
      ['Work in progress', 1]
    ]);
    var options = {'title': 'Monthly Progress Report',
      'width': 400,
      'height': 300, orientation: 'horizontal'};
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
    <div class="formWrapper">
      <form id="frmModify" method="post" action="<?php
      echo WebLib::GetVal($_SERVER, 'PHP_SELF');
      ?>"
            style="text-align:left;" autocomplete="off" >
        <h3>Process </h3>
        <?php
        include __DIR__ . '/DataMPR.php';
        $Data  = new MySQLiDB();
        $Data1 = new MySQLiDBHelper();
        ?>
        <div class="FieldGroup">
          <label for="DeptName"><strong>Department</strong></label><br/>
          <select name="Deptname" id="DeptID" data-placeholder="Select Department">
            <?php
            $Query = 'Select `DeptID`, `DeptName` '
                . ' FROM `' . MySQL_Pre . 'MPR_Departments` '
                . ' Order By `DeptName`';
            $Data->show_sel('DeptID', 'DeptName', $Query,
                            WebLib::GetVal($_POST, 'DeptID'));
            ?>
          </select>
        </div>
        <div class="FieldGroup">
          <label for="SectorName"><strong>Sector</strong></label><br/>
          <select name="SectorName" id="SectorID" data-placeholder="Select Sector">
            <?php
            $Query = 'Select `SectorID`, `SectorName` '
                . ' FROM `' . MySQL_Pre . 'MPR_Sectors` '
                . ' Order By `SectorName`';
            $Data->show_sel('SectorID', 'SectorName', $Query,
                            WebLib::GetVal($_POST, 'SectorID'));
            ?>
          </select>
        </div>
        <div class="FieldGroup">
          <label for="SchemeName"><strong>Scheme</strong></label><br/>
          <select name="SchemeName" id="SchemeID" data-placeholder="Select Sector">
            <?php
            $Query = 'Select `SchemeID`, `SchemeName` '
                . ' FROM `' . MySQL_Pre . 'MPR_Schemes` '
                . ' Order By `SchemeName`';
            $Data->show_sel('SchemeID', 'SchemeName', $Query,
                            WebLib::GetVal($_POST, 'SchemeID'));
            ?>
          </select>
        </div>
        <div class="FieldGroup">
          <label for="ProjectName"><strong>Project Name</strong></label><br/>
          <select name="ProjectID" data-placeholder="Select Project">
            <?php
            $Query = 'Select `ProjectID`, `ProjectName` '
                . ' FROM `' . MySQL_Pre . 'MPR_Projects` '
                . ' Order By `ProjectID`';
            $Data->show_sel('ProjectID', 'ProjectName', $Query,
                            WebLib::GetVal($_POST, 'ProjectID'));
            ?>
          </select>
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
        <div style="clear: both;"></div>
        <div id="chart_div" style="width:400; height:300"></div>

      </form>
    </div>
    <pre id="Error">
    </pre>
  </div>
  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>