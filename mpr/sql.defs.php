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
              . '`SectorID` bigint(20) NOT NULL AUTO_INCREMENT,'
              . '`SectorName` VARCHAR(100) DEFAULT NULL,'
              . '`UserMapID` INT(10) DEFAULT 1,'
              . ' PRIMARY KEY (`SectorID`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'MPR_Schemes':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`SchemeID` bigint(20) NOT NULL AUTO_INCREMENT,'
              . '`schemeName` VARCHAR(100) DEFAULT NULL,'
              . '`DeptID` INT(10),'
              . '`SectorID` INT(10),'
              . ' PRIMARY KEY (`SchemeID`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'MPR_Projects':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`DeptID` bigint(20) NOT NULL AUTO_INCREMENT,'
              . '`DeptName` VARCHAR(100) DEFAULT NULL,'
              . ' PRIMARY KEY (`DeptID`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'MPR_Projects':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`ProjectID` bigint(20) NOT NULL AUTO_INCREMENT,'
              . '`SchemeID` INT(10),'
              . '`ProjectName` VARCHAR(100) DEFAULT NULL,'
              . '`ProjectCost` INT(10),'
              . '`StartDate` date,'
              . '`AlotmentAmount` INT(10),'
              . '`AlotmentDate` date,'
              . '`TenderDate` date,'
              . '`WorkOrderDate` date,'
              . ' PRIMARY KEY (`ProjectID`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'MPR_Progress':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`ReportID` bigint(20) NOT NULL AUTO_INCREMENT,'
              . '`ReportDate` date,'
              . '`ProjectID` INT(10),'
              . '`PhysicalProgress` VARCHAR(100) DEFAULT NULL,'
              . '`FinancialProgress` VARCHAR(100) DEFAULT NULL,'
              . '`Remarks` VARCHAR(300) DEFAULT NULL,'
              . ' PRIMARY KEY (`ReportID`)'
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
