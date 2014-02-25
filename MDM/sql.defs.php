<?php

function CreateSchemas() {
  $ObjDB = new MySQLiDBHelper();
  $ObjDB->ddlQuery(SQLDefs('MDM_Blocks'));
  $ObjDB->ddlQuery(SQLDefs('MDM_Newdata'));
  $ObjDB->ddlQuery(SQLDefs('MDM_DataBlocks'));
  $ObjDB->ddlQuery(SQLDefs('MDM_SubDivision'));
  $ObjDB->ddlQuery(SQLDefs('MDM_DataSubDivision'));
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
    case 'MDM_DataBlocks':
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . 'MDM_Blocks` '
          . '(`BlockID`, `BlockName`, `SubDivID`) VALUES'
          . '(\'0bm\', \'OTHERS\', NULL),'
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
    case 'MenuData':
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . 'MenuItems` '
          . '(`AppID`,`MenuOrder`,`AuthMenu`,`Caption`,`URL`,`Activated`) VALUES'
          . '(\'MDM\', 1, 0, \'Home\', \'index.php\', 1),'
          . '(\'MDM\', 2, 1, \'NewAdd\', \'MDM/Newadd.php\', 1),'
          . '(\'MDM\', 3, 1, \'Report\', \'MDM/Report.php\', 1),'
          . '(\'MDM\', 4, 1, \'Update Data\', \'MDM/Update.php\', 1),'
          . '(\'MDM\', 5, 1, \'Total\', \'MDM/Total.php\', 1),'
          . '(\'MDM\', 6, 1, \'Log Out!\', \'login.php?LogOut=1\', 1);';
      break;
  }
  return $SqlDB;
}

?>
