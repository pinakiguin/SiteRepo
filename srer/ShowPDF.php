<?php

require_once __DIR__ . '/../lib.inc.php';
require_once __DIR__ . '/PDF.php';
require_once __DIR__ . '/../class.MySQLiDBHelper.php';
session_start();
$Data = new MySQLiDBHelper(HOST_Name, MySQL_User, MySQL_Pass, MySQL_DB);
$Data->where('PartID', $_POST['PartID']);
$_SESSION['Part'] = $Data->get(MySQL_Pre . 'SRER_PartMap', 1);
$_SESSION['Part'] = $_SESSION['Part'][0];
$_SESSION['PDFName'] = $_SESSION['Part']['ACNo']
  . '-' . $_SESSION['Part']['PartNo'] . '-'
  . $_SESSION['Part']['PartName'];
unset($Data);

if (intval($_SESSION['Part']['PartID']) > 0) {
  $pdf = new SRER_PDF();
  $_SESSION['TableName'] = MySQL_Pre . 'SRER_Form6';
  $_SESSION['Fields'] = '`SlNo`,`ReceiptDate`,`AppName`,`DOB`,`Sex`,`RelationshipName`,`Relationship`,`Status`';
  $ColWidths = array(
    array('1', '2', '3', '4', '5', '6', '7', '8'),
    array(17, 25, 80, 20, 15, 80, 25, 0)
  );
  $pdf->cols = $ColWidths;
  ShowPDF($pdf, "Form 6");

  $_SESSION['TableName'] = MySQL_Pre . 'SRER_Form6A';
  $_SESSION['Fields'] = '`SlNo`,`ReceiptDate`,`AppName`,`DOB`,`Sex`,`RelationshipName`,`Relationship`,`Status`';
  $ColWidths = array(
    array('1', '2', '3', '4', '5', '6', '7', '8'),
    array(17, 25, 80, 20, 15, 80, 25, 0)
  );
  $pdf->cols = $ColWidths;
  ShowPDF($pdf, "Form 6A");

  $_SESSION['TableName'] = MySQL_Pre . 'SRER_Form7';
  $_SESSION['Fields'] = '`SlNo`,`ReceiptDate`,`ObjectorName`,`PartNo`,`SerialNoInPart`,`DelPersonName`,`ObjectReason`,`Status`';
  $ColWidths = array(
    array('1', '2', '3', '4', '5', '6', '7', '8'),
    array(17, 25, 80, 20, 20, 80, 20, 0)
  );
  $pdf->cols = $ColWidths;
  ShowPDF($pdf, "Form 7");

  $_SESSION['TableName'] = MySQL_Pre . 'SRER_Form8';
  $_SESSION['Fields'] = '`SlNo`,`ReceiptDate`,`ElectorName`,`ElectorPartNo`,`ElectorSerialNoInPart`,`NatureObjection`,`Status`';
  $ColWidths = array(
    array('1', '2', '3', '4', '5', '6', '7'),
    array(20, 25, 80, 20, 30, 80, 0)
  );
  $pdf->cols = $ColWidths;
  ShowPDF($pdf, "Form 8");

  $_SESSION['TableName'] = MySQL_Pre . 'SRER_Form8A';
  $_SESSION['Fields'] = '`SlNo`,`ReceiptDate`,`AppName`,`TransName`,`TransPartNo`,`TransSerialNoInPart`,`TransEPIC`,`PreResi`,`Status`';
  $ColWidths = array(
    array('1', '2', '3', '4', '5', '6', '7', '8', '9'),
    array(17, 25, 80, 20, 20, 20, 30, 40, 0)
  );
  $pdf->cols = $ColWidths;
  ShowPDF($pdf, "Form 8A", 1);
}

function ShowPDF(&$pdf, $SRERForm, $Finish = 0) {
  $ColHead = & $pdf->cols[0];
  $Data = new MySQLiDB();
  $i = 0;
  $Query = "Select {$_SESSION['Fields']} from {$_SESSION['TableName']} Where PartID={$_SESSION['Part']['PartID']}";
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