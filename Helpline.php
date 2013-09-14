<?php
//require_once('functions.php');
require_once(__DIR__ . '/lib.inc.php');
WebLib::AuthSession();
WebLib::Html5Header("Helpline");
WebLib::IncludeCSS();
WebLib::JQueryInclude();
?>
<script>
  $(function() {
    $("#HelpLineNotes").accordion({
      heightStyle: "content",
      collapsible: true
    });
  });
  function limitChars(textarea, limit, infodiv)
  {
    var text = textarea.value;
    var textlength = text.length;
    var info = document.getElementById(infodiv);
    if (textlength > limit)
    {
      info.innerHTML = ' (You cannot write more then ' + limit + ' characters!)';
      textarea.value = text.substr(0, limit);
      return false;
    }
    else
    {
      info.innerHTML = ' (You have ' + (limit - textlength) + ' characters left.)';
      return true;
    }
  }
  function do_submit() {
    var fd_txt = document.feed_frm.feed_txt.value;
    if (fd_txt.length === 0)
    {
      window.alert("Please write your comment!");
    }
    else
      document.feed_frm.submit();
  }

</script>
</head>
<body>
  <div class="TopPanel">
    <div class="LeftPanelSide"></div>
    <div class="RightPanelSide"></div>
    <h1><?php echo AppTitle; ?></h1>
  </div>
  <div class="Header"></div>
  <?php
  WebLib::ShowMenuBar('WebSite');
  ?>
  <div class="content">
    <?php
    if (WebLib::GetVal($_GET, 'Reply') !== NULL) {
      require_once 'Reply.php';
    } else {
      ?>
      <h2>Helpline</h2>
      <?php
      if ((WebLib::GetVal($_POST, 'SendQry') === "Send Us Your Query") || (WebLib::GetVal($_SESSION, 'SendQry') === '1')) {
        $_SESSION['SendQry'] = '1';
        require_once 'contact.php';
      } else {
        $Data = new MySQLiDB();
        $UnReplied = $Data->do_max_query("Select count(*) from " . MySQL_Pre . "Helpline where Replied=0");
        ?>
        <form method="post">
          <div class="FieldGroup">
            <b>Read the Frequently Asked Questions Carefully and then:</b><input name="SendQry" type="submit" value="Send Us Your Query" /><br/>
            <span class="Message"><b>Number of queries to be replied:</b>
              <a href="?Reply=1" style="color: #99CC33;"><?php echo $UnReplied; ?></a></span>
          </div>
        </form>
        <div style="clear:both;"></div>
        <br/>
        <h2>Frequently Asked Questions:</h2>
        <?php
        $Data->do_sel_query('Select * from `' . MySQL_Pre . 'Helpline` `H` JOIN `' . MySQL_Pre . 'Users` `U`'
                . ' ON (`H`.UserMapID=`U`.UserMapID) Where Replied=1 order by ReplyTime DESC,HelpID desc');
        if ($Data->RowCount > 0)
          echo '<div id="HelpLineNotes">';
        while ($row = $Data->get_row()) {
          ?>
          <h3>
            <?php
            echo '[' . $row['HelpID'] . '] ' . htmlspecialchars($row['UserName'])
            . " [Replied On: " . date("l d F Y g:i:s A ", strtotime($row['ReplyTime'])) . ']';
            ?>
          </h3>
          <div>
            <?php echo str_replace("\r\n", "<br />", $row['TxtQry']); ?><br/>
            <small><i>
                <?php
                echo "From IP: {$row['IP']} On: " . date("l d F Y g:i:s A ", strtotime($row['QryTime']));
                ?>
              </i>
            </small>
            <br/><br/>
            <b>Reply:</b><p><i>&ldquo;<?php echo str_replace("\r\n", "<br />", $row['ReplyTxt']); ?>&rdquo;</i></p>
          </div>
          <?php
        }
        if ($Data->RowCount > 0)
          echo '</div>';
        ?>
        <div style="clear:both;"></div>
        <?php
      }
    }
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
