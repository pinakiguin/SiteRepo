<?php
ini_set('display_errors', 'On');
require_once __DIR__ . '/../lib.inc.php';
require_once __DIR__ . '/../class.MySQLiDBHelper.php';
WebLib::AuthSession();
WebLib::Html5Header('Website Uploads');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
?>
<style type="text/css" media="all" >
  .ui-autocomplete-loading { background: white url('ui-anim_basic_16x16.gif') right center no-repeat; }
</style>
<script>
  $(function() {
    $(".datepick").datepicker({
      dateFormat: 'yy-mm-dd',
      showOtherMonths: true,
      selectOtherMonths: true,
      showButtonPanel: true,
      showAnim: "slideDown"
    });
    $("#Dept").autocomplete({
      source: "query.php",
      minLength: 3,
      select: function(event, ui) {
        $('#Dept').val(ui.item.value);
      }
    });
  });
</script>
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
  WebLib::ShowMenuBar('WebSite');
  ?>
  <div class="content">
    <h2>Website Uploads</h2>
    <Form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?AdminUpload" method="post" >
      <b>Department: </b><br/>
      <input style="width:400px;" type="text" name="Dept" id="Dept"/>
      <select name="Topic">
        <option value="0">Tender</option>
        <option value="1">Recruitment</option>
        <option value="4">Notice Board</option>
      </select>
      <br/>
      <b>Dated: </b>(YYYY-MM-DD)
      <input style="width:100px;" type="text" name="Dated" class="datepick" size="10" />
      <b>Expiry: </b>(YYYY-MM-DD)
      <input style="width:100px;" type="text" name="Expiry" class="datepick"  size="10" />
      <br/>
      <b>Subject: </b><br/>
      <input name="Subject" type="text" size="150" style="width:600px;"/>
      <br />
      <b>Attachment: </b><br/>
      <input style="width:600px;" type="file" name="attachment"/>
      <input type="hidden" name="MAX_FILE_SIZE" value="9000000" />
      <input type="Submit" style="width:100px;" value="Upload" />
    </form>
    <?php
    if (isset($_FILES['attachment']['name']) && ($_FILES['attachment']['error'] === 0) && !empty($_FILES['attachment']['name'])) {
      $reg = new MySQLiDBHelper(HOST_Name, MySQL_User, MySQL_Pass, MySQL_DB);

      $UploadData['Dept'] = WebLib::GetVal($_POST, 'Dept');
      $UploadData['Subject'] = WebLib::GetVal($_POST, 'Subject');
      $UploadData['Topic'] = WebLib::GetVal($_POST, 'Topic');
      $UploadData['Dated'] = WebLib::GetVal($_POST, 'Dated');
      $UploadData['Expiry'] = WebLib::GetVal($_POST, 'Expiry');
      $UploadData['UserMapID'] = $_SESSION['UserMapID'];

      $UploadData['Attachment'] = $_FILES['attachment']['name'];
      $UploadData['mime'] = $_FILES['attachment']['type'];
      $UploadData['size'] = $_FILES['attachment']['size'];
      $UploadData['file'] = file_get_contents($_FILES['attachment']['tmp_name']);

      if ($reg->insert(MySQL_Pre . 'Uploads', $UploadData)) {
        echo '<h3 style="color:#228b22;">Suuccessfully uploaded!</h3>';
      } else {
        echo '<h3 style="color:#ff0000;">Unable to upload!</h3>';
      }
    }
    include ('notice.php');
    ?>
    <div style="clear:both;"></div>
  </div>
  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>