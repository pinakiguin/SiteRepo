<?php
require_once('../lib.inc.php');

WebLib::AuthSession();
WebLib::Html5Header('RSBY-2014');
WebLib::IncludeCSS();
if (NeedsDB) {
  WebLib::CreateDB('RSBY');
}
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
  WebLib::ShowMenuBar('RSBY');
  ?>
  <div class="content">
    <?php

    function ShowFiles($dir) {
      $files = scandir($dir);
      //print_r($files);
      foreach ($files as $key => $file) {
        if (strlen($file) > 4) {
          $Token = md5($dir . $file . session_id() . $_SERVER['REMOTE_ADDR']);
          $rsby[$Token]['DocName'] = $file;
          $rsby[$Token]['Location'] = $dir . $file;
          echo '<h3>Download: <a style="text-decoration:none;" target="_blank" href="Show.php?Token=' . $Token . '">' . $rsby[$Token]['DocName'] . '</a></h3>' . "\n";
        }
        //echo '<li><a style="text-decoration:none;" target="_blank" href="Show.php?Location='.$dir.$file.'&DocName='.substr(substr($file,0,strlen($file)-4),4).'">'.substr(substr($file,0,strlen($file)-4),4).'</a>';
      }
      $_SESSION['rsby'] = $rsby;
    }

    ShowFiles('data/');
    ?>
  </div>
  <div class="pageinfo">
<?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
<?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>
