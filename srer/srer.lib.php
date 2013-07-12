<?php

require_once('../lib.inc.php');

function SetCurrForm() {
  Switch (Getval($_POST, 'FormName')) {
    case 'Form 6':
      $_SESSION['TableName'] = "SRER_Form6";
      $_SESSION['Fields'] = "`SlNo`, `ReceiptDate`, `AppName`, `RelationshipName`, `Relationship`, `Status`";
      break;
    case 'Form 6A':
      $_SESSION['TableName'] = "SRER_Form6A";
      $_SESSION['Fields'] = "`SlNo`, `ReceiptDate`, `AppName`, `RelationshipName`, `Relationship`, `Status`";
      break;
    case 'Form 7':
      $_SESSION['TableName'] = "SRER_Form7";
      $_SESSION['Fields'] = "`SlNo`, `ReceiptDate`, `ObjectorName`, `PartNo`, `SerialNoInPart`, `DelPersonName`, `ObjectReason`, `Status` ";
      break;
    case 'Form 8':
      $_SESSION['TableName'] = "SRER_Form8";
      $_SESSION['Fields'] = "`SlNo`, `ReceiptDate`, `AppName`, `RelationshipName`, `Relationship`, `Status`";
      break;
    case 'Form 8A':
      $_SESSION['TableName'] = "SRER_Form8A";
      $_SESSION['Fields'] = "`SlNo`, `ReceiptDate`, `AppName`, `RelationshipName`, `Relationship`, `Status`";
      break;
  }
  if (Getval($_POST, 'FormName') != "")
    $_SESSION['FormName'] = GetVal($_POST, 'FormName');
}

function GetPartName() {
  if (intval(GetVal($_SESSION, 'PartID')) > 0) {
    $Fields = new MySQLiDB();
    $PartName = $Fields->do_max_query("Select CONCAT(PartNo,'-',PartName) as PartName from SRER_PartMap where PartID=" . GetVal($_SESSION, 'PartID'));
    $Fields->do_close();
    unset($Fields);
  }
  return ($PartName);
}

function GetColHead($ColName) {
  $Fields = new MySQLiDB();
  $ColHead = $Fields->do_max_query("Select Description from SRER_FieldNames where FieldName='{$ColName}'");
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

  echo "Total Records: {$TotalRows}<br />";
  while ($i < $TotalCols) {
    echo '<th style="text-align:center;">' . GetColHead($Data->GetFieldName($i)) . '</th>';
    $i++;
  }
  $j = 0;
  while ($line = $Data->get_row()) {
    echo "\t<tr>\n";
    foreach ($line as $col_value)
      echo "\t\t<td>" . $col_value . "</td>\n";
    //$strdt=date("F j, Y, g:i:s a",$ntime);
    //echo "\t\t<td>$strdt</td>\n";
    echo "\t</tr>\n";
    $j++;
  }
  echo "</table>\n";
  unset($Data);
  return ($j);
}

