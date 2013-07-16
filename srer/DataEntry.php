<?php
/**
 * @todo Cache based Selection of AC and Part
 * @todo Form Selection using jQuery UI Tabs
 */
require_once('srer.lib.php');

WebLib::AuthSession();
WebLib::Html5Header("Data Entry");
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('css/chosen.min.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
$Data = new MySQLiDB();
SetCurrForm();
if (WebLib::GetVal($_SESSION, 'ACNo') == "")
  $_SESSION['ACNo'] = "-- Choose --";
if (WebLib::GetVal($_SESSION, 'PartID') == "")
  $_SESSION['PartID'] = "-- Choose --";
if (intval(WebLib::GetVal($_POST, 'PartID')) > 0)
  $_SESSION['PartID'] = intval(WebLib::GetVal($_POST, 'PartID'));
if (WebLib::GetVal($_POST, 'ACNo') != "")
  $_SESSION['ACNo'] = WebLib::GetVal($_POST, 'ACNo');
if (intval(WebLib::GetVal($_REQUEST, 'ID')) > 0)
  $_SESSION['UserMapID'] = intval($_REQUEST['ID']);
?>
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
<style type="test/css">
  .TxtInput{
    border: 1px solid darkgray;
    width: 95%;
    margin: 0px;
  }
  .TxtInput:hover{
    border: 1px solid #fbd850;
  }
  .TxtInput:focus{
    border: 1px solid #1c94c4;
  }
  input{
    padding: 4px;
  }
  input[readonly="readonly"]{
    border: none;
    background-color: transparent;
  }
  input[type="text"] {
    width: 100%;
    box-sizing: border-box;
    -webkit-box-sizing:border-box;
    -moz-box-sizing: border-box;
  }
  th,td{
    text-align: center;
  }
</style>
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
  WebLib::ShowMenuBar()
  ?>
  <div class="content">
    <h2><?php echo AppTitle; ?></h2>
    <hr/>
    <form name="frmSRER" method="post" action="<?php echo WebLib::GetVal($_SERVER, 'PHP_SELF'); ?>">
      <div class="FieldGroup">
        <label for="textfield">AC No.:</label><br/>
        <select name="ACNo" id="ACNo" onChange="document.frmSRER.submit();">
          <?php
          $Query = 'Select AC_NO,CONCAT(AC_NO,\' - \',AC_NAME) as AC_NAME from `' . MySQL_Pre . 'SRER_ACs`'
                  . ' Where PartMapID=' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE);
          $Data->show_sel('AC_NO', 'AC_NAME', $Query, WebLib::GetVal($_SESSION, 'ACNo', TRUE));
          ?>
        </select>
        <?php //echo $Query; ?>
      </div>
      <div class="FieldGroup">
        <label for="textfield">Part No.:</label><br/>
        <select name="PartID" id="PartID" onChange="document.frmSRER.submit();">
          <?php
          $Choice = (WebLib::GetVal($_SESSION, 'PartID') === "") ? '--Choose--' : WebLib::GetVal($_SESSION, 'PartID');
          $Query = 'Select PartID,CONCAT(PartNo,\' - \',PartName) as PartName from `' . MySQL_Pre . 'SRER_PartMap` '
                  . ' Where ACNo=\'' . WebLib::GetVal($_SESSION, 'ACNo') . '\' and PartMapID=' . WebLib::GetVal($_SESSION, 'UserMapID') . ' group by PartNo';
          $RowCount = $Data->show_sel('PartID', 'PartName', $Query, $Choice);
          ?>
        </select>
      </div>
    </form>
    <div style="clear:both;"></div>
    <hr />
    <?php
    if ((intval(WebLib::GetVal($_SESSION, 'PartID')) > 0) && (WebLib::GetVal($_SESSION, 'TableName') != "")) {
      $RowCount = $Data->do_max_query("Select count(*) from " . WebLib::GetVal($_SESSION, 'TableName') . " Where PartID=" . WebLib::GetVal($_SESSION, 'PartID'));
      $RowCount = $RowCount - 9;
      if ($RowCount < 1)
        $RowCount = 1;
    }

    if (intval(WebLib::GetVal($_SESSION, 'PartID')) > 0) {
      $PartName = GetPartName();
      echo '<h3>Selected Part[' . $PartName . '] '
      . WebLib::GetVal($_SESSION, 'FormName') . '</h3>';
      ?>
      <div id="SRER_Forms">
        <ul>
          <li><a href="#SRER_Form6">Form 6</a></li>
          <li><a href="#SRER_Form6A">Form 6A</a></li>
          <li><a href="#SRER_Form7">Form 7</a></li>
          <li><a href="#SRER_Form8">Form 8</a></li>
          <li><a href="#SRER_Form8A">Form 8A</a></li>
        </ul>
        <div id="SRER_Form6">

        </div>
        <div id="SRER_Form6A">

        </div>
        <div id="SRER_Form7">

        </div>
        <div id="SRER_Form8">

        </div>
        <div id="SRER_Form8A">

        </div>
        <?php
      }
      $CondBlank = "";
      if (WebLib::GetVal($_SESSION, 'TableName') !== NULL) {
        if (WebLib::GetVal($_POST, 'ShowBlank') == "1") {
          $FieldNames = explode(', ', WebLib::GetVal($_SESSION, 'Fields'));
          $CondBlank = " AND (";
          for ($i = 1; $i < count($FieldNames); $i++) {
            $CondBlank = $CondBlank . $FieldNames[$i] . "='' OR " . $FieldNames[$i] . " IS NULL) AND (";
          }
          $CondBlank = $CondBlank . "1 )";
        }
        $Query = 'Select ' . WebLib::GetVal($_SESSION, 'Fields') . ' from ' . WebLib::GetVal($_SESSION, 'TableName')
                . ' Where PartID=' . WebLib::GetVal($_SESSION, 'PartID');
        $Query = $Query . $CondBlank;

        //echo $Query;

        EditForm($Query);
      }
      ?>
    </div>
    <script type="text/javascript">
  $('#ACNo').chosen({width: "300px"});
  $('#PartID').chosen({width: "400px"});
  $(function() {
    $("#SRER_Forms").tabs();
  });
    </script>
  </div>
  <div class="pageinfo"><?php WebLib::PageInfo(); ?></div>
  <div class="footer"><?php WebLib::FooterInfo(); ?></div>
</body>
</html>
