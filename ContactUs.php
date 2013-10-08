<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/lib.inc.php';
require_once __DIR__ . '/php-mailer/GMail.lib.php';
require_once __DIR__ . '/smsgw/smsgw.inc.php';
session_start();
$_SESSION['BaseDIR'] = '/';
$_SESSION['BaseURL'] = 'https://www.paschimmedinipur.gov.in/';
WebLib::InitHTML5page("Helpline");
WebLib::IncludeCSS();
WebLib::IncludeJS('js/contact.js');
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
  require_once("topmenu.php");
  require_once("leftmenu.php");
  require_once("rightmenu.php");
  ?>
  <div class="content">
    <h2>Contact Us</h2>
    <?php
    $reg = new MySQLiDB();
    if ((!isset($_POST['To'])) || (!isset($_POST['v_name'])) || !WebLib::StaticCaptcha() || (strlen($_POST['feed_txt']) > 1024) || (strlen($_POST['v_name']) > 40) || (strlen($_POST['v_email']) > 40) || (strlen($_POST['To']) < 1)) {
      ?>

      <form name="feed_frm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="text-align:left;">
        <?php
        if (!empty($_POST['To'])) {
          echo "<h3>Error!</h3>";
        }
        ?>
        <b>To:</b><br/>
        <?php
        if (isset($_REQUEST['To'])) {
          $reg->do_sel_query("select ContactID,ContactName,Designation from contacts where ContactID=" . intval($_REQUEST['To']));
          $row = $reg->get_n_row();
          ?>
          <input type="hidden" name="To" value="<?php echo $row[0]; ?>"/>

          <input size="50" type="text" disabled="disabled" value="<?php echo $row[1] . ', ' . $row[2]; ?>" /><br/>
          <?php
        } else {
          echo '<select name="To">';
          $reg->show_sel("ContactID", "AddrTo", "select ContactID,CONCAT(ContactName,' [',Designation,']') as AddrTo from contacts Order by ContactID");
          echo '</select><br/>';
        }
        ?>
        <b>Your Name: </b><br/>
        <input size="50" maxlength="50" type="text" name="v_name" value="<?php echo WebLib::GetVal($_POST, 'v_name'); ?>"/>
        <br/>
        <b>Your E-Mail: </b><br/>
        <input size="50" maxlength="50" type="text" name="v_email" value="<?php echo WebLib::GetVal($_POST, 'v_email'); ?>"/>
        <br/>
        <b>Problem &amp; Suggestions : </b><span id="info" name="info">(Max: 1024 chars)</span><br/>
        <textarea rows="4" cols="60"
                  style="height:200px;margin:0px;"
                  name="feed_txt"
                  onkeyup="limitChars(this, 1024, 'info');" ><?php echo WebLib::GetVal($_POST, 'feed_txt'); ?></textarea>
        <br/><?php WebLib::StaticCaptcha(true); ?>
        <input name="button" type="button" style="width:80px;" onclick="do_submit();" value="Send" />
      </form>
      <fieldset>
        <h3>Queries:</h3>
        <?php
        $Data = new MySQLiDB();
        if (WebLib::GetVal($_REQUEST, 'AdminUpload') == '1')
          $Data->do_sel_query("Select * from feedbacks");
        else
          $Data->do_sel_query("Select * from feedbacks where Topic='C' and approved");
        while ($row = $Data->get_row()) {
          //'<a class="fb" id="ShowFeed'.$row['ID'].'" href="">'.$row['vname'].'</a>, '
          $ReplyTxt = "<p><b>Reply:</b> <i>&ldquo;" . htmlspecialchars($row['ReplyTxt']) . "&rdquo;</i></p>";
          echo '<hr /><b>' . $row['vname'] . '</b> Says: <div class="tdialog-modal" title="Feedback by ' . $row['vname'] . '">'
          . '<p><i>&ldquo;' . $row['feedback'] . '&rdquo;</i></p>'
          . '<small>' . substr($row['details'], 9, strpos($row['details'], 'IST') - 6) . '</small>'
          . $ReplyTxt . '</div>';
        }
        ?>
      </fieldset>
      <?php
    } else {
      $reg->do_sel_query("select EmailID,ContactName from contacts where ContactID=" . intval($_POST['To']));
      $row = $reg->get_n_row();
      $FromEmail = WebLib::GetVal($_POST, 'v_email');
      $FromName = WebLib::GetVal($_POST, 'v_name');
      $email = $row[0]; //'registrar@ugb.ac.in';
      $UserName = $row[1];
      $Subject = 'Message From: ' . $FromName . ' [' . $FromEmail . ']';
      $Body = 'Message: <br/>' . WebLib::GetVal($_POST, 'feed_txt');
      $TxtBody = 'On:' . date("l d F Y g:i:s A ", time() + (15 * 60)) . " IST\r\n" .
              'From: ' . $_SERVER['REMOTE_ADDR'] . ' Using: ' . $_SERVER['HTTP_USER_AGENT'] . "\r\n" .
              'Message:' . "\n\r" . WebLib::GetVal($_POST, 'feed_txt');

//  $headers = 'From: ' . $_POST['v_email'] . "\r\n" .
//          'Bcc: abusalamparvezalam@gmail.com' . "\r\n" .
//          'Reply-To: ' . $_POST['v_email'] . "\r\n" .
//          'X-Mailer: PHP/' . phpversion() . "\r\n";
      //if ($_SERVER['REMOTE_ADDR']!='127.0.0.1')
      //mail($to, $subject, $message, $headers);
      $MailSent = json_decode(GMailSMTP($email, $UserName, $Subject, $Body, $TxtBody, $FromEmail, $FromName));

      echo '<h3>Thankyou for your valuable time and appreciation.</h3>'; //.$message;

      $nm = mysql_real_escape_string($_POST['v_name']);
      $email = " | " . mysql_real_escape_string($_POST['v_email']);
      $fd = mysql_real_escape_string($_POST['feed_txt']);
      if (($MailSent->Sent) && (strlen($_POST['feed_txt']) <= 1024 && strlen($_POST['v_email']) <= 50 && strlen($_POST['v_name']) <= 50))
        $reg->do_ins_query("insert into feedbacks(ToOfficer,ip,vname,vemail,feedback,details,Topic) values('" . $row[0] . "','" . $_SERVER['REMOTE_ADDR'] . "','" . $nm . "','" . $email . "','" . $fd . "','<Contact:" . date("l d F Y g:i:s A ", time() + (15 * 60))
                . " IST\r\n" . $_SERVER["HTTP_USER_AGENT"] . ">','C')");
      else
        echo "<h3>Unable to send request.</h3>";
    }
    ?>
  </div>
  <?php
  require_once("bottommenu.php");
  ?>
  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>
