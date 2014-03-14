<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Mid Day Meal');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('MDM/css/forms.css');
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
WebLib::IncludeJS('MDM/js/Other.js');
$_SESSION['FormToken'] = md5($_SERVER['REMOTE_ADDR']
    . session_id() . microtime());
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
      ?>" id="sms" >

        <?php
//change.....................
        $ID                    = 0;
        $TotalMeal             = 0;
        $TotalStudent          = 0;
        $SubSData              = array();
        $SubMData              = array();
        $BlockSData            = array();
        $BlockMData            = array();
        $BlockList             = array();
        $Data                  = new MySQLiDBHelper();

        $Query = 'Select D.SubdivID,D.SubdivName,B.BlockID,B.BlockName,'
            . 'S.SchoolID,S.SchoolName,S.TotalStudent,M.Meal,'
            . 'M.ReportDate FROM WebSite_MDM_SubDivision D '
            . 'INNER JOIN WebSite_MDM_Blocks B '
            . 'ON D.SubDivID=B.SubDivID INNER JOIN '
            . 'WebSite_MDM_Newdata S ON B.BlockID=S.BlockID '
            . 'LEFT JOIN WebSite_MDM_MealData M '
            . 'ON S.SchoolID=M.SchoolID ORDER BY SchoolID';

        $MealRecord = $Data->rawQuery($Query);
        print_r($MealRecord);
        echo '<hr>';
        foreach ($MealRecord as $key => $val) {
          $TotalStudent                = $TotalStudent + $val ['TotalStudent'];
          $TotalMeal                   = $TotalMeal + $val ['Meal'];
          $SubMData[$val['SubdivID']]  = $SubMData[$val['SubdivID']] + $val ['Meal'];
          $SubSData[$val['SubdivID']]  = $SubSData[$val['SubdivID']] + $val ['TotalStudent'];
          $BlockSData[$val['BlockID']] = $BlockSData[$val['BlockID']] + $val ['Meal'];
          $BlockMData[$val['BlockID']] = $BlockMData[$val['BlockID']] + $val ['TotalStudent'];
        }
        echo "The total srudent of the district is=> $TotalStudent";
        echo '<br>';
        echo "Total Meal made today is=>$TotalMeal";
        echo '<br>';
        echo '<hr>';
        foreach ($SubMData as $key => $val) {
          echo "Total Meal made today is=>$key : " . $val;
          echo '<br>';
        }
        echo '<hr>';
        foreach ($SubSData as $key => $val) {
          echo "Total Student is=>$key : " . $val;
          echo '<br>';
        }
        echo '<hr>';
        foreach ($BlockSData as $key => $val) {
          echo "Total Student is=>$key : " . $val;
          echo '<br>';
        }
        echo '<hr>';
        foreach ($BlockMData as $key => $val) {
          echo "Total Meal made today is=>$key : " . $val;
          echo '<br>';
        }
        ?>
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

