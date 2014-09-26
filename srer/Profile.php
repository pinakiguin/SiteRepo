<?php
/**
 * @todo User Password Change incomplete [Working currently]
 */
require_once(__DIR__ . '/../lib.inc.php');
WebLib::AuthSession();
WebLib::Html5Header("Profile");
WebLib::IncludeCSS();
WebLib::IncludeJS("js/md5.js");
WebLib::JQueryInclude();
WebLib::IncludeCSS("Jcrop/css/jquery.Jcrop.min.css");
WebLib::IncludeJS("Jcrop/js/jquery.Jcrop.min.js");
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
WebLib::ShowMenuBar('SRER');
?>
<div class="content">
    <span class="Message" id="Msg">
      <b>Loading please wait...</b>
    </span>
  <?php
  WebLib::ShowMsg();
  $Data = new MySQLiDB();
  ?>
  <div class="FieldGroup">
    <?php
    $_SESSION['Query'] = 'Select `DistCode`,`District`'
      . ' FROM `' . MySQL_Pre . 'SRER_Districts` '
      . ' Where `UserMapID`=' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE);
    $Rows = $Data->ShowTable($_SESSION['Query']);
    echo 'Total Records:' . $Rows;
    ?>
  </div>
  <div class="FieldGroup" style="height: 500px;overflow:auto;">
    <?php
    $_SESSION['Query'] = 'Select `District`,`ACNo`,`ACName`'
      . ' FROM `' . MySQL_Pre . 'SRER_ACs` A '
      . ' JOIN `' . MySQL_Pre . 'SRER_Districts` D ON(A.`DistCode`=D.`DistCode`)'
      . ' Where A.`UserMapID`=' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE);
    $Rows = $Data->ShowTable($_SESSION['Query']);
    echo 'Total Records:' . $Rows;
    ?>
  </div>
  <div class="FieldGroup" style="height: 500px;overflow:auto;">
    <?php
    $_SESSION['Query'] = 'Select `ACNo`,`PartNo`,`PartName`'
      . ' FROM `' . MySQL_Pre . 'SRER_PartMap`'
      . ' Where `UserMapID`=' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE);
    $Rows = $Data->ShowTable($_SESSION['Query']);
    echo 'Total Records:' . $Rows;
    ?>
  </div>
  <pre id="Error"></pre>
</div>
<div class="pageinfo">
  <?php WebLib::PageInfo(); ?>
</div>
<div class="footer">
  <?php WebLib::FooterInfo(); ?>
</div>
</body>
</html>

