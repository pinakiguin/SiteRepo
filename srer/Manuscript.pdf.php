<?php

require_once __DIR__ . '/../FPDF/pdf.inc.php';

class MAN_PDF extends PDF {

  public $Query;
  public $maxln;
  public $rh;
  public $colw;
  public $cols;
  public $fh = 3.5;
  public $TxtHeader;
  public $FormDesc;

  function MAN_PDF() {
    $this->FPDF('L');
    $this->SetAuthor('SRER 2014 Paschim Medinipur 1.0');
    $this->SetCreator('NIC Paschim Medinipur');
    $this->AliasNbPages();
    $this->SetMargins(5, 5, 5);
    $this->SetAutoPageBreak(TRUE, 5);
  }

  function PreHeader() {
    $this->SetAutoPageBreak(TRUE, 20);
    $this->SetFont('Arial', 'B', 12);
    $this->SetTextColor(0);
    $this->Cell(0, 5, $this->TxtHeader, 0, 1, 'C');
    $this->SetFont('Arial', 'B', 18);
    $this->Cell(0, 12, $this->title, 0, 1, 'C');
    $this->SetY($this->y - 8);
    $this->SetFont('Arial', 'B', 8);
    $this->Cell(0, 5, $this->FormDesc, 0, 0, 'L');
    $this->Cell(0, 5, 'Part No. ' . $_SESSION['Part']['PartNo'], 0, 1, 'R');
  }

  function PreFooter() {
    $this->Ln(2);
    $this->SetFont('Arial', '', 8);
    $this->SetTextColor(0);
    $this->Cell(36, 18, 'Prepared & Compared By :', 1, 0, 'L');
    $this->SetX(41);
    $this->Cell(80, 9, '1.', 1, 1, 'L');
    $this->SetX(41);
    $this->Cell(80, 9, '2.', 1, 0, 'L');
    $this->SetXY(125, $this->y - 9);
    $this->Cell(20, 6, 'Male', 1, 0, 'C');
    $this->Cell(20, 6, 'Female', 1, 0, 'C');
    $this->Cell(20, 6, 'Total', 1, 1, 'C');
    $this->SetX(125);
    $this->Cell(20, 12, '', 1, 0, 'C');
    $this->Cell(20, 12, '', 1, 0, 'C');
    $this->Cell(20, 12, '', 1, 1, 'C');
    $this->SetY(-4);
  }

  function Details($Query, $SlNo = 1, $lw = 0.1, $fw = 6) {
    $this->SetFont('Arial', '', $fw);
    $this->SetLineWidth($lw);
    $j = 0;
    while ($j < count($this->cols[0])) {
      $this->Cell($this->colw[$j], 5, $j + 1, 1, 0, 'C');
      $j++;
    }
    $this->Ln();
    $Data = new MySQLiDB();
    $Data->do_sel_query($Query);
    $c = 1;
    while ($row = $Data->get_n_row()) {
      $i = 0;
      $row = $this->SplitLn($row, 0);
      $h = ($this->maxln * $this->fh) + 24;
      $maxln = $this->maxln;
      while ($i < count($this->colw)) {
        if (($this->GetY() + $h) > $this->PageBreakTrigger) {
          $this->AddPage();
          $this->maxln = $maxln;
        }
        if (($i == 0) && ($SlNo == 1)) {
          $this->Wrap($this->colw[$i], $c);
        }
        else {
          $this->Wrap($this->colw[$i], $row[$i]);
        }
        $i++;
      }
      if ($this->title !== 'Proforma - D') {
        $i = 0;
        $this->Ln();
        while ($i < count($this->colw)) {
          if (($i == 0) && ($SlNo == 1)) {
            $this->Wrap($this->colw[$i], $c);
          }
          else {
            $this->Cell($this->colw[$i], 10, '', 1, 0, 'C');
          }
          $i++;
        }
      }
      $c++;
      $this->Ln();
    }
    $Data->do_close();
    unset($Data);
    //$this->Write(0,$Query);
    //$this->Ln();
  }

}

?>