<?php

function CreateSchemas() {
  $ObjDB = new MySQLiDBHelper();
  $ObjDB->ddlQuery(SQLDefs('SMS_Templates'));
  $ObjDB->ddlQuery(SQLDefs('SMS_Contacts'));
  $ObjDB->ddlQuery(SQLDefs('SMS_Logs'));
  $ObjDB->ddlQuery(SQLDefs('MenuData'));
  unset($ObjDB);
}

function SQLDefs($ObjectName) {
  $SqlDB = '';
  switch ($ObjectName) {
    case 'SMS_Templates':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`GroupID` BIGINT(20) ZEROFILL NOT NULL AUTO_INCREMENT,'
          . '`GroupName` VARCHAR(50) DEFAULT NULL,'
          . '`Msg` VARCHAR(160) DEFAULT NULL,'
          . '`Dlr` BOOLEAN NOT NULL DEFAULT FALSE,'
          . '`UserMapID` INT(10) DEFAULT 1,'
          . ' PRIMARY KEY (`GroupID`)'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'SMS_Contacts':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`ContactID` BIGINT(20) ZEROFILL NOT NULL AUTO_INCREMENT,'
          . '`ContactName` VARCHAR(160) DEFAULT NULL,'
          . '`MobileNo` VARCHAR(10) DEFAULT NULL,'
          . '`DataJSON` VARCHAR(4096) DEFAULT NULL,'
          . '`UserMapID` INT(10) DEFAULT 1,'
          . ' PRIMARY KEY (`ContactID`)'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'SMS_Logs':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`MsgID` BIGINT(20) ZEROFILL NOT NULL AUTO_INCREMENT,'
          . '`ContactID` INT(10) NOT NULL,'
          . '`GroupID` INT(10) NOT NULL,'
          . '`Sent` enum("Composed","Ready","Sent","Delivered"),'
          . '`SentOn` TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
          . ' ON UPDATE CURRENT_TIMESTAMP,'
          . '`Status` VARCHAR(1024),'
          . '`UserMapID` INT(10) DEFAULT 1,'
          . ' PRIMARY KEY (`MsgID`)'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'MenuData':
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . 'MenuItems` '
          . '(`AppID`,`MenuOrder`,`AuthMenu`,`Caption`,`URL`,`Activated`) VALUES'
          . '(\'SMS\', 1, 0, \'Home\', \'index.php\', 1),'
          . '(\'SMS\', 2, 1, \'SMS Template\', \'BulkSMS/Compose.php\', 1),'
          . '(\'SMS\', 3, 1, \'Send Bulk SMS\', \'BulkSMS/SendSMS.php\', 1),'
          . '(\'SMS\', 4, 1, \'Delivery Status\', \'BulkSMS/Status.php\', 1),'
          . '(\'SMS\', 5, 1, \'Reports\', \'BulkSMS/Reports.php\', 1),'
          . '(\'SMS\', 6, 1, \'Log Out!\', \'login.php?LogOut=1\', 1);';
      break;
  }
  return $SqlDB;
}

?>
