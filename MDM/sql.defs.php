<?php

function CreateSchemas() {
  $ObjDB = new MySQLiDBHelper();
  $ObjDB->ddlQuery(SQLDefs('MDM_Blocks'));
  $ObjDB->ddlQuery(SQLDefs('MDM_Newdata'));
  $ObjDB->ddlQuery(SQLDefs('MDM_DataBlocks'));
  $ObjDB->ddlQuery(SQLDefs('MDM_SubDivision'));
  $ObjDB->ddlQuery(SQLDefs('MDM_DataSubDivision'));
  $ObjDB->ddlQuery(SQLDefs('MDM_MealData'));
  $ObjDB->ddlQuery(SQLDefs('MDM_SMS'));
  $ObjDB->ddlQuery(SQLDefs('MDM_SMSData'));
  $ObjDB->ddlQuery(SQLDefs('MenuData'));
  unset($ObjDB);
}

function SQLDefs($ObjectName) {
  $SqlDB = '';
  switch ($ObjectName) {
    case 'MDM_Blocks':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`BlockID` varchar(3) NOT NULL,'
          . '`BlockName` varchar(25) DEFAULT NULL,'
          . '`SubDivID` varchar(4) DEFAULT NULL,'
          . ' PRIMARY KEY (`BlockID`)'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'MDM_Newdata':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`SchoolID` int(10) NOT NULL AUTO_INCREMENT,'
          . '`SubDivID` VARCHAR(5) DEFAULT NULL,'
          . '`BlockID` VARCHAR(5) DEFAULT NULL,'
          . '`Schoolname` VARCHAR(100) DEFAULT NULL,'
          . '`TypeID` VARCHAR(100) DEFAULT NULL,'
          . '`NameID` VARCHAR(100) DEFAULT NULL,'
          . '`Mobile` int(10) DEFAULT NULL,'
          . '`DesigID` VARCHAR(10) DEFAULT NULL,'
          . '`TotalStudent` int(10) DEFAULT NULL,'
          . '`RegDate` VARCHAR(10),'
          . '`UserMapID` INT(10) DEFAULT 1,'
          . ' PRIMARY KEY (`SchoolID`),'
          . 'UNIQUE KEY `Schoolname` (`Schoolname`,`SubDivID`,`BlockID`),'
          . 'UNIQUE KEY `NameID` (`NameID`,`Schoolname`,`BlockID`)'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';

      break;

    case 'MDM_MealData':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`SchoolID` int(10) DEFAULT NULL,'
          . '`Meal` int(10) DEFAULT NULL,'
          . '`ReportDate` Date DEFAULT NULL,'
          . '`UserMapID` INT(10) DEFAULT 1,'
          . 'UNIQUE KEY `Report` (`SchoolID`,`ReportDate`)'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';

      break;
    case 'MDM_DataBlocks':
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . 'MDM_Blocks` '
          . '(`BlockID`, `BlockName`, `SubDivID`) VALUES'
          . '(\'B01\', \'MIDNAPORE SADAR\', \'1501\'),'
          . '(\'B02\', \'KESHPUR\', \'1501\'),'
          . '(\'B03\', \'SALBONI\', \'1501\'),'
          . '(\'B04\', \'GARHBETA-I\', \'1501\'),'
          . '(\'B05\', \'GARHBETA-II\', \'1501\'),'
          . '(\'B06\', \'GARHBETA-III\', \'1501\'),'
          . '(\'B07\', \'KHARAGPUR-I\', \'1502\'),'
          . '(\'B08\', \'KHARAGPUR-II\', \'1502\'),'
          . '(\'B09\', \'DEBRA\', \'1502\'),'
          . '(\'B10\', \'SABONG\', \'1502\'),'
          . '(\'B11\', \'PINGLA\', \'1502\'),'
          . '(\'B12\', \'KESHIARY\', \'1502\'),'
          . '(\'B13\', \'DANTAN-I\', \'1502\'),'
          . '(\'B14\', \'DANTAN-II\', \'1502\'),'
          . '(\'B15\', \'NARAYANGARH\', \'1502\'),'
          . '(\'B16\', \'MOHANPUR\', \'1502\'),'
          . '(\'B17\', \'GHATAL\', \'1503\'),'
          . '(\'B18\', \'CHANDRAKONA-I\', \'1503\'),'
          . '(\'B19\', \'CHANDRAKONA-II\', \'1503\'),'
          . '(\'B20\', \'DASPUR-I\', \'1503\'),'
          . '(\'B21\', \'DASPUR-II\', \'1503\'),'
          . '(\'B22\', \'JHARGRAM\', \'1504\'),'
          . '(\'B23\', \'BINPUR-I\', \'1504\'),'
          . '(\'B24\', \'BINPUR-II\', \'1504\'),'
          . '(\'B25\', \'GOPIBALLAVPUR-I\', \'1504\'),'
          . '(\'B26\', \'GOPIBALLAVPUR-II\', \'1504\'),'
          . '(\'B27\', \'NAYAGRAM\', \'1504\'),'
          . '(\'B28\', \'SANKRAIL\', \'1504\'),'
          . '(\'B29\', \'JAMBONI\', \'1504\'),'
          . '(\'M01\', \'MIDNAPORE MUNICIPALITY\', \'1501\'),'
          . '(\'M02\', \'KHARAGPUR MUNICIPALITY\', \'1502\'),'
          . '(\'M03\', \'JHARGRAM MUNICIPALITY\', \'1504\'),'
          . '(\'M04\', \'CHANDRAKONA MUNICIPALITY\', \'1503\'),'
          . '(\'M05\', \'KHIRPAI MUNICIPALITY\', \'1503\'),'
          . '(\'M06\', \'RAMJIBANPUR MUNICIPALITY\', \'1503\'),'
          . '(\'M07\', \'KHARAR MUNICIPALITY\', \'1503\'),'
          . '(\'M08\', \'GHATAL MUNICIPALITY\', \'1503\');';
      break;
    case 'MDM_SubDivision':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`SubDivID` varchar(5) NOT NULL,'
          . '`SubDivName` varchar(25) DEFAULT NULL,'
          . ' PRIMARY KEY (`SubDivID`)'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'MDM_DataSubDivision':
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . 'MDM_SubDivision` '
          . '(`SubDivID`, `SubDivName`) VALUES'
          . '(\'1501\', \'MIDNAPORE SADAR\'),'
          . '(\'1502\', \'KHARAGPUR\'),'
          . '(\'1503\', \'GHATAL\'),'
          . '(\'1504\', \'JHARGRAM\');';
      break;
    case 'MDM_SMS':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`MsgID` bigint(20) NOT NULL AUTO_INCREMENT,'
          . '`MsgType` enum(\'SMS\',\'Delivery Report\',\'\',\'\') NOT NULL DEFAULT \'SMS\','
          . '`IP` text NOT NULL,`MsgData` longtext NOT NULL,'
          . '`ReadUnread` tinyint(1) NOT NULL DEFAULT \'0\','
          . '`ReceivedOn` '
          . 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,'
          . 'PRIMARY KEY (`MsgID`)) ENGINE=InnoDB '
          . ' DEFAULT CHARSET=latin1 AUTO_INCREMENT=1138 ;';
      break;

    case 'MDM_SMSData':
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . 'MDM_SMS`'
          . ' (`MsgID`, `MsgType`, `IP`, `MsgData`, `ReadUnread`, `ReceivedOn`) VALUES'
          . '(1, \'SMS\', \'10.173.168.20\', \'[]\', 0, \'2013-03-12 09:52:58\'),
(2, \'SMS\', \'10.173.168.20\', \'[]\', 0, \'2013-03-13 08:50:47\'),
(3, \'SMS\', \'10.173.168.20\', \'[]\', 0, \'2013-03-13 08:52:00\'),
(4, \'SMS\', \'10.173.168.20\', \'[]\', 0, \'2013-03-13 08:52:06\'),
(5, \'SMS\', \'10.1.16.148\', \'[]\', 0, \'2013-03-14 04:24:59\'),
(6, \'SMS\', \'164.100.14.9\', \'[]\', 0, \'2013-03-14 17:47:39\'),
(7, \'SMS\', \'164.100.14.9\', \'{&quot;
      Sender&quot;
      :&quot;
      918348691719&quot;
      , &quot;
      Message&quot;
      :&quot;
      Life is beautiful.&quot;
      , &quot;
      Destination&quot;
      :&quot;
      919211728082&quot;
      , &quot;
      Time&quot;
      :&quot;
      14-03-2013-23.14.37&quot;
      }\', 0, \'2013-03-14 17:53:51\'),
(8, \'SMS\', \'164.100.14.9\', \'{&quot;
      Sender&quot;
      :&quot;
      919830668086&quot;
      , &quot;
      Message&quot;
      :&quot;
      Hi.....&quot;
      , &quot;
      Destination&quot;
      :&quot;
      919211728082&quot;
      , &quot;
      Time&quot;
      :&quot;
      15-03-2013-10.48.52&quot;
      }\', 0, \'2013-03-15 05:28:05\'),
(9, \'SMS\', \'10.26.19.4\', \'[]\', 0, \'2013-04-11 11:42:10\'),
(10, \'SMS\', \'10.26.19.4\', \'[]\', 0, \'2013-04-11 11:42:13\');';
      break;

    case 'MenuData':
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . 'MenuItems` '
          . '(`AppID`,`MenuOrder`,`AuthMenu`,`Caption`,`URL`,`Activated`) VALUES'
          . '(\'MDM\', 1, 0, \'Home\', \'index.php\', 1),'
          . '(\'MDM\', 2, 1, \'New Registration\', \'MDM/Newadd.php\', 1),'
          . '(\'MDM\', 3, 1, \'Total Report\', \'MDM/Report.php\', 1),'
          . '(\'MDM\', 4, 1, \'School Report\', \'MDM/School.php\', 1),'
          . '(\'MDM\', 6, 1, \'Log Out!\', \'login.php?LogOut=1\', 1);';
      break;
  }
  return $SqlDB;
}

?>
