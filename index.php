<?php
include_once 'lib.inc.php';

if (NeedsDB)
  CreateDB("WebSite");

initHTML5page("Home");
IncludeCSS();
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
  ShowMenuBar();
  ?>
  <div class="content">
    <?php
    require_once 'captcha/securimage.php';

    $captchaId = Securimage::getCaptchaId(true);
    $captcha_code = GetVal($_POST, 'captcha_code');
    $options = array();

    if ($captcha_code !== NULL) {
      $captchaId = GetVal($_POST, 'captchaId');
      if (Securimage::checkByCaptchaId($captchaId, $captcha_code, $options) == true) {
        $_SESSION['Msg'] = "Result: Valid Captcha Code.";
      } else {
        // input was invalid for supplied captcha id
        $_SESSION['Msg'] = "Result: In-Valid Captcha Code.";
      }
    }

    ShowMsg();
    ?>
    <form method="post" action="index.php">
      <input type="hidden" id="captchaId" name="captchaId" value="<?php echo $captchaId ?>" />
      <img id="siimage" src="ShowCaptcha.php?captchaId=<?php echo $captchaId ?>" alt="captcha image" />
      <input type="text" name="captcha_code" value="" />
    </form>

  </div>
  <div class="pageinfo">
    <?php pageinfo(); ?>
  </div>
  <div class="footer">
    <?php footerinfo(); ?>
  </div>
</body>
</html>
