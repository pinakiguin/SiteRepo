<?php

function CreateSchemas() {
  $ObjDB = new MySQLiDBHelper();
  $ObjDB->ddlQuery(SQLDefs('SMS_Users'));
  unset($ObjDB);
}

function SQLDefs($ObjectName) {
  $SqlDB = '';
  switch ($ObjectName) {

    case 'SMS_Users':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName.'` ('
          . '`UserMapID` int(10) NOT NULL AUTO_INCREMENT,'
          . '`UserID` varchar(50) DEFAULT NULL,'
          . '`MobileNo` varchar(10) DEFAULT NULL,'
          . '`UserName` varchar(50) DEFAULT NULL,'
          . '`UserPass` varchar(32) DEFAULT NULL,'
          . '`CtrlMapID` int(10) NOT NULL,'
          . '`Remarks` varchar(25) DEFAULT NULL,'
          . '`HOD` varchar(80) NOT NULL,'
          . '`PhoneNo` int(10) NOT NULL,'
          . '`HODMobileNo` int(10) NOT NULL,'
          . '`WebSiteURL` varchar(64) NOT NULL,'
          . '`LoginCount` int(10) DEFAULT \'0\','
          . '`LastLoginTime` timestamp NOT NULL '
          . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,'
          . '`Registered` tinyint(1) NOT NULL,'
          . '`Activated` tinyint(1) NOT NULL,'
          . ' PRIMARY KEY (`UserMapID`)'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
  }
  return $SqlDB;
}

?>
