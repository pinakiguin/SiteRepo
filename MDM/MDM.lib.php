<?php
require_once(__DIR__ . '/../lib.inc.php');
session_start();

function GetPartName() {
  if (intval(WebLib::GetVal($_SESSION, 'PartID')) > 0) {
    $Fields   = new MySQLiDB();
    $PartName = $Fields->do_max_query('Select CONCAT(PartNo,\' - \',PartName) as PartName from `' . MySQL_Pre . 'SRER_PartMap`'
        . ' Where PartID=' . WebLib::GetVal($_SESSION, 'PartID'));
    $Fields->do_close();
    unset($Fields);
  }
  return ($PartName);
}

function GetColHead($ColName) {
  $Fields  = new MySQLiDB();
  $ColHead = $Fields->do_max_query('Select Description from `' . MySQL_Pre . 'SRER_FieldNames`'
      . ' Where FieldName=\'' . $ColName . '\'');
  $Fields->do_close();
  unset($Fields);
  return (!$ColHead ? $ColName : $ColHead);
}

function ShowSRER($QueryString) {
  // Connecting, selecting database
  $Data      = new MySQLiDB();
  $TotalRows = $Data->do_sel_query($QueryString);
  $TotalCols = $Data->ColCount;
  // Printing results in HTML
  echo '<table rules="all" frame="box" width="100%" cellpadding="5" cellspacing="1">';
  $i         = 0;

  echo 'Total Records: ' . $TotalRows . '<br />';
  while ($i < $TotalCols) {
    echo '<th style="text-align:center;">' . GetColHead($Data->GetFieldName($i)) . '</th>';
    $i++;
  }
  $j    = 0;
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
 * @todo FieldNames sent as ID to be encrypted using Secret
 *
 * @param string $FormName Possible values: (MealReportForm6I|MealReportForm6A|MealReportForm7I|MealReportForm8I|MealReportForm8A)
 */
function MealReportForm($FormName) {
  //$Data = new MySQLiDBHelper(HOST_Name, MySQL_User, MySQL_Pass, MySQL_DB);
  switch ($FormName) {
    case 'PrimaryJan':
    case 'PrimaryMar':
    case 'PrimaryMay':
    case 'PrimaryJul':
    case 'PrimaryAug':
    case "PrimaryOct":
    case "PrimaryDec":

      //@todo Available fields Field in the form to be fetched and encrypted and sent to browser
      ?>
      <table class="MealReportForm">
        <thead>
          <tr>
            <th class="ReportDate">Report Date</th>
            <th class="Meal">I</th>
            <th class="Meal">II</th>
            <th class="Meal">III</th>
            <th class="Meal">IV</th>
            <th class="Meal">Total</th>
          </tr>
        </thead>
        <tbody>
          <?php
          //echo $first;
          $i = 1;
          //@todo SlNo may be replaced by RowID
          //@todo Form has to be Generated based on $_SESSION['Fields'] Set by SetCurrForm
          while ($i < 32) {
            ?>
            <tr id="RowStat" class="saved">
              <td>
                <input type="text" id="ReportDate"
                       class="ReceiptDate"  value="<?php echo $i ?>" />
              </td>
              <td>
                <input type="text" id=I" />
              </td>
              <td>
                <input type = "text" id = II" />
              </td>
              <td>
                <input type="text" id=III" />
              </td>
              <td>
                <input type = "text" id = IV" />
              </td>
              <td>
                <input type="text" id=PrimaryTotal" />
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
              <span>Show <?php echo $i - 1 ?> Rows Starting From: </span>
            </td>
            <td colspan="3" style="text-align: right;">
              <input type="button" id="<?php echo $FormName . 'CmdSave'; ?>" value="Save"/>
              <input type="button" id="<?php echo $FormName . 'CmdDel'; ?>"  value="Delete"/>
            </td>
          </tr>
        </tfoot>
      </table>
      <?php
      break;
      ?>
    <?php
    case 'UpperPrimaryJan':
    case 'UpperPrimaryMar':
    case 'UpperPrimaryMay':
    case 'UpperPrimaryJul':
    case 'UpperPrimaryAug':
    case "UpperPrimaryOct":
    case "UpperPrimaryDec":

      //@todo Available fields Field in the form to be fetched and encrypted and sent to browser
      ?>
      <table class="MealReportForm">
        <thead>
          <tr>
            <th class="ReportDate">Report Date</th>
            <th class="Meal">V</th>
            <th class="Meal">VI</th>
            <th class="Meal">VII</th>
            <th class="Meal">VIII</th>
            <th class="Meal">Total</th>

          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          //@todo SlNo may be replaced by RowID
          //@todo Form has to be Generated based on $_SESSION['Fields'] Set by SetCurrForm
          while ($i < 32) {
            ?>
            <tr id="RowStat" class="saved">
              <td>
                <input type="text" id="ReportDate"
                       class="ReceiptDate" value="<?php echo $i ?>" />
              </td>
              <td>
                <input type="text" id=V" />
              </td>
              <td>
                <input type = "text" id = VI" />
              </td>
              <td>
                <input type="text" id=VII" />
              </td>
              <td>
                <input type = "text" id = VIII" />
              </td>
              <td>
                <input type="text" id=UpperPrimaryTotal" />
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
              <span>Show <?php echo $i - 1 ?> Rows Starting From: </span>
            </td>
            <td colspan="3" style="text-align: right;">
              <input type="button" id="<?php echo $FormName . 'CmdSave'; ?>" value="Save"/>
              <input type="button" id="<?php echo $FormName . 'CmdDel'; ?>"  value="Delete"/>
            </td>
          </tr>
        </tfoot>
      </table>
      <?php
      break;
    case 'PrimaryApr':
    case 'PrimaryJun':
    case 'PrimarySep':
    case 'PrimaryNov':
      //@todo Available fields Field in the form to be fetched and encrypted and sent to browser
      ?>
      <table class="MealReportForm">
        <thead>
          <tr>
            <th class="ReportDate">Report Date</th>
            <th class="Meal">I</th>
            <th class="Meal">II</th>
            <th class="Meal">III</th>
            <th class="Meal">IV</th>
            <th class="Meal">Total</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          //@todo SlNo may be replaced by RowID
          //@todo Form has to be Generated based on $_SESSION['Fields'] Set by SetCurrForm
          while ($i < 31) {
            ?>
            <tr id="RowStat" class="saved">
              <td>
                <input type="text" id="ReportDate"
                       class="ReceiptDate" value="<?php echo $i ?>" />
              </td>
              <td>
                <input type="text" id=I" />
              </td>
              <td>
                <input type = "text" id = II" />
              </td>
              <td>
                <input type="text" id=III" />
              </td>
              <td>
                <input type = "text" id = IV" />
              </td>
              <td>
                <input type="text" id=PrimaryTotal" />
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
              <span>Show <?php echo $i - 1 ?> Rows Starting From: </span>
            </td>
            <td colspan="3" style="text-align: right;">
              <input type="button" id="<?php echo $FormName . 'CmdSave'; ?>" value="Save"/>
              <input type="button" id="<?php echo $FormName . 'CmdDel'; ?>"  value="Delete"/>
            </td>
          </tr>
        </tfoot>
      </table>
      <?php
      break;
      ?>
    <?php
    case 'UpperPrimaryApr':
    case 'UpperPrimaryJun':
    case 'UpperPrimarySep':
    case 'UpperPrimaryNov':

      //@todo Available fields Field in the form to be fetched and encrypted and sent to browser
      ?>
      <table class="MealReportForm">
        <thead>
          <tr>
            <th class="ReportDate">Report Date</th>
            <th class="Meal">V</th>
            <th class="Meal">VI</th>
            <th class="Meal">VII</th>
            <th class="Meal">VIII</th>
            <th class="Meal">Total</th>

          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          //@todo SlNo may be replaced by RowID
          //@todo Form has to be Generated based on $_SESSION['Fields'] Set by SetCurrForm
          while ($i < 31) {
            ?>
            <tr id="RowStat" class="saved">
              <td>
                <input type="text" id="ReportDate"
                       class="ReceiptDate" value="<?php echo $i ?>" />
              </td>
              <td>
                <input type="text" id=V" />
              </td>
              <td>
                <input type = "text" id = VI" />
              </td>
              <td>
                <input type="text" id=VII" />
              </td>
              <td>
                <input type = "text" id = VIII" />
              </td>
              <td>
                <input type="text" id=UpperPrimaryTotal" />
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
              <span>Show <?php echo $i - 1 ?>; Rows Starting From: </span>
            </td>
            <td colspan="3" style="text-align: right;">
              <input type="button" id="<?php echo $FormName . 'CmdSave'; ?>" value="Save"/>
              <input type="button" id="<?php echo $FormName . 'CmdDel'; ?>"  value="Delete"/>
            </td>
          </tr>
        </tfoot>
      </table>
      <?php
      break;
    case 'PrimaryFeb':
      //@todo Available fields Field in the form to be fetched and encrypted and sent to browser
      ?>
      <table class="MealReportForm">
        <thead>
          <tr>
            <th class="ReportDate">Report Date</th>
            <th class="Meal">I</th>
            <th class="Meal">II</th>
            <th class="Meal">III</th>
            <th class="Meal">IV</th>
            <th class="Meal">Total</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i      = 1;
          $daylim = date("t");
          //@todo SlNo may be replaced by RowID
          //@todo Form has to be Generated based on $_SESSION['Fields'] Set by SetCurrForm
          while ($daylim >= $i) {
            ?>
            <tr id="RowStat" class="saved">
              <td>
                <input type="text" id="ReportDate"
                       class="ReceiptDate" value="<?php echo $i ?>" />
              </td>
              <td>
                <input type="text" id=I" />
              </td>
              <td>
                <input type = "text" id = II" />
              </td>
              <td>
                <input type="text" id=III" />
              </td>
              <td>
                <input type = "text" id = IV" />
              </td>
              <td>
                <input type="text" id=PrimaryTotal" />
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
              <span>Show <?php echo $daylim ?> Rows Starting From: </span>
            </td>
            <td colspan="3" style="text-align: right;">
              <input type="button" id="<?php echo $FormName . 'CmdSave'; ?>" value="Save"/>
              <input type="button" id="<?php echo $FormName . 'CmdDel'; ?>"  value="Delete"/>
            </td>
          </tr>
        </tfoot>
      </table>
      <?php
      break;
      ?>
    <?php
    case 'UpperPrimaryFeb':

      //@todo Available fields Field in the form to be fetched and encrypted and sent to browser
      ?>
      <table class="MealReportForm">
        <thead>
          <tr>
            <th class="ReportDate">Report Date</th>
            <th class="Meal">V</th>
            <th class="Meal">VI</th>
            <th class="Meal">VII</th>
            <th class="Meal">VIII</th>
            <th class="Meal">Total</th>

          </tr>
        </thead>
        <tbody>
          <?php
          $i      = 1;
          $daylim = date("t");
          //@todo SlNo may be replaced by RowID
          //@todo Form has to be Generated based on $_SESSION['Fields'] Set by SetCurrForm
          while ($daylim >= $i) {
            ?>
            <tr id="RowStat" class="saved">
              <td>
                <input type="text" id="ReportDate"
                       class="ReceiptDate" value="<?php echo $i ?>" />
              </td>
              <td>
                <input type="text" id=V" />
              </td>
              <td>
                <input type = "text" id = VI" />
              </td>
              <td>
                <input type="text" id=VII" />
              </td>
              <td>
                <input type = "text" id = VIII" />
              </td>
              <td>
                <input type="text" id=UpperPrimaryTotal" />
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
              <span>Show <?php echo $daylim ?>; Rows Starting From: </span>
            </td>
            <td colspan="3" style="text-align: right;">
              <input type="button" id="<?php echo $FormName . 'CmdSave'; ?>" value="Save"/>
              <input type="button" id="<?php echo $FormName . 'CmdDel'; ?>"  value="Delete"/>
            </td>
          </tr>
        </tfoot>
      </table>
      <?php
      break;
  }
}
?>
