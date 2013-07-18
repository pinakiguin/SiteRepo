<?php
require_once('../lib.inc.php');

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

/**
 * Shows the Table for SRER FormPanels
 *
 * @param string $FormName Possible values: (SRERForm6I|SRERForm6A|SRERForm7I|SRERForm8I|SRERForm8A)
 */
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
          //@todo Form has to be Generated based on $_SESSION['Fields'] Set by SetCurrForm
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
              <input type="text" id="<?php echo $FormName . 'FromRow'; ?>" value="1"/>
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
?>
