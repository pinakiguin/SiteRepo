<?php

function SQLDefs($ObjectName) {
  $SqlDB = '';
  switch ($ObjectName) {
    case 'SRER_FieldNames':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'SRER_FieldNames` ('
              . '`FieldName` varchar(20) NOT NULL,'
              . '`Description` varchar(100) DEFAULT NULL,'
              . ' PRIMARY KEY (`FieldName`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'SRER_FieldNameData':
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . 'SRER_FieldNames` (`FieldName`, `Description`) VALUES'
              . '(\'ACNo\', \'AC Name\'),'
              . '(\'Action\', \'Action (Page)\'),'
              . '(\'AppName\', \'Name of Applicant\'),'
              . '(\'CountF6\', \'Form 6 Data Count\'),'
              . '(\'CountF6A\', \'Form 6A Data Count\'),'
              . '(\'CountF7\', \'Form 7 Data Count\'),'
              . '(\'CountF8\', \'Form 8 Data Count\'),'
              . '(\'CountF8A\', \'Form 8A Data Count\'),'
              . '(\'DelPersonName\', \'Name of the Person to be Deleted\'),'
              . '(\'IP\', \'IP Address\'),'
              . '(\'LastAccessTime\', \'Last Accessed On\'),'
              . '(\'LastLoginTime\', \'Last Login Time\'),'
              . '(\'LoginCount\', \'Login Count\'),'
              . '(\'ObjectorName\', \'Name of Objector\'),'
              . '(\'ObjectReason\', \'Reason of Objection\'),'
              . '(\'PartNo\', \'Part Number of Objected Person\'),'
              . '(\'ReceiptDate\', \'Date of Receipt\'),'
              . '(\'Relationship\', \'Relationship\'),'
              . '(\'RelationshipName\', \'Name of Father/ Mother/ Husband/ Others\'),'
              . '(\'SerialNoInPart\', \'Serial No. in Concerned Part\'),'
              . '(\'SlNo\', \'Serial No.\'),'
              . '(\'Status\', \'Status\'),'
              . '(\'DOB\', \'Date of Birth\'),'
              . '(\'TransName\', \'Name of Person to be Transposed\'),'
              . '(\'TransPartNo\', \'PartNo of person to be Transposed\'),'
              . '(\'TransSerialNoInPart\', \'Sl. No. of person to be Transposed\'),'
              . '(\'TransEPIC\', \'EPIC No.\'),'
              . '(\'PreResi\', \'Present residence of the person to be Transposed\'),'
              . '(\'ElectorName\', \'Name of Elector\'),'
              . '(\'ElectorPartNo\', \'Part No. of Elector\'),'
              . '(\'ElectorSerialNoInPart\', \'Serial No. of Elector in Concerned Part\'),'
              . '(\'NatureObjection\', \'Nature of Objection\'),'
              . '(\'UserName\', \'Block\');';
      break;
    case 'SRER_Form6':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'SRER_Form6` ('
              . '`RowID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,'
              . '`SlNo` int(10) DEFAULT NULL,'
              . '`PartID` int(10) DEFAULT NULL,'
              . '`ReceiptDate` DATE NULL DEFAULT NULL,'
              . '`AppName` varchar(50) DEFAULT NULL,'
              . '`RelationshipName` varchar(50) DEFAULT NULL,'
              . '`Relationship` varchar(1) DEFAULT NULL,'
              . '`DOB` DATE NULL DEFAULT NULL,'
              . '`Sex` varchar(1) NULL DEFAULT NULL,'
              . '`Status` varchar(1) DEFAULT NULL,'
              . ' PRIMARY KEY (`RowID`)'
              . ') ENGINE = InnoDB DEFAULT CHARSET = utf8;';
      break;
    case 'SRER_Form6A':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'SRER_Form6A` ('
              . '`RowID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,'
              . '`SlNo` int(10) DEFAULT NULL,'
              . '`PartID` int(10) DEFAULT NULL,'
              . '`ReceiptDate` DATE NULL DEFAULT NULL,'
              . '`AppName` varchar(50) DEFAULT NULL,'
              . '`RelationshipName` varchar(50) DEFAULT NULL,'
              . '`Relationship` varchar(1) DEFAULT NULL,'
              . '`DOB` DATE NULL DEFAULT NULL,'
              . '`Sex` varchar(1) NULL DEFAULT NULL,'
              . '`Status` varchar(1) DEFAULT NULL,'
              . ' PRIMARY KEY (`RowID`)'
              . ') ENGINE = InnoDB DEFAULT CHARSET = utf8;';
      break;
    case 'SRER_Form7':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'SRER_Form7` ('
              . '`RowID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,'
              . '`SlNo` int(10) DEFAULT NULL,'
              . '`PartID` int(10) DEFAULT NULL,'
              . '`ReceiptDate` DATE NULL DEFAULT NULL,'
              . '`ObjectorName` varchar(50) DEFAULT NULL,'
              . '`PartNo` varchar(3) DEFAULT NULL,'
              . '`SerialNoInPart` varchar(3) DEFAULT NULL,'
              . '`DelPersonName` varchar(50) DEFAULT NULL,'
              . '`ObjectReason` varchar(1) DEFAULT NULL,'
              . '`Status` varchar(1) DEFAULT NULL,'
              . ' PRIMARY KEY (`RowID`)'
              . ') ENGINE=InnoDB  DEFAULT CHARSET=utf8;';
      break;
    case 'SRER_Form8':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'SRER_Form8` ('
              . '`RowID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,'
              . '`SlNo` int(10) DEFAULT NULL,'
              . '`PartID` int(10) DEFAULT NULL,'
              . '`ReceiptDate` DATE NULL DEFAULT NULL,'
              . '`ElectorName` varchar(50) DEFAULT NULL,'
              . '`ElectorPartNo` varchar(3) DEFAULT NULL,'
              . '`ElectorSerialNoInPart` varchar(3) DEFAULT NULL,'
              . '`NatureObjection` varchar(30) DEFAULT NULL,'
              . '`Status` varchar(1) DEFAULT NULL,'
              . ' PRIMARY KEY (`RowID`)'
              . ') ENGINE = InnoDB DEFAULT CHARSET = utf8;';
      break;
    case 'SRER_Form8A':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'SRER_Form8A` ('
              . '`RowID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,'
              . '`SlNo` int(10) DEFAULT NULL,'
              . '`PartID` int(10) DEFAULT NULL,'
              . '`ReceiptDate` varchar(10) DEFAULT NULL,'
              . '`AppName` varchar(50) DEFAULT NULL,'
              . '`TransName` varchar(50) DEFAULT NULL,'
              . '`TransPartNo` varchar(3) DEFAULT NULL,'
              . '`TransSerialNoInPart` varchar(3) DEFAULT NULL,'
              . '`TransEPIC` varchar(16) DEFAULT NULL,'
              . '`PreResi` varchar(30) DEFAULT NULL,'
              . '`Status` varchar(1) DEFAULT NULL,'
              . ' PRIMARY KEY (`RowID`)'
              . ') ENGINE = InnoDB DEFAULT CHARSET = utf8;';
      break;
    case 'SRER_ACs':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'SRER_ACs` ('
              . '`ACNo` varchar(3) DEFAULT NULL,'
              . '`ACName` varchar(25) DEFAULT NULL,'
              . '`DistCode` varchar(2) DEFAULT NULL,'
              . '`UserMapID` int(5) DEFAULT 1'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'SRER_Districts':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'SRER_Districts` ('
              . '`DistCode` varchar(2) DEFAULT NULL,'
              . '`District` varchar(17) DEFAULT NULL,'
              . '`UserMapID` int(5) DEFAULT 1'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'SRER_PartMap':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'SRER_PartMap` ('
              . '`PartID` int(10) NOT NULL AUTO_INCREMENT,'
              . '`UserMapID` int(5) DEFAULT 1,'
              . '`PartNo` varchar(50) DEFAULT NULL,'
              . '`PartName` varchar(50) DEFAULT NULL,'
              . '`ACNo` varchar(3) DEFAULT NULL,'
              . ' PRIMARY KEY (`PartID`)'
              . ') ENGINE=InnoDB  DEFAULT CHARSET=utf8;';
      break;
  }
  return $SqlDB;
}

?>
