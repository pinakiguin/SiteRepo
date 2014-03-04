<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Mid Day Meal');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('MDM/css/forms.css');
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
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
        $db                    = mysql_connect("localhost", "root", "mysql");
        mysql_select_db("WebSite", $db);
        $query                 = "SELECT * FROM WebSite_MDM_SMS";
        $result                = mysql_query($query);
        while ($row                   = mysql_fetch_array($result)) {
          print_r($row);
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

