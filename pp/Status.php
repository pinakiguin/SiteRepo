<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once ( __DIR__ . '/../lib.inc.php');

WebLib::Html5Header('Data Entry Status');
?>
</head>
<body>
  <?php
  $Data = new MySQLiDBHelper();

  $DataPP2 = $Data->query('Select LastUpdatedOn,EmpSL,EmpName,DOB,BankACNo,OfficeSL'
      . ' FROM `' . MySQL_Pre . 'PP_Personnel` '
      . ' Order By LastUpdatedOn desc limit 10');

  $CurrTime = $Data->query('Select NOW() as `CurrTime`');
  echo 'Current Time: ' . $CurrTime[0]['CurrTime'];

  arrayToTable($DataPP2);
  unset($DataPP2);

  $Branches = $Data->query('Select * '
      . ' FROM `' . MySQL_Pre . 'PP_Branches` '
      . ' Order By `BranchSL` desc limit 10');

  arrayToTable($Branches);
  unset($Branches);
  exit();

  function arrayToTable($DataArray) {
    echo '<table rules="all" frame="box" cellpadding="5" cellspacing="1">';
    foreach ($DataArray as $RowIndex => $RowData) {
      echo '<tr>';
      if ($RowIndex === 0) {
        foreach ($RowData as $ColIndex => $Cell) {
          echo '<td>' . $ColIndex . '</td>';
        }
        echo '</tr><tr>';
      }
      foreach ($RowData as $ColIndex => $Cell) {
        if ($ColIndex === 'A') {
          echo '<td>' . $RowIndex . '</td>';
        }
        echo '<td>' . $Cell . '</td>';
      }
      echo '</tr>';
    }
    echo '</table>';
  }
  ?>
</body>
</html>