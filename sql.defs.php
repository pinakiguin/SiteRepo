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
    case 'MenuItems':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'MenuItems` ('
              . '`MenuID` int(11) NOT NULL AUTO_INCREMENT,'
              . '`ParentMenuID` int(11) NOT NULL,'
              . '`AuthMenu` tinyint(1) NOT NULL DEFAULT \'1\','
              . '`Caption` varchar(50) NOT NULL,'
              . '`URL` varchar(50) NOT NULL,'
              . ' PRIMARY KEY (`MenuID`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'MenuData':
      $SqlDB = 'INSERT INTO `WebSite_MenuItems` (`MenuID`, `ParentMenuID`, `AuthMenu`, `Caption`, `URL`) VALUES'
              . '(1, 0, 1, \'SRER\', \'srer/index.php\'),'
              . '(2, 1, 1, \'Data Entry\', \'srer/DataEntry.php\'),'
              . '(3, 2, 1, \'Reports\', \'srer/Reports.php\');';
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
    case 'CP_Groups':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'CP_Groups` ('
              . '`PersSL` int(11) NOT NULL,'
              . '`GroupID` varchar(4) NOT NULL,'
              . '`AssemblyCode` varchar(3) NOT NULL,'
              . 'PRIMARY KEY (`PersSL`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'CP_Blocks':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'CP_Blocks` ('
              . '`BlockCode` varchar(3) NOT NULL,'
              . '`BlockName` varchar(25) DEFAULT NULL,'
              . '`SubDivn` varchar(4) DEFAULT NULL,'
              . ' PRIMARY KEY (`BlockCode`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'CP_CountingTables':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'CP_CountingTables` ('
              . '`Assembly` varchar(3) DEFAULT NULL,'
              . '`Tables` int(3) DEFAULT NULL,'
              . ' PRIMARY KEY (`Assembly`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'CP_Personnel':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'CP_Personnel` ('
              . '`PersSL` int(10) NOT NULL AUTO_INCREMENT,'
              . '`off_code_cp` varchar(255) DEFAULT NULL,'
              . '`officer_nm` varchar(255) DEFAULT NULL,'
              . '`OFF_DESC` varchar(255) DEFAULT NULL,'
              . '`gender` varchar(255) DEFAULT NULL,'
              . '`BASICpay` double(15,5) DEFAULT NULL,'
              . '`mobile` varchar(255) DEFAULT NULL,'
              . '`STATUS` varchar(255) DEFAULT NULL,'
              . '`POSTING` varchar(2) DEFAULT NULL,'
              . '`OFFBLOCK_CODE` varchar(255) DEFAULT NULL,'
              . '`FORBLOCK_CODE` varchar(3) DEFAULT NULL,'
              . '`HOMEBLOCK_CODE` varchar(255) DEFAULT NULL,'
              . '`LastUpdated` varchar(255) DEFAULT NULL,'
              . '`Deleted` smallint(5) DEFAULT NULL,'
              . 'PRIMARY KEY `PersSL` (`PersSL`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'CP_Posting':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'CP_Posting` ('
              . '`PersSL` int(5) DEFAULT NULL,'
              . '`AssemblyCode` varchar(3) DEFAULT NULL, '
              . '`Post` int(1) DEFAULT NULL'
              . ' ) ENGINE = InnoDB DEFAULT CHARSET = utf8;';
      break;
    case 'CP_Pool':
      $SqlDB = 'CREATE OR REPLACE VIEW `' . MySQL_Pre . 'CP_Pool` AS '
              . ' Select `S`.`AssemblyCode` AS `AssemblyCode`, `S`.`PersSL` AS `PersSL`, `S`.`Post` AS `Post` '
              . ' from ((`' . MySQL_Pre . 'CP_Personnel` `P` '
              . ' join `' . MySQL_Pre . 'CP_Posting` `S` on((`P`.`PersSL` = `S`.`PersSL`))) '
              . ' left join `' . MySQL_Pre . 'CP_Groups` `G` on((`S`.`PersSL` = `G`.`PersSL`))) '
              . ' where ((`P`.`Deleted` = 0) and isnull(`G`.`PersSL`));';
      break;
  }
  return $SqlDB;
}

?>
