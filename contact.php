<?php
if (!defined('LifeTime')) {
  exit();
}
//require_once('functions.php');

$fd = WebLib::GetVal($_POST, 'feed_txt', true);

if ((strlen($fd) > 1024) || ($fd === '')) {
  ?>
  <form name="feed_frm" method="post"
        action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="text-align: left;">
    <b>Problem: </b><span id="info">(Max: 1024 chars)</span><br />
    <textarea rows="4" cols="60" style="height: 200px; margin: 0px;"
              name="feed_txt" onkeyup="limitChars(this, 1024, 'info')"><?php echo $fd; ?></textarea>
    <input name="button" type="button" style="width: 80px;" onclick="do_submit()" value="Send" />
  </form>
  <?php
} else {
  echo '<h3>Thankyou for your valuable time and appreciation.</h3>'; //.$message;
  $Data = new MySQLiDB();
  $HelpQry = 'Insert into ' . MySQL_Pre . 'Helpline(IP,SessionID,UserMapID,TxtQry) '
          . 'Values(\'' . $_SERVER['REMOTE_ADDR'] . '\',\'' . session_id()
          . '\',\'' . $_SESSION['UserMapID'] . '\',\'' . $fd . '\')';
  $Submitted = $Data->do_ins_query($HelpQry);
  if ($Submitted > 0)
    $_SESSION['SendQry'] = "0";
  else
    echo "<h3>Unable to send request.</h3>";
}
?>
