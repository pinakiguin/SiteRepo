<?php

require_once __DIR__ . '/../lib.inc.php';
require_once __DIR__ . '/Manuscript.pdf.php';
require_once __DIR__ . '/../class.MySQLiDBHelper.php';
$Data = new MySQLiDBHelper(HOST_Name, MySQL_User, MySQL_Pass, MySQL_DB);
$Data->where('PartID', WebLib::GetVal($_POST, 'PartID'));
$_SESSION['Part'] = $Data->get(MySQL_Pre . 'SRER_PartMap', 1);
$_SESSION['Part'] = $_SESSION['Part'][0];
$_SESSION['PDFName'] = $_SESSION['Part']['ACNo']
        . '-' . $_SESSION['Part']['PartNo'] . '-'
        . $_SESSION['Part']['PartName'] . '-Manuscript';
$_SESSION['DateFrom'] = WebLib::ToDBDate(WebLib::GetVal($_POST, 'DateFrom'));
$_SESSION['DateTo'] = WebLib::ToDBDate(WebLib::GetVal($_POST, 'DateTo'));
if (WebLib::GetVal($_SESSION, 'Datewise') === '0') {
  $_SESSION['DateWiseQry'] = '';
} else {
  $_SESSION['DateWiseQry'] = '`ReceiptDate` BETWEEN \'' . $_SESSION['DateFrom'] . '\' AND \'' . $_SESSION['DateTo'] . '\' AND ';
  $_SESSION['PDFName'] = $_SESSION['PDFName'] . '[' . $_SESSION['DateFrom'] . '_' . $_SESSION['DateTo'] . ']';
}
unset($Data);

if (intval($_SESSION['Part']['PartID']) > 0) {
  $pdf = new MAN_PDF();
  $pdf->TxtHeader = $_SESSION['Part']['ACNo'] . ' Assembly Constituency';

  $pdf->FormDesc = 'List of Fresh Additions (Form-6)';
  $_SESSION['TableName'] = MySQL_Pre . 'SRER_Form6';
  $_SESSION['Fields'] = '\'\' as `Section|No.`,\'\' as `House|No.`,`AppName` as `Name of Elector`,'
          . '`Relationship`,`RelationshipName` as `Name of Relation`,`Sex`,'
          . 'DATE_FORMAT(`DOB`,\'%d.%m.%Y\') as `Age|Date of Birth|DD.MM.YYYY`,\'\' as `EPIC No.|if any`,'
          . '\'\' as `Sl.No. in the relevant part|of the Draft Roll of other|members of the family`,'
          . '\'\' as `Whether photo|submitted|(Y/N)`,\'\' as `Mobile No.|if any`,'
          . '\'\' as `On the basis of|Form-6/Rule 21|(F6/R21)`';
  $ColWidths = array(
      array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'),
      array(12, 10, 50, 20, 35, 10, 20, 20, 38, 22, 22, 0)
  );
  $pdf->cols = $ColWidths;
  ManuscriptPDF($pdf, "Proforma - A");

  $pdf->FormDesc = 'List of Deletion';
  $_SESSION['TableName'] = MySQL_Pre . 'SRER_Form7';
  $_SESSION['Fields'] = '`SlNo` as `Sl.No. of|Draft Roll *`,`ObjectorName` as `Name`,\'\' as `Sex`,\'\' as `Age`,'
          . '\'\' as `EPIC No. if any`,`ObjectReason` as `Reason for Deletion|(E / S / R / M / Q)`,'
          . '\'\' as `Process followed|(Form-7/Rule 21 A)`';
  $ColWidths = array(
      array('1', '2', '3', '4', '5', '6', '7'),
      array(20, 80, 20, 20, 60, 40, 0)
  );
  $pdf->cols = $ColWidths;
  ManuscriptPDF($pdf, "Proforma - D");

  $pdf->FormDesc = 'List of Modification';
  $_SESSION['TableName'] = MySQL_Pre . 'SRER_Form8';
  $_SESSION['Fields'] = '`SlNo` as `Serial|No. of|Draft No.`,\'\' as `House|No.`,`ElectorName` as `Name of Elector`,'
          . '\'\' as `Relationship`,\'\' as `Name of Relation`,\'\' as `Sex`,\'\' as `Age`,\'\' as `EPIC No.|if any`,'
          . '\'\' as `Whether photo to|be removed from|Roll (Y/N)`,\'\' as `Whether photo|submitted|(Y/N)`,'
          . '\'\' as `Process followed|(Form-6/Rule 21)`';
  $ColWidths = array(
      array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11'),
      array(12, 10, 50, 20, 45, 10, 10, 40, 30, 22, 0)
  );
  $pdf->cols = $ColWidths;
  ManuscriptPDF($pdf, "Proforma - E");

  $pdf->FormDesc = 'List of Transposition of Electors within same AC (8A)';
  $_SESSION['TableName'] = MySQL_Pre . 'SRER_Form8A';
  $_SESSION['Fields'] = '\'\' as `Section|No.`,\'\' as `House|No.`,`TransName` as `Name of Elector`,'
          . '\'\' as `Relationship`,\'\' as `Name of Relation`,\'\' as `Sex`,\'\' as `Age`,`TransEPIC` as `EPIC No.`,'
          . '\'\' as `Sl.No. in the relevant part|of the Draft Roll of other|members of the family`,'
          . '`TransPartNo` as `Part No. from which Elector is being shifted`,'
          . '`TransSerialNoInPart` as `Sl. No. from which Elector is being shifted`,\'\' as `Whether photo|submitted|(Y/N)`';
  $ColWidths = array(
      array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'),
      array(12, 10, 50, 20, 35, 10, 10, 30, 38, 23, 23, 0)
  );
  $pdf->cols = $ColWidths;
  ManuscriptPDF($pdf, "Proforma - B", 1);
}

function ManuscriptPDF(&$pdf, $SRERForm, $Finish = 0) {
  $ColHead = & $pdf->cols[0];
  $Data = new MySQLiDB();
  $i = 0;
  $Query = 'Select ' . $_SESSION['Fields'] . ' from ' . $_SESSION['TableName']
          . ' Where ' . $_SESSION['DateWiseQry'] . ' `PartID`=' . $_SESSION['Part']['PartID'] . ' AND LOWER(TRIM(`Status`))=\'a\' Order By SlNo';
  $Data->do_sel_query($Query);

  while ($i < $Data->ColCount) {
    $ColHead[$i] = $Data->GetCaption($Data->GetFieldName($i));
    $i++;
  }
  unset($ColHead);
  unset($Data);
  $pdf->SetTitle($SRERForm);
  $pdf->AddPage();
  $pdf->Details($Query, 0);
  if ($Finish) {
    $pdf->Output($_SESSION['PDFName'] . ".pdf", "D");
    unset($pdf);
    exit();
  }
}

?>
