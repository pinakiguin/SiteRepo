<?php

function CreateSchemas() {
  $ObjDB = new MySQLiDBHelper();
  $ObjDB->ddlQuery(SQLDefs('DPRDO_Admit'));
  unset($ObjDB);
}

function SQLDefs($ObjectName) {
  $SqlDB = '';
  switch ($ObjectName) {
    case 'Visits':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
        . '`RollNo` varchar(5) DEFAULT NULL,'
        . '`Name` varchar(29) DEFAULT NULL,'
        . '`Designation` varchar(16) DEFAULT NULL,'
        . '`GP` varchar(55) DEFAULT NULL,'
        . '`ExamCenter` varchar(54) DEFAULT NULL'
        . ') ENGINE = InnoDB DEFAULT CHARSET = utf8;';
      break;
  }
  return $SqlDB;
}

?>
