<?php
require_once('../lib.inc.php');

function SetCurrForm($FormName = 'Form 6') {
  Switch ($FormName) {
    case 'Form 6':
      $_SESSION['TableName'] = '`' . MySQL_Pre . 'SRER_Form6`';
      $_SESSION['Fields'] = '`SlNo`, `ReceiptDate`, `AppName`, `RelationshipName`, `Relationship`, `Status`';
      break;
    case 'Form 6A':
      $_SESSION['TableName'] = '`' . MySQL_Pre . 'SRER_Form6A`';
      $_SESSION['Fields'] = '`SlNo`, `ReceiptDate`, `AppName`, `RelationshipName`, `Relationship`, `Status`';
      break;
    case 'Form 7':
      $_SESSION['TableName'] = '`' . MySQL_Pre . 'SRER_Form7`';
      $_SESSION['Fields'] = '`SlNo`, `ReceiptDate`, `ObjectorName`, `PartNo`, `SerialNoInPart`, `DelPersonName`, `ObjectReason`, `Status` ';
      break;
    case 'Form 8':
      $_SESSION['TableName'] = '`' . MySQL_Pre . 'SRER_Form8`';
      $_SESSION['Fields'] = '`SlNo`, `ReceiptDate`, `AppName`, `RelationshipName`, `Relationship`, `Status`';
      break;
    case 'Form 8A':
      $_SESSION['TableName'] = '`' . MySQL_Pre . 'SRER_Form8A`';
      $_SESSION['Fields'] = '`SlNo`, `ReceiptDate`, `AppName`, `RelationshipName`, `Relationship`, `Status`';
      break;
  }
  if (WebLib::GetVal($_POST, 'FormName') != '')
    $_SESSION['FormName'] = WebLib::GetVal($_POST, 'FormName');
}

function GetPartName() {
  if (intval(WebLib::GetVal($_SESSION, 'PartID')) > 0) {
    $Fields = new MySQLiDB();
    $PartName = $Fields->do_max_query('Select CONCAT(PartNo,\' - \',PartName) as PartName from `' . MySQL_Pre . 'SRER_PartMap`'
            . ' Where PartID=' . WebLib::GetVal($_SESSION, 'PartID'));
    $Fields->do_close();
    unset($Fields);
  }
  return ($PartName);
}

function GetColHead($ColName) {
  $Fields = new MySQLiDB();
  $ColHead = $Fields->do_max_query('Select Description from `' . MySQL_Pre . 'SRER_FieldNames`'
          . ' Where FieldName=\'' . $ColName . '\'');
  $Fields->do_close();
  unset($Fields);
  return (!$ColHead ? $ColName : $ColHead);
}

function ShowSRER($QueryString) {
  // Connecting, selecting database
  $Data = new MySQLiDB();
  $TotalRows = $Data->do_sel_query($QueryString);
  $TotalCols = $Data->ColCount;
  // Printing results in HTML
  echo '<table rules="all" frame="box" width="100%" cellpadding="5" cellspacing="1">';
  $i = 0;

  echo 'Total Records: ' . $TotalRows . '<br />';
  while ($i < $TotalCols) {
    echo '<th style="text-align:center;">' . GetColHead($Data->GetFieldName($i)) . '</th>';
    $i++;
  }
  $j = 0;
  while ($line = $Data->get_row()) {
    echo '<tr>';
    foreach ($line as $col_value)
      echo '<td>' . $col_value . '</td>';
    echo '</tr>';
    $j++;
  }
  echo '</table>';
  unset($Data);
  return ($j);
}

