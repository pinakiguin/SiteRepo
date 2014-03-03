<?php
require_once __DIR__ . '/../lib.inc.php';
session_start();
if (WebLib::CheckAuth() === "Valid") {
  $CmdChkLst = WebLib::GetVal($_POST, 'CmdChkLst');
  WebLib::Html5Header($CmdChkLst);
  ?>
  </head>
  <body>
    <?php

    function ShowCheckList($Rows) {

      foreach ($Rows as $RowIndex => $RowData) {
        echo $RowIndex . '<br/>';
        foreach ($RowData as $FieldName => $Value) {
          echo '<strong>' . $FieldName . '</strong> : ' . $Value . ', ';
        }
        echo '<hr/>';
      }
    }

    switch ($CmdChkLst) {
      case 'Checklist PP1':
        echo '<h2 style="text-align:center;">Checklist (Office List)</h2><hr/>';
        $Data = new MySQLiDBHelper();

        $Query = 'Select `OfficeSL` as `Code`,`OfficeName` as `Name and Address`,'
            . '`PSName` as `PS`,`StatusDesc` as `Govt. Category`,`TypeDesc` as `Institute`,'
            . '`Phone`,`Mobile`, `Fax`,`EMail`,`Staffs` as `Total Staff Strength`'
            . ' from ' . MySQL_Pre . 'PP_Offices O JOIN '
            . MySQL_Pre . 'PP_InstType I ON(O.TypeCode=I.TypeCode) JOIN '
            . MySQL_Pre . 'PP_Status S ON(S.StatusCode=O.Status) JOIN '
            . MySQL_Pre . 'PP_PoliceStns P ON(P.PSCode=O.PSCode)';

        $Rows = $Data->where('UserMapID', $_SESSION['UserMapID'])->query($Query);
        ShowCheckList($Rows);
        unset($Rows);
        unset($Data);
        break;

      case 'Checklist PP2':
        echo '<h2 style="text-align:center;">Checklist (Polling Personnel)</h2><hr/>';
        $Data = new MySQLiDBHelper();

        $Query = 'Select `EmpSL`,`EmpName`,`DesgID`,`DOB`,`SexId`,`P`.`AcNo`,`PartNo`,`SLNo`,`EPIC`'
            . ' from ' . MySQL_Pre . 'PP_Personnel P JOIN '
            . MySQL_Pre . 'PP_Offices O ON(P.OfficeSL=O.OfficeSL)';

        $Rows = $Data->where('UserMapID', $_SESSION['UserMapID'])->query($Query);
        ShowCheckList($Rows);
        unset($Rows);
        unset($Data);
        break;
    }
    ?>
  </body>
  </body>
  </html>
  <?php
}
?>