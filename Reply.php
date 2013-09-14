<?php
if (!defined('LifeTime')) {
  exit();
}
?>

<h2>Reply Queries:</h2>
<?php
WebLib::ShowMsg();
$Data = new MySQLiDB();
if ($_REQUEST['Reply'] == '1') {
  ?>
  <form name="frmLogin" method="post"
        action="<?php $_SERVER['PHP_SELF'] ?>">
    <label for="ReplyTo">To:</label> <select name="ReplyTo">
      <?php
      $Query = 'SELECT HelpID,CONCAT(\'[\',Replied,\'] \',UserName) as `AppName` '
              . ' FROM `' . MySQL_Pre . 'Helpline` `H` JOIN `' . MySQL_Pre . 'Users` `U`'
              . ' ON (`H`.UserMapID=`U`.UserMapID) order by Replied,HelpID desc';
      $Data->show_sel('HelpID', 'AppName', $Query, $_POST['ReplyTo']);
      ?>
    </select> <b>Show in FAQ:</b><input type="radio" id="ShowFAQ"
                                        name="ShowFAQ" value="1" /><label for="ShowFAQ">Yes</label> <input
                                        type="radio" id="ShowFAQ" name="ShowFAQ" value="2" /><label
                                        for="ShowFAQ">No</label><br /> <label for="ReplyTxt">Reply:</label><br />
    <textarea id="ReplyTxt" name="ReplyTxt" rows="4" cols="80"
              maxlength="300"></textarea>
    <input style="width: 80px;" type="submit" value="Reply" />
  </form>
  <?php
  if (isset($_POST['ReplyTo']) && ($_POST['ReplyTo'] != "") && ($_POST['ReplyTxt'] != "")) {
    $Query = "Update " . MySQL_Pre . "Helpline set Replied=" . intval($_POST['ShowFAQ']) . ", ReplyTxt='"
            . $Data->SqlSafe($_POST['ReplyTxt']) . "',ReplyTime=CURRENT_TIMESTAMP Where HelpID=" . $Data->SqlSafe($_POST['ReplyTo']);
    $Data->do_ins_query($Query);
  }
  $Data->do_sel_query('Select * from `' . MySQL_Pre . 'Helpline`  `H` JOIN `' . MySQL_Pre . 'Users` `U`'
          . ' ON (`H`.UserMapID=`U`.UserMapID) Where Replied!=1 Order by Replied,HelpID DESC');
}
else
  $Data->do_sel_query('Select * from `' . MySQL_Pre . 'Helpline`  `H` JOIN `' . MySQL_Pre . 'Users` `U`'
          . ' ON (`H`.UserMapID=`U`.UserMapID) Where Replied<2 Order by HelpID DESC');

while ($row = $Data->get_row()) {
  ?>
  <div class="Notice">
    <b><?php echo htmlspecialchars($row['UserName']); ?>:</b><br />
    <?php echo str_replace("\r\n", "<br />", $row['TxtQry']); ?>
    <br /> <small><i><?php echo "From IP: {$row['IP']} On: " . date("l d F Y g:i:s A ", strtotime($row['QryTime'])); ?>
      </i> </small><br/><br/>
    <b>Reply[<?php echo $row['Replied']; ?>]:</b>
    <p>
      <i>&ldquo;<?php echo str_replace("\r\n", "<br />", $row['ReplyTxt']); ?>&rdquo;
      </i>
    </p>
    <small><i><?php echo "[" . $row['UserID'] . "] Replied On: " . date("l d F Y g:i:s A", strtotime($row['ReplyTime'])); ?></i></small>
  </div>
  <?php
}
?>

