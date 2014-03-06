<?php
require_once(__DIR__ . '/../lib.inc.php');

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
