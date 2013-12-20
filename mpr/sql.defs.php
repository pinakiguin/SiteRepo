<?php

function SQLDefs($ObjectName) {
  $SqlDB = '';
  switch ($ObjectName) {
    case 'MPR_Departments':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`DeptID` bigint(20) NOT NULL AUTO_INCREMENT,'
              . '`DeptName` VARCHAR(100) DEFAULT NULL,'
              . '`UserMapID` INT(10) DEFAULT 1,'
              . ' PRIMARY KEY (`DeptID`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'MPR_Sectors':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`DeptID` bigint(20) NOT NULL AUTO_INCREMENT,'
              . '`DeptName` VARCHAR(100) DEFAULT NULL,'
              . ' PRIMARY KEY (`DeptID`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'MPR_Schemes':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`DeptID` bigint(20) NOT NULL AUTO_INCREMENT,'
              . '`DeptName` VARCHAR(100) DEFAULT NULL,'
              . ' PRIMARY KEY (`DeptID`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'MPR_Projects':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`DeptID` bigint(20) NOT NULL AUTO_INCREMENT,'
              . '`DeptName` VARCHAR(100) DEFAULT NULL,'
              . ' PRIMARY KEY (`DeptID`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'MPR_Progress':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`DeptID` bigint(20) NOT NULL AUTO_INCREMENT,'
              . '`DeptName` VARCHAR(100) DEFAULT NULL,'
              . ' PRIMARY KEY (`DeptID`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'MPR_UserMaps':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`DeptID` bigint(20) NOT NULL AUTO_INCREMENT,'
              . '`DeptName` VARCHAR(100) DEFAULT NULL,'
              . ' PRIMARY KEY (`DeptID`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
  }
  return $SqlDB;
}

?>
