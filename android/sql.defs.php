<?php

function CreateSchemas() {
  $ObjDB = new MySQLiDBHelper();
  $ObjDB->ddlQuery(SQLDefs('SMS_Users'));
  $ObjDB->ddlQuery(SQLDefs('SMS_Groups'));
  $ObjDB->ddlQuery(SQLDefs('SMS_Messages'));
  $ObjDB->ddlQuery(SQLDefs('SMS_Contacts'));
  $ObjDB->ddlQuery(SQLDefs('SMS_Status'));
  unset($ObjDB);
}

function SQLDefs($ObjectName) {
  $SqlDB = '';
  switch ($ObjectName) {

    case 'SMS_Users':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`MobileNo` varchar(10) DEFAULT NULL,'
          . '`UserName` varchar(50) DEFAULT NULL,'
          . '`UserData` text DEFAULT NULL,'
          . '`TempData` text DEFAULT NULL,'
          . '`Designation` varchar(50) DEFAULT NULL,'
          . '`eMailID` text DEFAULT NULL,'
          . '`UsageCount` int DEFAULT 0,'
          . '`Status` enum(\'Registered\',\'Activated\',\'Inactive\') DEFAULT NULL,'
          . '`LastAccessTime` timestamp NOT NULL '
          . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,'
          . ' PRIMARY KEY (`MobileNo`)'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'SMS_Groups':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`GroupID` int NOT NULL AUTO_INCREMENT,'
          . '`GroupName` varchar(20) DEFAULT NULL,'
          . ' PRIMARY KEY (`GroupID`),'
          . ' UNIQUE KEY `GroupName` (`GroupName`)'
          . ') ENGINE=InnoDB  DEFAULT CHARSET = utf8;';
      break;

    case 'SMS_Messages':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`MessageID` int NOT NULL AUTO_INCREMENT,'
          . '`UserID` varchar(10) DEFAULT NULL,'
          . '`GroupID` int DEFAULT NULL,'
          . '`MsgText` varchar(500) DEFAULT NULL,'
          . '`SentTime` timestamp NULL DEFAULT NULL,'
          . ' PRIMARY KEY (`MessageID`)'
          . ') ENGINE=InnoDB  DEFAULT CHARSET=utf8;';
      break;

    case 'SMS_Contacts':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`ContactID` int NOT NULL AUTO_INCREMENT,'
          . '`GroupID` int DEFAULT NULL,'
          . '`ContactName` varchar(50) DEFAULT NULL,'
          . '`MobileNo` varchar(10) DEFAULT NULL,'
          . ' PRIMARY KEY (`ContactID`)'
          . ') ENGINE=InnoDB  DEFAULT CHARSET = utf8;';
      break;

    case 'SMS_Status':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`StatusID` int NOT NULL AUTO_INCREMENT,'
          . '`MessageID` int DEFAULT NULL,'
          . '`Report` text DEFAULT NULL,'
          . '`MobileNo` varchar(10) DEFAULT NULL,'
          . '`Status` text DEFAULT NULL,'
          . ' PRIMARY KEY (`StatusID`)'
          . ') ENGINE=InnoDB  DEFAULT CHARSET = utf8;';
      break;

  }
  return $SqlDB;
}

?>
