<?php
require_once('../lib.inc.php');
require_once '../class.MySQLiDBHelper.php';

WebLib::AuthSession();
WebLib::Html5Header("Randomization");
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('cp/css/GroupCP.css');
WebLib::IncludeJS('cp/js/GroupCP.js');
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
WebLib::IncludeJS('js/jquery.validate.min.js');
WebLib::IncludeJS('js/additional-methods.min.js');
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
  WebLib::ShowMenuBar('CP');

  function PrintArr($Arr) {
    echo '<pre>';
    print_r($Arr);
    echo '</pre>';
  }

  function MakeGroupCP($CountingTables, $Post) {
    $Data = new MySQLiDBHelper(HOST_Name, MySQL_User, MySQL_Pass, MySQL_DB);
    foreach ($CountingTables as $Block) {
      $CP_PoolQry = 'Select PersSL from ' . MySQL_Pre . 'CP_Pool';
      $Data->where('AssemblyCode', $Block['Assembly']);
      $Data->where('`Post`', $Post);
      $GroupCP = $Data->query($CP_PoolQry);
      shuffle($GroupCP);
      $GroupID = 1;
      $Reserve = '';
      foreach ($GroupCP as $PersCP) {
        if (($GroupID > $Block['Tables']) && (((count($GroupCP) / 2) < $GroupID) || ($Post === 1))) {
          $Reserve = 'R';
        } else {
          break;
        }
        $RandCP['PersSL'] = $PersCP['PersSL'];
        $RandCP['GroupID'] = $Reserve . $GroupID;
        $RandCP['AssemblyCode'] = $Block['Assembly'];
        $Data->insert(MySQL_Pre . 'CP_Groups', $RandCP);
        $GroupID++;
      }
    }
  }
  ?>
  <div class="content">
    <span class="Message" id="Msg" style="float: right;">
      <b>Loading please wait...</b>
    </span>
    <input type="hidden" id="AjaxToken"
           value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
    <h2>Counting Personnel Randomization</h2>
    <table id="GroupCP">
      <thead>
        <tr>
          <th>Assembly Name</th>
          <th>Assembly Code</th>
          <th>Tables</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody id="DetailCP">
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4">
            <input id="GetRequiredCP" type="button" value="Load Requirements"/>
            <input id="MakeGroupCP" type="button" value="Start Randomization"/>
          </td>
        </tr>
      </tfoot>
    </table>
    <pre id="Error"></pre>
  </div>
  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>
