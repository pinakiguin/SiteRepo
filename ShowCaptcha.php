<?php

// captcha_display.php

require_once 'captcha/securimage.php';

$captchaId = $_GET['captchaId'];

if (empty($captchaId)) {
  die('no id');
}

// database settings must be configured in securimage.php or passed in $options

$options = array('captchaId' => $captchaId);
$captcha = new Securimage($options);

$captcha->show();
exit;
?>