<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Departments');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('mpr/css/forms.css');
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
?>
</head>
<body>
  <div class="TopPanel">
    <div class="LeftPanelSide"></div>
    <div class="RightPanelSide"></div>
    <h1><?php echo $_SESSION['UserName']; ?></h1>
  </div>
  <div class="Header"></div>
  <?php
  WebLib::ShowMenuBar('MPR');
  ?>
  <div class="content">
    <div class="formWrapper">
      <form method="post" action="<?php
      echo WebLib::GetVal($_SERVER, 'PHP_SELF');
      ?>" id="frmIAP" >
        <span class="myHeader">MPR Reports</span>
        <hr/>

        <a href="http://localhost/SiteRepo/mpr/SchemeRepot.php">
          <span class="myHeader">1>Scheme Wise Report</span></a><br>
        <a href="http://localhost/SiteRepo/mpr/Chart.php">
          <span class="myHeader">2>Chart Report</span></a>
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
</html><?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

