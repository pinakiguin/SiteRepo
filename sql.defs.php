<?php

function SQLDefs($ObjectName) {
  $SqlDB = '';
  switch ($ObjectName) {
    case 'Visits':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'Visits` ('
              . '`PageID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,'
              . '`PageURL` text NOT NULL,'
              . '`VisitCount` bigint(20) NOT NULL DEFAULT \'1\','
              . '`LastVisit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,'
              . '`PageTitle` text,'
              . '`VisitorIP` text NOT NULL,'
              . ' PRIMARY KEY (`PageID`)'
              . ') ENGINE = InnoDB DEFAULT CHARSET = utf8;';
      break;
    case 'Logs':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'Logs` ('
              . '`LogID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,'
              . '`SessionID` varchar(32) DEFAULT NULL,'
              . '`IP` varchar(15) DEFAULT NULL,'
              . '`Referrer` longtext,'
              . '`UserAgent` longtext,'
              . '`UserID` varchar(20) NOT NULL,'
              . '`URL` longtext,'
              . '`Action` longtext,'
              . '`Method` varchar(10) DEFAULT NULL,'
              . '`URI` longtext,'
              . '`AccessTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,'
              . '  PRIMARY KEY (`LogID`)'
              . ') ENGINE=InnoDB  DEFAULT CHARSET=utf8;';
      break;
    case 'VisitorLogs':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'VisitorLogs` ('
              . '`LogID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,'
              . '`SessionID` varchar(32) DEFAULT NULL,'
              . '`IP` varchar(15) DEFAULT NULL,'
              . '`Referrer` longtext,'
              . '`UserAgent` longtext,'
              . '`URL` longtext,'
              . '`Action` longtext,'
              . '`Method` varchar(10) DEFAULT NULL,'
              . '`URI` longtext,'
              . '`ED` DECIMAL(4,4) NOT NULL,' //DECIMAL(M,D) as M.D ; M>=D;
              . '`AccessTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,'
              . '  PRIMARY KEY (`LogID`)'
              . ') ENGINE=InnoDB  DEFAULT CHARSET=utf8;';
      break;
    case 'Uploads':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'Uploads` ('
              . '`UploadID` int(11) NOT NULL AUTO_INCREMENT,'
              . '`Dept` text NOT NULL,'
              . '`Subject` varchar(250) NOT NULL,'
              . '`Topic` int(11) NOT NULL,'
              . '`Dated` date NOT NULL,'
              . '`Expiry` date DEFAULT NULL,'
              . '`Attachment` text NOT NULL,'
              . '`size` int(11) NOT NULL,'
              . '`mime` text NOT NULL,'
              . '`file` longblob,'
              . '`UploadedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,'
              . '`Deleted` tinyint(1) NOT NULL,'
              . ' PRIMARY KEY (`UploadID`)'
              . ') ENGINE=InnoDB  DEFAULT CHARSET=utf8;';
      break;
    case 'Users':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'Users` ('
              . '`UserMapID` int(10) NOT NULL AUTO_INCREMENT,'
              . '`UserID` varchar(50) DEFAULT NULL,'
              . '`MobileNo` varchar(10) DEFAULT NULL,'
              . '`UserName` varchar(50) DEFAULT NULL,'
              . '`UserPass` varchar(32) DEFAULT NULL,'
              . '`CtrlMapID` int(10) NOT NULL,'
              . '`Remarks` varchar(25) DEFAULT NULL,'
              . '`LoginCount` int(10) DEFAULT \'0\','
              . '`LastLoginTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,'
              . '`Registered` tinyint(1) NOT NULL,'
              . '`Activated` tinyint(1) NOT NULL,'
              . ' PRIMARY KEY (`UserMapID`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'UsersData':
// Super Admin Password 'test@123'
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . 'Users`'
              . '(`UserID`, `UserName`, `UserPass`, `UserMapID`, `CtrlMapID`,`Registered`, `Activated`) '
              . 'VALUES (\'Admin\',\'Super Administrator\',\'ceb6c970658f31504a901b89dcd3e461\',1,0,1,1);';
      break;
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
              . '`DOB` DATE NULL DEFAULT NULL,'
              . '`Sex` varchar(1) NULL DEFAULT NULL,'
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
              . '`ObjectorName` varchar(50) DEFAULT NULL,'
              . '`PartNo` varchar(3) DEFAULT NULL,'
              . '`SerialNoInPart` varchar(3) DEFAULT NULL,'
              . '`ObjectReason` varchar(1) DEFAULT NULL,'
              . '`DOB` DATE NULL DEFAULT NULL,'
              . '`Sex` varchar(1) NULL DEFAULT NULL,'
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
              . '`ObjectorName` varchar(50) DEFAULT NULL,'
              . '`PartNo` varchar(3) DEFAULT NULL,'
              . '`SerialNoInPart` varchar(3) DEFAULT NULL,'
              . '`ObjectReason` varchar(1) DEFAULT NULL,'
              . '`DOB` DATE NULL DEFAULT NULL,'
              . '`Sex` varchar(1) NULL DEFAULT NULL,'
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
              . '`District` varchar(17) DEFAULT NULL'
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
    case 'SRER_PartMapData':
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . 'SRER_PartMap` (`PartID`, `PartMapID`, `PartNo`, `PartName`, `ACNo`) VALUES'
              . '(1, 1, \'001\', \'Sirni Primary School\', \'219\'),'
              . '(2, 1, \'002\', \'Sahania Shishu Shikshakendra\', \'219\');';
      break;
  }
  return $SqlDB;
}

?>