function EditForm($QueryString) {
  $RowBreak = 8;
  $Data = new MySQLiDB();
  $TotalRows = $Data->do_sel_query($QueryString);
  // Printing results in HTML
  echo '<form name="frmData" method="post" action="' . htmlspecialchars($_SERVER['PHP_SELF'])
  . '"><table rules="all" frame="box" width="100%" cellpadding="5" cellspacing="1">';
  //Update Table Data
  $col = 1;
  $TotalCols = $Data->ColCount;
  if (GetVal($_POST, 'AddNew') == "New Rows") {
    $i = 0;
    $AddNewDB = new MySQLiDB();
    $MaxSlNo = $AddNewDB->do_max_query("Select max(SlNo)+1 from " . GetVal($_SESSION, 'TableName') . " Where PartID=" . GetVal($_SESSION, 'PartID'));
    if ($MaxSlNo == 0)
      $MaxSlNo = 1;
    while ($i < intval(GetVal($_POST, 'txtInsRows'))) {
      $Query = "Insert Into " . GetVal($_SESSION, 'TableName') . "(`SlNo`,`PartID`) values({$MaxSlNo}," . GetVal($_SESSION, 'PartID') . ");";
      $AddNewDB->do_ins_query($Query);
      $i++;
      $MaxSlNo++;
      //echo $Query."<br />";
    }
    $AddNewDB->do_close();
    unset($AddNewDB);
  } elseif (GetVal($_POST, 'Delete') == "Delete") {
    $DelDB = new MySQLiDB();
    $DelDB->do_max_query("Select 1");
    for ($i = 0; $i < count(GetVal($_POST, 'RowSelected')); $i++) {
      $Query = "Delete from " . GetVal($_SESSION, 'TableName') . " Where PartID=" . GetVal($_SESSION, 'PartID') . " AND SlNo=" . GetVal($_POST['RowSelected'], $i);
      $DelDB->do_ins_query($Query);
    }
    $DelDB->do_close();
    unset($DelDB);
  } else {
    if (GetVal($_POST, $Data->GetFieldName($col))) {
      $DBUpdt = new MySQLiDB();
      while ($col < $TotalCols) {
        $row = 0;
        //echo $row.",".$col."--".$Data->GetFieldName($col)."--".$Data->GetTableName($col)
        //	.GetVal($_POST,$Data->GetFieldName($col))[$row];
        while ($row < count($_POST[$Data->GetFieldName($col)])) {
          $Query = "Update " . $Data->GetTableName($col)
                  . " Set " . $Data->GetFieldName($col) . "='" . $DBUpdt->SqlSafe($_POST[$Data->GetFieldName($col)][$row]) . "'"
                  . " Where " . $Data->GetFieldName(0) . "=" . $DBUpdt->SqlSafe($_POST[$Data->GetFieldName(0)][$row]) . " AND PartID=" . $_SESSION['PartID'] . " LIMIT 1;";
          //echo $Query."<br />";
          $DBUpdt->do_ins_query($Query);
          $row++;
        }
        $col++;
      }
      //echo $Query."<br />";
      $DBUpdt->do_close();
      unset($DBUpdt);
    }
  }
  $EditRows = $TotalRows - 10;
  if (intval(GetVal($_SESSION, 'PartID')) > 0)
    $EditRows = (intval(GetVal($_POST, 'SlFrom')) > 0) ? (intval(GetVal($_POST, 'SlFrom')) - 1) : $EditRows;
  $QueryString = $QueryString . " LIMIT " . (($EditRows > 0) ? $EditRows : 0) . ",10";
  $Data->do_sel_query($QueryString);
  //Print Collumn Names
  $i = 0;
  echo "Total Records: {$TotalRows}";
  //echo '<tr><td colspan="' . $TotalCols . '" style="background-color:#333;"></td></tr><tr>';

  while ($i < $TotalCols) {
    echo '<th>' . GetColHead($Data->GetFieldName($i)) . '</th>';
    $i++;
    if (($i % $RowBreak) == 0 && $i > 1)
      echo '</tr><tr>';
  }
  //echo '</tr><tr><td colspan="' . $TotalCols . '" style="background-color:#DDD;"></td></tr>';
  //Print Rows
  $odd = "";
  $RecCount = 0;
  while ($line = $Data->get_row()) {
    $RecCount++;
    $odd = $odd == "" ? "odd" : "";
    echo '<tr class="' . $odd . '">';
    $i = 0;
    foreach ($line as $col_value) {
      if (($i % $RowBreak) == 0 && $i > 1)
        echo '</tr><tr>';
      echo '<td>';
      if ($i == 0) {
        $allow = 'readonly';
        echo '<input type="checkbox" name="RowSelected[]" value="' . htmlspecialchars($col_value) . '"/>&nbsp;&nbsp;'
        . '<!--a href="?Delete=' . htmlspecialchars($col_value) . '"><img border="0" height="16" width="16" '
        . 'title="Delete" alt="Delete" src="./Images/b_drop.png"/></a-->&nbsp;&nbsp;';
      }
      else
        $allow = '';
      echo '<input ' . $allow . ' type="text"';
      //size="'.((mysql_field_len($Data->result,$i)>40)?40:mysql_field_len($Data->result,$i)).'"
      echo ' name="' . $Data->GetFieldName($i) . '[]" value="' . htmlspecialchars($col_value) . '" /> </td>';
      $i++;
    }
    //echo '</tr><tr><td colspan="' . $TotalCols . '" style="background-color:#DDD;"></td></tr>';
  }
  echo '<tr><td colspan="' . $TotalCols . '" style="text-align:right;">'
  . '<label for="txtInsRows">Insert:</label>'
  . '<input type="text" name="txtInsRows" size="3" value="' . (GetVal($_POST, 'txtInsRows') ? GetVal($_POST, 'txtInsRows') : "1") . '"/>'
  . '<input type="hidden" name="ShowBlank" value="' . GetVal($_POST, 'ShowBlank') . '" />'
  . '<input type="submit" name="AddNew" value="New Rows" /><input style="width:80px;" type="submit" name="Delete" value="Delete" />';
  echo '&nbsp;&nbsp;&nbsp;<input style="width:80px;" type="submit" value="Save" /></td></tr></table></form>';
}

?>
