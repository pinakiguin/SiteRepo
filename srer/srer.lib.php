<?php
require_once(__DIR__ . '/../lib.inc.php');

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
  $Fields = new MySQLiDBHelper();
  $Fields->where('FieldName', $ColName);
  $ColHead = $Fields->query('Select Description from `' . MySQL_Pre . 'SRER_FieldNames`');

  unset($Fields);
  return (count($ColHead) > 0 ? $ColHead[0]['Description'] : $ColName);
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
    foreach ($line as $col_value) {
      echo '<td>' . $col_value . '</td>';
    }
    echo '</tr>';
    $j++;
  }
  echo '</table>';
  unset($Data);
  return ($j);
}

/**
 * Shows the Table for SRER FormPanels
 * @todo FieldNames sent as ID to be encrypted using Secret
 *
 * @param string $FormName Possible values: (SRERForm6I|SRERForm6A|SRERForm7I|SRERForm8I|SRERForm8A)
 */
function SRERForm($FormName) {
  //$Data = new MySQLiDBHelper(HOST_Name, MySQL_User, MySQL_Pass, MySQL_DB);
  switch ($FormName) {
    case 'SRERForm6I':
    case 'SRERForm6A':
      //@todo Available fields Field in the form to be fetched and encrypted and sent to browser
      ?>
      <table class="SRERForm">
        <thead>
        <tr>
          <th colspan="2" class="SlNo"><?php echo GetColHead('SlNo'); ?></th>
          <th class="ReceiptDate"><?php echo GetColHead('ReceiptDate'); ?></th>
          <th class="AppName"><?php echo GetColHead('AppName'); ?></th>
          <th class="DOB"><?php echo GetColHead('DOB'); ?></th>
          <th class="Sex"><?php echo GetColHead('Sex'); ?></th>
          <th class="RelationshipName"><?php echo GetColHead('RelationshipName'); ?></th>
          <th class="Relationship"><?php echo GetColHead('Relationship'); ?></th>
          <th class="Status"><?php echo GetColHead('Status'); ?></th>
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
              <input id="<?php echo $FormName . 'RowID' . $i . '_D'; ?>"
                     type="checkbox" value=""/>
            </td>
            <td class="SlNoTxt">
              <input type="text" id="<?php echo $FormName . 'SlNo' . $i . '_D'; ?>"
                     class="SlNoTxt"/>
            </td>
            <td>
              <input type="text" id="<?php echo $FormName . 'ReceiptDate' . $i . '_D'; ?>"
                     class="ReceiptDate" placeholder="yyyy-mm-dd"/>
            </td>
            <td>
              <input type="text" id="<?php echo $FormName . 'AppName' . $i . '_D'; ?>"/>
            </td>
            <td>
              <input type="text" id="<?php echo $FormName . 'DOB' . $i . '_D'; ?>"
                     class="DOB" placeholder="yyyy-mm-dd"/>
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
              <input type="text" id="<?php echo $FormName . 'RelationshipName' . $i . '_D'; ?>"/>
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
            <input type="button" id="<?php echo $FormName . 'CmdEdit'; ?>" value="Edit"/>
          </td>
          <td colspan="3" style="text-align: right;">
            <input type="button" id="<?php echo $FormName . 'CmdNew'; ?>" value="New"/>
            <input type="button" id="<?php echo $FormName . 'CmdSave'; ?>" value="Save"/>
            <input type="button" id="<?php echo $FormName . 'CmdDel'; ?>" value="Delete"/>
          </td>
        </tr>
        </tfoot>
      </table>
      <?php
      break;
    case 'SRERForm8I':
      ?>
      <table class="SRERForm">
        <thead>
        <tr>
          <th class="SlNo" colspan="2">  <?php echo GetColHead('SlNo'); ?>                 </th>
          <th class="ReceiptDate">          <?php echo GetColHead('ReceiptDate'); ?>          </th>
          <th class="ElectorName">          <?php echo GetColHead('ElectorName'); ?>          </th>
          <th class="ElectorPartNo">        <?php echo GetColHead('ElectorPartNo'); ?>        </th>
          <th class="ElectorSerialNoInPart"><?php echo GetColHead('ElectorSerialNoInPart'); ?></th>
          <th class="NatureObjection">      <?php echo GetColHead('NatureObjection'); ?>      </th>
          <th class="Status">               <?php echo GetColHead('Status'); ?>               </th>
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
              <input id="<?php echo $FormName . 'RowID' . $i . '_D'; ?>" type="checkbox" value=""/>
            </td>
            <td class="SlNoTxt">
              <input type="text" id="<?php echo $FormName . 'SlNo' . $i . '_D'; ?>"
                     class="SlNoTxt"/>
            </td>
            <td>
              <input type="text" id="<?php echo $FormName . 'ReceiptDate' . $i . '_D'; ?>"
                     class="ReceiptDate" placeholder="yyyy-mm-dd"/>
            </td>
            <td>
              <input type="text" id="<?php echo $FormName . 'ElectorName' . $i . '_D'; ?>"/>
            </td>
            <td>
              <input type="text" id="<?php echo $FormName . 'ElectorPartNo' . $i . '_D'; ?>"/>
            </td>
            <td>
              <input type="text" id="<?php echo $FormName . 'ElectorSerialNoInPart' . $i . '_D'; ?>"/>
            </td>
            <td>
              <select id="<?php echo $FormName . 'NatureObjection' . $i . '_D'; ?>">
                <option value=""></option>
                <option value="N">My Name</option>
                <option value="A">Age</option>
                <option value="G">Father's/Mother's/Husband's Name</option>
                <option value="S">Sex</option>
                <option value="R">Address</option>
                <option value="E">EPIC No.</option>
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
            <input type="button" id="<?php echo $FormName . 'CmdEdit'; ?>" value="Edit"/>
          </td>
          <td colspan="2" style="text-align: right;">
            <input type="button" id="<?php echo $FormName . 'CmdNew'; ?>" value="New"/>
            <input type="button" id="<?php echo $FormName . 'CmdSave'; ?>" value="Save"/>
            <input type="button" id="<?php echo $FormName . 'CmdDel'; ?>" value="Delete"/>
          </td>
        </tr>
        </tfoot>
      </table>
      <?php
      break;
    case 'SRERForm8A':
      //@todo Available fields Field in the form to be fetched and encrypted and sent to browser
      ?>
      <table class="SRERForm">
        <thead>
        <tr>
          <th class="SlNo" colspan="2">   <?php echo GetColHead('SlNo'); ?>       </th>
          <th class="ReceiptDate">        <?php echo GetColHead('ReceiptDate'); ?></th>
          <th class="AppName">            <?php echo GetColHead('AppName'); ?>    </th>
          <th class="TransName">          <?php echo GetColHead('TransName'); ?>    </th>
          <th class="TransPartNo">        <?php echo GetColHead('TransPartNo'); ?>    </th>
          <th class="TransSerialNoInPart"><?php echo GetColHead('TransSerialNoInPart'); ?>    </th>
          <th class="TransEPIC">          <?php echo GetColHead('TransEPIC'); ?>    </th>
          <th class="PreResi">            <?php echo GetColHead('PreResi'); ?>     </th>
          <th class="Status">             <?php echo GetColHead('Status'); ?>     </th>
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
              <input id="<?php echo $FormName . 'RowID' . $i . '_D'; ?>"
                     type="checkbox" value=""/>
            </td>
            <td class="SlNoTxt">
              <input type="text" id="<?php echo $FormName . 'SlNo' . $i . '_D'; ?>"
                     class="SlNoTxt"/>
            </td>
            <td>
              <input type="text" id="<?php echo $FormName . 'ReceiptDate' . $i . '_D'; ?>"
                     class="ReceiptDate" placeholder="yyyy-mm-dd"/>
            </td>
            <td>
              <input type="text" id="<?php echo $FormName . 'AppName' . $i . '_D'; ?>"/>
            </td>
            <td>
              <input type="text" id="<?php echo $FormName . 'TransName' . $i . '_D'; ?>"/>
            </td>
            <td>
              <input type="text" id="<?php echo $FormName . 'TransPartNo' . $i . '_D'; ?>"/>
            </td>
            <td>
              <input type="text" id="<?php echo $FormName . 'TransSerialNoInPart' . $i . '_D'; ?>"/>
            </td>
            <td>
              <input type="text" id="<?php echo $FormName . 'TransEPIC' . $i . '_D'; ?>"/>
            </td>
            <td>
              <input type="text" id="<?php echo $FormName . 'PreResi' . $i . '_D'; ?>"/>
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
            <input type="button" id="<?php echo $FormName . 'CmdEdit'; ?>" value="Edit"/>
          </td>
          <td colspan="4" style="text-align: right;">
            <input type="button" id="<?php echo $FormName . 'CmdNew'; ?>" value="New"/>
            <input type="button" id="<?php echo $FormName . 'CmdSave'; ?>" value="Save"/>
            <input type="button" id="<?php echo $FormName . 'CmdDel'; ?>" value="Delete"/>
          </td>
        </tr>
        </tfoot>
      </table>
      <?php
      break;
    case 'SRERForm7I':
      ?>
      <table class="SRERForm">
        <thead>
        <tr>
          <th colspan="2" class="SlNo"><?php echo GetColHead('SlNo'); ?></th>
          <th class="ReceiptDate"><?php echo GetColHead('ReceiptDate'); ?></th>
          <th class="ObjectorName"><?php echo GetColHead('ObjectorName'); ?></th>
          <th class="PartNo"><?php echo GetColHead('PartNo'); ?></th>
          <th class="SerialNoInPart"><?php echo GetColHead('SerialNoInPart'); ?></th>
          <th class="DelPersonName"><?php echo GetColHead('DelPersonName'); ?></th>
          <th class="ObjectReason"><?php echo GetColHead('ObjectReason'); ?></th>
          <th class="Status"><?php echo GetColHead('Status'); ?></th>
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
              <input id="<?php echo $FormName . 'RowID' . $i . '_D'; ?>"
                     type="checkbox" value=""/>
            </td>
            <td class="SlNoTxt">
              <input type="text" id="<?php echo $FormName . 'SlNo' . $i . '_D'; ?>"
                     class="SlNoTxt"/>
            </td>
            <td>
              <input type="text" id="<?php echo $FormName . 'ReceiptDate' . $i . '_D'; ?>"
                     class="ReceiptDate" placeholder="yyyy-mm-dd"/>
            </td>
            <td>
              <input type="text" id="<?php echo $FormName . 'ObjectorName' . $i . '_D'; ?>"/>
            </td>
            <td>
              <input type="text" id="<?php echo $FormName . 'PartNo' . $i . '_D'; ?>"/>
            </td>
            <td>
              <input type="text" id="<?php echo $FormName . 'SerialNoInPart' . $i . '_D'; ?>"/>
            </td>
            <td>
              <input type="text" id="<?php echo $FormName . 'DelPersonName' . $i . '_D'; ?>"/>
            </td>
            <td>
              <select id="<?php echo $FormName . 'ObjectReason' . $i . '_D'; ?>">
                <option value=""></option>
                <option value="S">Shifted</option>
                <option value="E">Dead</option>
                <option value="D">Duplicate</option>
                <option value="Q">Disqualification</option>
                <option value="M">Missing</option>
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
            <input type="button" id="<?php echo $FormName . 'CmdEdit'; ?>" value="Edit"/>
          </td>
          <td colspan="3" style="text-align: right;">
            <input type="button" id="<?php echo $FormName . 'CmdNew'; ?>" value="New"/>
            <input type="button" id="<?php echo $FormName . 'CmdSave'; ?>" value="Save"/>
            <input type="button" id="<?php echo $FormName . 'CmdDel'; ?>" value="Delete"/>
          </td>
        </tr>
        </tfoot>
      </table>
      <?php
      break;
  }
}

?>
