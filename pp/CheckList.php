<?php
require_once __DIR__ . '/../lib.inc.php';
session_start();
if (WebLib::CheckAuth() === "Valid") {
  $CmdChkLst = WebLib::GetVal($_POST, 'CmdChkLst');
  $OfficeID  = WebLib::GetVal($_POST, 'OfficeID');
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
        echo '<h2 style="text-align:center;">Checklist (Office List)</h2>';
        $Data = new MySQLiDBHelper();

        $Query = 'Select `OfficeSL` as `Code`,`OfficeName` as `Name and Address`,'
            . '`PSName` as `PS`,CONCAT(`StatusDesc`," (",O.Status,")") '
            . 'as `Govt. Category`,CONCAT(`TypeDesc`," (",O.TypeCode,")") as `Institute`,'
            . '`Phone`,`Mobile`, `Fax`,`EMail`,`Staffs` as `Total Staff Strength`'
            . ' from ' . MySQL_Pre . 'PP_Offices O LEFT JOIN '
            . MySQL_Pre . 'PP_InstType I ON(O.Status=I.TypeCode) LEFT JOIN '
            . MySQL_Pre . 'PP_Status S ON(S.StatusCode=O.TypeCode) LEFT JOIN '
            . MySQL_Pre . 'PP_PoliceStns P ON(P.PSCode=O.PSCode)';

        $Rows = $Data->where('UserMapID', $_SESSION['UserMapID'])->query($Query);
        echo 'Total Offices: ' . count($Rows) . '<hr/>';
        ShowCheckList($Rows);

        unset($Rows);
        unset($Data);
        break;

      case 'Checklist PP2':
        echo '<h2 style="text-align:center;">Checklist (Polling Personnel)</h2>';
        $Data = new MySQLiDBHelper();
        $Rows = $Data->where('OfficeSL', $OfficeID)
            ->query('Select OfficeName,Staffs from ' . MySQL_Pre . 'PP_Offices');

        echo '<h3>' . $Rows[0]['OfficeName'] . ' (Code: ' . $OfficeID . ')' . '</h3>';
        echo '<strong>Total Staff Strength:</strong> ' . $Rows[0]['Staffs'];

        $Query = 'Select CONCAT(`EmpName`,", ",`DesgID`," (",`EmpSL`,")")'
            . ' as `Name, Designation (Code)`,DATE_FORMAT(`DOB`,"%d/%c/%Y") '
            . 'as `Date of Birth`,`SexId` as `Gender`,`Scale` as `Pay Scale`,'
            . '`BasicPay` as `Basic Pay`,`Qualification`,`P`.`EMail`,`ResPhone`,'
            . '`P`.`Mobile`,`Language` as `Language known other than Bengali`,'
            . ' CONCAT(`PreAddr1`,", ",`PreAddr2`) as `Present Address`,'
            . ' CONCAT(`PerAddr1`,",",`PerAddr2`) as `Permanent Address`,'
            . '`PostingID` as `Working for 3 years out of 4 years in the '
            . 'district as on 30/06/2013`,`P`.`AcNo` as `Assembly (Voter)`'
            . ',`EPIC`,`PartNo`,`SLNo`,'
            . '`AcPreRes` as `Assembly (Present Address)`,`AcPerRes` as '
            . '`Assembly (Permanent Address)`,`AcPosting` as `Assembly (Office)`,'
            . '`PcPreRes` as `Perliament (Present Address)`,`PcPerRes` as '
            . '`Perliament (Permanent Address)`,`PcPosting` as '
            . '`Perliament (Office)`,`BankACNo` as `Bank A/C No`,`IFSC`,`Remarks`'
            . ' from ' . MySQL_Pre . 'PP_Personnel P LEFT JOIN '
            . MySQL_Pre . 'PP_Offices O ON(P.OfficeSL=O.OfficeSL) LEFT JOIN '
            . MySQL_Pre . 'PP_PayScales S ON(P.PayScale=S.ScaleCode)';
        //echo $Query;
        unset($Rows);
        $Rows  = $Data->where('UserMapID', $_SESSION['UserMapID'])
            ->where('P.OfficeSL', $OfficeID)
            ->query($Query);
        echo ' <strong>Total PP: </strong>' . count($Rows) . '<hr/>';
        ShowCheckList($Rows);
        echo 'Remarks:<br/><ul><li value="0">0-Polling Personnel</li>'
        . '<li value="1">1-Head Of Office</li>'
        . '<li value="2">2-Night Guard/Armed Guard</li>'
        . '<li value="3">3-Sweeper</li>'
        . '<li value="4">4-Key Holder</li>'
        . '<li value="5">5-Physically handicapped*</li>'
        . '<li value="6">6-Peoples Representative</li>'
        . '<li value="7">7-Other</li></ul><br/>'
        . 'Qualifications:<br/><ul><li value="1">1-Non Matric/VIII Standard or below</li>'
        . '<li value="2">2-Matric/School Final or H.S</li>'
        . '<li value="3">3-Graduate & Above</li></ul>';
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