function SRERForm($FormName) {
  //$Data = new MySQLiDBHelper(HOST_Name, MySQL_User, MySQL_Pass, MySQL_DB);
  switch ($FormName) {
    case 'SRERForm6I':
    case 'SRERForm6A':
    case 'SRERForm8I':
    case 'SRERForm8A':
      ?>
      <table class="SRERForm">
        <thead>
          <tr>
            <th colspan="2" class="SlNo">Sl No.</th>
            <th class="ReceiptDate">Date of Receipt</th>
            <th class="AppName">Name of Applicant</th>
            <th class="DOB">Date of Birth</th>
            <th class="Sex">Sex</th>
            <th class="RelationshipName">Name of Father/ Mother/ Husband/ Others</th>
            <th class="Relationship">Relationship</th>
            <th class="Status">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 0;
          //@todo SlNo may be replaced by RowID
          while ($i < 10) {
            ?>
            <tr id="RowStat<?php echo $i . '_D'; ?>" class="saved">
              <td class="SlNoChk">
                <input id="<?php echo $FormName . 'RowID' . $i . '_D'; ?>" type="checkbox" />
              </td>
              <td class="SlNoTxt">
                <input type="text" id="<?php echo $FormName . 'SlNo' . $i . '_D'; ?>" class="SlNoTxt"
                       class="SlNo" />
              </td>
              <td>
                <input type="text" id="<?php echo $FormName . 'ReceiptDate' . $i . '_D'; ?>"
                       class="ReceiptDate" placeholder="dd/mm/yyyy" />
              </td>
              <td>
                <input type="text" id="<?php echo $FormName . 'AppName' . $i . '_D'; ?>" />
              </td>
              <td>
                <input type="text" id="<?php echo $FormName . 'DOB' . $i . '_D'; ?>"
                       class="DOB" placeholder="dd/mm/yyyy" />
              </td>
              <td>
                <select id="<?php echo $FormName . 'Sex' . $i . '_D'; ?>">
                  <option value=""></option>
                  <option value="M">Male</option>
                  <option value="F">Female</option>
                  <option value="U">Other</option>
                </select>
              </td>
              <td>
                <input type="text" id="<?php echo $FormName . 'RelationshipName' . $i . '_D'; ?>" />
              </td>
              <td>
                <select id="<?php echo $FormName . 'Relationship' . $i . '_D'; ?>">
                  <option value=""></option>
                  <option value="F">Father</option>
                  <option value="M">Mother</option>
                  <option value="H">Husband</option>
                  <option value="U">Other</option>
                </select>
              </td>
              <td>
                <select id="<?php echo $FormName . 'Status' . $i . '_D'; ?>">
                  <option value="A">Accepted</option>
                  <option value="R">Rejected</option>
                  <option value="P" selected="selected">Pending</option>
                </select>
              </td>
            </tr>
            <?php
            $i++;
          }
          ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="6" style="text-align: left;">
              <span>Show 10 Rows Starting From: </span>
              <input type="text" id="<?php echo $FormName . 'FromRow'; ?>" style="width: 50px;" value="1"/>
              <input type="button" id="<?php echo $FormName . 'CmdEdit'; ?>"  value="Edit"/>
            </td>
            <td colspan="3" style="text-align: right;">
              <input type="button" id="<?php echo $FormName . 'CmdNew'; ?>"  value="New"/>
              <input type="button" id="<?php echo $FormName . 'CmdSave'; ?>" value="Save"/>
              <input type="button" id="<?php echo $FormName . 'CmdDel'; ?>"  value="Delete"/>
            </td>
          </tr>
        </tfoot>
      </table>
      <?php
      break;
    case 'SRER_Form7I':
      break;
  }
}

