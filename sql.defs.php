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
    case 'IntraNIC':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'IntraNIC` ('
              . '`RemoteIP` varchar(15) NOT NULL,'
              . '`LocationName` varchar(30) NOT NULL,'
              . ' PRIMARY KEY (`RemoteIP`)'
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
              . '`AppID` varchar(10) NOT NULL,'
              . '`MenuOrder` int(11) NOT NULL,'
              . '`AuthMenu` tinyint(1) NOT NULL DEFAULT \'1\','
              . '`Caption` varchar(50) NOT NULL,'
              . '`URL` varchar(50) NOT NULL,'
              . '`Activated` tinyint(1) NOT NULL DEFAULT \'1\','
              . ' PRIMARY KEY (`MenuID`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'MenuData':
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . 'MenuItems` '
              . '(`MenuID`,`AppID`,`MenuOrder`,`AuthMenu`,`Caption`,`URL`,`Activated`) VALUES'
              . '( 1, \'\', 1, 0, \'Home\', \'index.php\', 1),'
              . '( 2, \'\', 2, 0, \'Registration\', \'Register.php\', 1),'
              . '( 3, \'\', 3, 0, \'Login\', \'login.php\', 1),'
              . '( 4, \'WebSite\', 1, 0, \'Home\', \'index.php\', 1),'
              . '( 5, \'WebSite\', 2, 1, \'SRER-2014\', \'srer\', 1),'
              . '( 6, \'WebSite\', 3, 1, \'Polling Personnel 2014\', \'pp\', 0),'
              . '( 7, \'WebSite\', 4, 1, \'Counting Personnel 2013\', \'cp\', 0),'
              . '( 8, \'WebSite\', 5, 1, \'RSBY-2014\', \'rsby\', 0),'
              . '( 9, \'WebSite\', 6, 1, \'Attendance Register\', \'atnd-reg\', 0),'
              . '(10, \'WebSite\', 7, 1, \'User Profile\', \'Profile.php\', 1),'
              . '(11, \'WebSite\', 8, 1, \'Manage Users\', \'Users.php\', 1),'
              . '(12, \'WebSite\', 9, 1, \'Helpline\', \'Helpline.php\', 1),'
              . '(13, \'WebSite\',10, 1, \'User Activity\', \'AuditLogs.php\', 1),'
              . '(14, \'WebSite\',11, 1, \'Log Out!\', \'login.php?LogOut=1\', 1),'
              . '(15, \'SRER\', 1, 0, \'Home\', \'index.php\', 1),'
              . '(16, \'SRER\', 2, 1, \'Data Entry\', \'srer/DataEntry.php\', 1),'
              . '(17, \'SRER\', 3, 1, \'Admin Page\', \'srer/Admin.php\', 1),'
              . '(18, \'SRER\', 4, 1, \'Reports\', \'srer/Reports.php\', 1),'
              . '(19, \'SRER\', 5, 1, \'Assign Parts\', \'srer/Users.php\', 1),'
              . '(20, \'SRER\', 6, 1, \'Log Out!\', \'login.php?LogOut=1\', 1),'
              . '(21, \'ATND\', 1, 0, \'Home\', \'index.php\', 1),'
              . '(22, \'ATND\', 2, 1, \'Attendance Register\', \'atnd-reg/Attendance.php\', 1),'
              . '(23, \'ATND\', 3, 1, \'Reports\', \'atnd-reg/Reports.php\', 1),'
              . '(24, \'ATND\', 4, 1, \'User Profile\', \'atnd-reg/Profile.php\', 1),'
              . '(25, \'ATND\', 5, 1, \'Log Out!\', \'login.php?LogOut=1\', 1),'
              . '(26, \'PP\', 1, 0, \'Home\', \'index.php\', 1),'
              . '(27, \'PP\', 2, 1, \'Office Entry - Format PP1\', \'pp/Office.php\', 1),'
              . '(28, \'PP\', 3, 1, \'Personnel Entry - Format PP2\', \'pp/Personnel.php\', 1),'
              . '(29, \'PP\', 4, 1, \'Randomization\', \'pp/GroupPP.php\', 1),'
              . '(30, \'PP\', 5, 1, \'Reports\', \'pp/Reports.php\', 1),'
              . '(31, \'PP\', 6, 1, \'Log Out!\', \'login.php?LogOut=1\', 1),'
              . '(32, \'CP\', 1, 0, \'Home\', \'index.php\', 1),'
              . '(34, \'CP\', 2, 1, \'Counting Personnel Randomization\', \'cp/GroupCP.php\', 1),'
              . '(34, \'CP\', 3, 1, \'Reports\', \'cp/Reports.php\', 1),'
              . '(35, \'CP\', 4, 1, \'Log Out!\', \'login.php?LogOut=1\', 1);';
      break;
    case 'MenuACL':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'MenuACL` ('
              . '`AclID` int(11) NOT NULL AUTO_INCREMENT,'
              . '`MenuID` int(11) NOT NULL,'
              . '`UserMapID` int(11) NOT NULL,'
              . '`Activated` tinyint(1) NOT NULL DEFAULT \'1\','
              . ' PRIMARY KEY (`AclID`),'
              . ' UNIQUE KEY `UserMenu` (`MenuID`,`UserMapID`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'RestrictedMenus':
      $SqlDB = 'CREATE OR REPLACE VIEW `' . MySQL_Pre . 'RestrictedMenus` AS '
              . ' SELECT `URL`,`UserMapID` FROM `' . MySQL_Pre . 'MenuItems` `M` '
              . ' JOIN `' . MySQL_Pre . 'MenuACL` `U` ON `U`.`MenuID`=`M`.`MenuID`'
              . ' WHERE `M`.`Activated`=1 AND `U`.`Activated`=1';
      break;
    case 'Helpline':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'Helpline` ('
              . '`HelpID` bigint(20) NOT NULL AUTO_INCREMENT,'
              . '`IP` varchar(15) NOT NULL,'
              . '`SessionID` varchar(32) NOT NULL,'
              . '`UserMapID` bigint(20) NOT NULL,'
              . '`TxtQry` varchar(1024) NOT NULL,'
              . '`Replied` int(1) NOT NULL DEFAULT \'0\','
              . '`ReplyTxt` varchar(1024) DEFAULT NULL,'
              . '`QryTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,'
              . '`ReplyTime` timestamp NULL DEFAULT NULL,'
              . 'PRIMARY KEY (`HelpID`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
  }
  return $SqlDB;
}

?>
