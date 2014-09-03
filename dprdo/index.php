<?php
//ini_set('display_errors', '1');
//error_reporting(E_ALL);
require_once __DIR__ . '/../lib.inc.php';

WebLib::SetPATH(15);
WebLib::InitHTML5page('Admit Card');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('css/forms.css');
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
?>
<script type="text/javascript">
  $(function () {
    $(".chzn").chosen({width: "200px",
      no_results_text: "Oops, nothing found!"
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
<div class="MenuBar">
  <ul>
    <?php
    echo WebLib::ShowMenuitem('Home', '../');
    echo WebLib::ShowMenuitem('Helpline', '../ContactUs.php');
    ?>
  </ul>
</div>
<div class="content">
  <div class="formWrapper-Autofit">
    <h3 class="formWrapper-h3">Download Admit</h3>
    <?php
    if (isset($_POST['BtnSrch']) == 1) {
      require_once __DIR__ . '/../lib.inc.php';
      $DB    = new MySQLiDBHelper();
      $desn  = $_POST['txtDesignation'];
      $cname = $_POST['txtName'];
      $name  = preg_replace('/[^A-Za-z\s]/', '', $cname);
      $n     = strlen($name);
      if ($n >= 8) {
        $s     = $DB->rawQuery("select * from " . MySQL_Pre . "DPRDO_Admit where Designation=? and Name Like '%$name%'", array($desn));
        $count = count($s);
        if ($count > 0) {
          ?>
          <table border="1">
            <tr>
              <th>Roll No</th>
              <th>Name</th>
              <th>Designation</th>
              <th>GP/PS</th>
              <th>Action</th>
            </tr>
            <?php foreach ($s as $r) { ?>
              <tr>
                <td><?php echo $r['RollNo'] ?></td>
                <td><?php echo $r['Name'] ?></td>
                <td><?php echo $r['Designation'] ?></td>
                <td><?php echo $r['GP'] ?></td>
                <td><a href="show.php?id=<?php echo $r['RollNo'] ?>">Print Admit</a></td>
              </tr>
            <?php } ?>
          </table>
          <br/><hr/>
        <?php
        }else{
          $_SESSION['Msg'] = 'Your Name:'.$name.' is not found.';
        }
      } else {
        $_SESSION['Msg'] = 'Enter At least 8 Characters';
      }
    }
    WebLib::ShowMsg();
    $DB = new MySQLiDBHelper();
    $d = $DB->rawQuery("select Designation from " . MySQL_Pre . "DPRDO_Admit group by Designation");
    ?>
    <form method="post" action="<?php echo WebLib::GetVal($_SERVER,'PHP_SELF'); ?>">
      <div class="FieldGroup">
        <label for="txtName"><strong>Designation:</strong></label><br/>
        <div style="padding: 10px;">
          <select name="txtDesignation" class="chzn">
            <option value=""></option>
            <?php foreach ($d as $des) {
              echo '<option value="' . $des['Designation'] . '">' . $des['Designation'] . '</option>';
            } ?>
          </select>
        </div>
      </div>
      <br/>

      <div class="FieldGroup">
        <label for="txtName"><strong>Name of the Candidate:</strong></label>
        <input id="txtName" type="text" name="txtName" class="form-TxtInput">
      </div>
      <div style="clear: both;"></div>
      <hr/>
      <div class="formControl">
        <input type="submit" VALUE="Search" name="BtnSrch">
      </div>
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
