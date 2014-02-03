<?php

define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
date_default_timezone_set('UTC');
$_SESSION['Ticks'] = microtime(true);

if (WebLib::GetVal($_POST, 'CmdUpload') === 'Upload') {
  include __DIR__ . '/../PHPExcel/Classes/PHPExcel.php';
  $inputFileName = $_FILES['ExcelFile']['tmp_name'];
  $inputFileType = WebLib::GetVal($_POST, 'FileType');
  //$inputFileType = 'Excel5';
  //$inputFileType = 'Excel2007';
  //$inputFileType = 'Excel2003XML';
  //$inputFileType = 'OOCalc';
  //$inputFileType = 'Gnumeric';

  $objReader = PHPExcel_IOFactory::createReader($inputFileType);

  $worksheet = $objReader->listWorksheetInfo($inputFileName);

  //echo '<h3>Worksheet Information</h3>';
  //echo '<pre>';
  //print_r($worksheet);
  $LastCol   = $worksheet[0]['lastColumnLetter'];
  $sheetname = $worksheet[0]['worksheetName'];

  //echo '</pre>';

  class FilterCells implements PHPExcel_Reader_IReadFilter {

    private $_startRow = 0;
    private $_endRow   = 0;
    private $_columns  = array();

    public function __construct($startRow,
                                $endRow,
                                $columns) {
      $this->_startRow = $startRow;
      $this->_endRow   = $endRow;
      $this->_columns  = $columns;
    }

    public function readCell($column,
                             $row,
                             $worksheetName = '') {
      if ($row >= $this->_startRow && $row <= $this->_endRow) {
        if (in_array($column, $this->_columns)) {
          return true;
        }
      }
      return false;
    }

  }

  $CellSubset = new FilterCells(1, 200, range('A', $LastCol));

  $objReader->setReadDataOnly(true);
  $objReader->setLoadSheetsOnly($sheetname);

  $objReader->setReadFilter($CellSubset);

  $objPHPExcel = $objReader->load($inputFileName);

  //$objPHPExcel   = PHPExcel_IOFactory::load($inputFileName);
  //$objPHPExcel->setReadDataOnly(true);
  $sheetData             = $objPHPExcel->getActiveSheet()
      ->toArray(null, true, true, true);
  unset($objPHPExcel);
  $_SESSION['ExcelData'] = $sheetData;
  unset($sheetData);
}

function TickCall() {
  echo date('H:i:s', microtime(true) - $_SESSION['Ticks']),
  ' Current memory usage: ', (memory_get_usage(true) / 1024 / 1024), " MB", EOL;
}

function SendJSON() {
  $ExcelJSON = json_encode(WebLib::GetVal($_SESSION, 'ExcelData', false, false),
                                          JSON_PRETTY_PRINT);
  if ($ExcelJSON !== 'null') {
    echo "<br/>JSON Length:" . strlen($ExcelJSON) . '<br/>';
    echo '<pre>' . $ExcelJSON . '</pre>';
  }
//  exit();
}

?>