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
  }
  return $SqlDB;
}

?>
