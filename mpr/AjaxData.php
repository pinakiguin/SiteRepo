<?php
require_once __DIR__ . '/../lib.inc.php';
WebLib::AuthSession();
switch (WebLib::GetVal($_POST, 'CallAPI')) {

  case 'Users_GetUserData':
    $DB = new MySQLiDBHelper();
    $DB->where('CtrlMapID', $_SESSION['UserMapID']);
    WebLib::ShowTable($DB->query('Select `UserName` AS `Scheme Users`'
      . 'from ' . MySQL_Pre . 'MPR_MappedUsers'));
    unset($DB);
    break;

  case 'Schemes_GetSchemeTable':
    $DB = new MySQLiDBHelper();
    $DB->where('UserMapID', $_SESSION['UserMapID']);
    $DB->where('SchemeID', WebLib::GetVal($_POST, 'Scheme'));
    WebLib::ShowTable($DB->query('Select Year, SchemeName, Amount, OrderNo, '
      . 'Date as `Order Date(YYYY-MM-DD)` '
      . 'from ' . MySQL_Pre . 'MPR_UserSchemeAllotments'));
    unset($DB);
    break;

  case 'Reports_GetSchemeFunds':
    $DB = new MySQLiDBHelper();
    $DB->where('SchemeID', WebLib::GetVal($_POST, 'Scheme'));
    WebLib::ShowTable($DB->query('Select `Year`,`SchemeName`,`Funds`,`Expense`,`Balance` '
      . ' '
      . 'from ' . MySQL_Pre . 'MPR_SchemeWiseFunds'));
    unset($DB);
    break;

  case 'Reports_GetWorkFunds':
    $DB = new MySQLiDBHelper();
    $DB->where('SchemeID', WebLib::GetVal($_POST, 'Scheme'));
    $DB->where('CtrlMapID', $_SESSION['UserMapID']);
    $DB->where('UserMapID', WebLib::GetVal($_POST, 'User'));
    WebLib::ShowTable($DB->query('Select `SchemeName`,`Work`,`Allotments`,`Expenditure`,`Balance` '
      . ' '
      . 'from ' . MySQL_Pre . 'MPR_UserWorks'));
    unset($DB);
    break;

  case 'Works_GetWorks':
    ?>
    <div class="formWrapper-Autofit">
      <h3 class="formWrapper-h3">Sanctioned Works</h3>
      <table rules="all" frame="box" width="100%" cellpadding="5" cellspacing="2">
        <tr>
          <th>Description of Work</th>
          <th>Estimated Cost(Rs.)</th>
          <th>Fund Released(Rs.)</th>
          <th>Till Dated(YYYY-MM-DD)</th>
          <th>Fund Utilised(Rs.)</th>
          <th>Balance(Rs.)</th>
          <th>Action</th>
        </tr>
        <?php
        $DB = new MySQLiDBHelper();
        $DB->where('CtrlMapID', $_SESSION['UserMapID']);
        $DB->where('MprMapID', WebLib::GetVal($_POST, 'User'));
        $Users = $DB->get(MySQL_Pre . 'MPR_MappedUsers');

        if (count($Users) > 0) {
          $DB->where('UserMapID', $Users[0]['UserMapID']);
        }
        $DB->where('CtrlMapID', $_SESSION['UserMapID']);
        $DB->where('SchemeID', WebLib::GetVal($_POST, 'Scheme'));
        $UserWorks = $DB->get(MySQL_Pre . 'MPR_UserWorks');
        foreach ($UserWorks as $Work) {
          ?>
          <tr>
            <td><?php echo $Work['Work'] ?></td>
            <td><?php echo $Work['EstimatedCost'] ?></td>
            <td><?php echo $Work['Allotments'] ?></td>
            <td><?php echo $Work['AsOnDate'] ?></td>
            <td><?php echo $Work['Expenditure'] ?></td>
            <td><?php echo $Work['Balance'] ?></td>
            <td><a href="savesessionwork.php?wid=<?php echo $Work['WorkID'] ?>">Release More Funds</a></td>
          </tr>
        <?php
        } ?>
      </table>
    </div>
    <?php
    break;
}
?>