function EditFormA($QueryString) {
  $RowBreak = 8;
  $Data = new MySQLiDB();
  $TotalRows = $Data->do_sel_query($QueryString);
  // Printing results in HTML
  echo '<form name="frmData" method="post" action="' . htmlspecialchars($_SERVER['PHP_SELF'])
  . '"><table rules="all" frame="box" width="100%" cellpadding="2" cellspacing="1">';
  //Update Table Data
  $col = 1;
  $TotalCols = $Data->ColCount;
  if (WebLib::GetVal($_POST, 'AddNew') == 'New Rows') {
    $i = 0;
    $AddNewDB = new MySQLiDB();
    $MaxSlNo = $AddNewDB->do_max_query('Select max(SlNo)+1 from ' . WebLib::GetVal($_SESSION, 'TableName')
            . ' Where PartID=' . WebLib::GetVal($_SESSION, 'PartID'));
    if ($MaxSlNo == 0)
      $MaxSlNo = 1;
    while ($i < intval(WebLib::GetVal($_POST, 'txtInsRows'))) {
      $Query = 'Insert Into ' . WebLib::GetVal($_SESSION, 'TableName') . ' (`SlNo`,`PartID`) '
              . ' Values(' . $MaxSlNo . ',' . WebLib::GetVal($_SESSION, 'PartID') . ');';
      $AddNewDB->do_ins_query($Query);
      $i++;
      $MaxSlNo++;
      //echo $Query . '<br />';
    }
    $AddNewDB->do_close();
    unset($AddNewDB);
  } elseif (WebLib::GetVal($_POST, 'Delete') == 'Delete') {
    $DelDB = new MySQLiDB();
    for ($i = 0; $i < count(WebLib::GetVal($_POST, 'RowSelected')); $i++) {
      $Query = 'Delete from ' . WebLib::GetVal($_SESSION, 'TableName')
              . ' Where PartID=' . WebLib::GetVal($_SESSION, 'PartID')
              . ' AND SlNo=' . WebLib::GetVal($_POST['RowSelected'], $i);
      $DelDB->do_ins_query($Query);
    }
    $DelDB->do_close();
    unset($DelDB);
  } else {
    if (WebLib::GetVal($_POST, $Data->GetFieldName($col))) {
      $DBUpdt = new MySQLiDB();
      while ($col < $TotalCols) {
        $row = 0;
        while ($row < count($_POST[$Data->GetFieldName($col)])) {
          $Query = 'Update ' . $Data->GetTableName($col)
                  . ' Set ' . $Data->GetFieldName($col) . '=\'' . WebLib::GetVal($_POST[$Data->GetFieldName($col)], $row, TRUE) . '\''
                  . ' Where ' . $Data->GetFieldName(0) . '=' . WebLib::GetVal($_POST[$Data->GetFieldName(0)], $row, TRUE)
                  . ' AND PartID=' . $_SESSION['PartID'] . ' LIMIT 1;';
          $DBUpdt->do_ins_query($Query);
          $row++;
        }
        $col++;
      }
      //echo $Query . '<br />';
      $DBUpdt->do_close();
      unset($DBUpdt);
    }
  }
  $EditRows = $TotalRows - 10;
  if (intval(WebLib::GetVal($_SESSION, 'PartID')) > 0)
    $EditRows = (intval(WebLib::GetVal($_POST, 'SlFrom')) > 0) ? (intval(WebLib::GetVal($_POST, 'SlFrom')) - 1) : $EditRows;
  $QueryString = $QueryString . ' LIMIT ' . (($EditRows > 0) ? $EditRows : 0) . ',10';
  $Data->do_sel_query($QueryString);
  //Print Collumn Names
  $i = 0;
  echo 'Total Records: ' . $TotalRows;
  while ($i < $TotalCols) {
    echo '<th>' . GetColHead($Data->GetFieldName($i)) . '</th>';
    $i++;
    if (($i % $RowBreak) == 0 && $i > 1)
      echo '</tr><tr>';
  }
  $odd = '';
  $RecCount = 0;
  while ($line = $Data->get_row()) {
    $RecCount++;
    $odd = $odd == '' ? 'odd' : '';
    echo '<tr class="' . $odd . '">';
    $i = 0;
    foreach ($line as $col_value) {
      if (($i % $RowBreak) == 0 && $i > 1)
        echo '</tr><tr>';
      echo '<td>';
      if ($i == 0) {
        echo '<input type="checkbox" name="RowSelected[]" value="' . htmlspecialchars($col_value) . '"/>'
        . '<span style="text-align:right;">' . htmlspecialchars($col_value) . '</span>';
      } else {
        echo '<input type="text"';
        echo ' name="' . $Data->GetFieldName($i) . '[]" value="' . htmlspecialchars($col_value) . '" /> </td>';
      }
      $i++;
    }
  }
  echo '<tr><td colspan="' . $TotalCols . '" style="text-align:right;">'
  . '<label for="txtInsRows">Insert:</label>'
  . '<input type="text" name="txtInsRows" size="3" value="' . (WebLib::GetVal($_POST, 'txtInsRows') ? WebLib::GetVal($_POST, 'txtInsRows') : "1") . '"/>'
  . '<input type="hidden" name="ShowBlank" value="' . WebLib::GetVal($_POST, 'ShowBlank') . '" />'
  . '<input type="submit" name="AddNew" value="New Rows" /><input style="width:80px;" type="submit" name="Delete" value="Delete" />';
  echo '&nbsp;&nbsp;&nbsp;<input style="width:80px;" type="submit" value="Save" /></td></tr></table></form>';
}
?>
