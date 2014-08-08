<?php

function CreateSchemas() {
  $ObjDB = new MySQLiDBHelper();
  $ObjDB->ddlQuery(SQLDefs('DRDC_Districts'));
  $ObjDB->ddlQuery(SQLDefs('DRDC_Subdivisions'));
  $ObjDB->ddlQuery(SQLDefs('DRDC_Blocks'));
  $ObjDB->ddlQuery(SQLDefs('DRDC_GPs'));
  $ObjDB->ddlQuery(SQLDefs('DRDC_Banks'));
  $ObjDB->ddlQuery(SQLDefs('DRDC_Branches'));

  $ObjDB->ddlQuery(SQLDefs('DRDC_SHGroups'));
  $ObjDB->ddlQuery(SQLDefs('DRDC_Members'));
  $ObjDB->ddlQuery(SQLDefs('DRDC_GroupStatus'));
  $ObjDB->ddlQuery(SQLDefs('DRDC_BankACs'));

  $ObjDB->ddlQuery(SQLDefs('DRDC_Savings'));
  $ObjDB->ddlQuery(SQLDefs('DRDC_Sansads'));
  $ObjDB->ddlQuery(SQLDefs('DRDC_RFs'));

  $ObjDB->ddlQuery(SQLDefs('DRDC_MenuData'));
  $ObjDB->ddlQuery(SQLDefs('DRDC_Helpline'));
  unset($ObjDB);
}

function SQLDefs($ObjectName) {
  $SqlDB = 'Select 1';
  switch ($ObjectName) {
    case 'DRDC_Districts':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`DistCode` int(2) DEFAULT NULL,'
          . '`DistName` varchar(17) DEFAULT NULL'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'DRDC_Subdivisions':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`DistCode` int(2) DEFAULT NULL,'
          . '`SubDivCode` int(2) DEFAULT NULL,'
          . '`SubDivName` varchar(9) DEFAULT NULL'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'DRDC_Blocks':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`DistCode` int(2) DEFAULT NULL,'
          . '`SubDivCode` int(2) DEFAULT NULL,'
          . '`BlockCode` int(2) DEFAULT NULL,'
          . '`BlockName` varchar(16) DEFAULT NULL'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'DRDC_GPs':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`DistCode` int(2) DEFAULT NULL,'
          . '`SubDivCode` int(2) DEFAULT NULL,'
          . '`BlockCode` int(2) DEFAULT NULL,'
          . '`GPCode` int(4) DEFAULT NULL,'
          . '`GPName` varchar(18) DEFAULT NULL'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'DRDC_Banks':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`BankCode` varchar(4) DEFAULT NULL,'
          . '`BankName` varchar(38) DEFAULT NULL'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'DRDC_Branches':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`BankCode` varchar(4) DEFAULT NULL,'
          . '`IFSC` varchar(12) DEFAULT NULL,'
          . '`BranchCode` varchar(6) DEFAULT NULL,'
          . '`BranchName` varchar(11) DEFAULT NULL'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'DRDC_SHGroups':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`SHGCode` int(9) DEFAULT NULL,'
          . '`SHGName` varchar(36) DEFAULT NULL,'
          . '`FormedOn` DATE NULL DEFAULT NULL,'
          . '`SBAccCode` int(3) DEFAULT NULL,'
          . '`SHGType` varchar(6) DEFAULT NULL,'
          . '`Scheme` varchar(6) DEFAULT NULL,'
          . '`OldSHGCode` int(5) DEFAULT NULL,'
          . '`UpaSanghaCode` varchar(10) DEFAULT NULL,'
          . '`SanghaCode` varchar(10) DEFAULT NULL'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'DRDC_Members':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`SHGCode` int(7) DEFAULT NULL,'
          . '`MemberCode` int(2) DEFAULT NULL,'
          . '`MemberName` varchar(28) DEFAULT NULL,'
          . '`FHName` varchar(19) DEFAULT NULL,'
          . '`Gender` varchar(1) DEFAULT NULL,'
          . '`Category` varchar(3) DEFAULT NULL,'
          . '`PWD` varchar(2) DEFAULT NULL,'
          . '`BPL` varchar(26) DEFAULT NULL,'
          . '`EPICNo` varchar(10) DEFAULT NULL,'
          . '`Activity` varchar(11) DEFAULT NULL,'
          . '`MonthlyIncome` int(5) DEFAULT NULL,'
          . '`MIAsOn` varchar(10) DEFAULT NULL'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'DRDC_GroupStatus':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`SHGCode` int(9) DEFAULT NULL,'
          . '`StatusOn` varchar(11) DEFAULT NULL,'
          . '`Status` varchar(7) DEFAULT NULL,'
          . '`Stage` varchar(15) DEFAULT NULL,'
          . '`RegularSavings` varchar(3) DEFAULT NULL,'
          . '`RegularMeeting` varchar(3) DEFAULT NULL,'
          . '`InternalLending` varchar(3) DEFAULT NULL,'
          . '`RegularRecovery` varchar(3) DEFAULT NULL,'
          . '`MaintenanceOfBooks` varchar(3) DEFAULT NULL'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'DRDC_BankACs':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`BankAccCode` int(3) DEFAULT NULL,'
          . '`SHGCode` int(9) DEFAULT NULL,'
          . '`AccType` varchar(10) DEFAULT NULL,'
          . '`BankCode` varchar(4) DEFAULT NULL,'
          . '`BranchCode` varchar(6) DEFAULT NULL,'
          . '`IFSC` varchar(12) DEFAULT NULL,'
          . '`AccountNo` varchar(13) DEFAULT NULL,'
          . '`OpenedOn` varchar(11) DEFAULT NULL'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'DRDC_Savings':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`SavingsID` int(3) DEFAULT NULL,'
          . '`SHGCode` int(9) DEFAULT NULL,'
          . '`SBAccCode` int(3) DEFAULT NULL,'
          . '`Balance` int(5) DEFAULT NULL,'
          . '`LastTrDate` varchar(11) DEFAULT NULL'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'DRDC_Sansads':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`GPCode` int(4) DEFAULT NULL,'
          . '`SansadCode` int(6) DEFAULT NULL,'
          . '`SansadName` varchar(16) DEFAULT NULL'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'DRDC_Sangha':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`GPCode` int(4) DEFAULT NULL,'
          . '`SanghaCode` varchar(5) DEFAULT NULL,'
          . '`SanghaName` varchar(15) DEFAULT NULL,'
          . '`SanghaFormedOn` varchar(10) DEFAULT NULL,'
          . '`SanghaGrade` varchar(1) DEFAULT NULL,'
          . '`LastGradeOn` varchar(10) DEFAULT NULL,'
          . '`LastAGMOn` varchar(10) DEFAULT NULL'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'DRDC_RFs':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`SHGCode` int(9) DEFAULT NULL,'
          . '`RFAmount` int(5) DEFAULT NULL,'
          . '`PaymentDate` varchar(10) DEFAULT NULL,'
          . '`ModeOfPayment` varchar(9) DEFAULT NULL'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'DRDC_MenuData':
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . 'MenuItems` '
          . '(`AppID`,`MenuOrder`,`AuthMenu`,`Caption`,`URL`,`Activated`) VALUES'
          . '(\'DRDC\', 1, 0, \'Home\', \'index.php\', 1),'
          . '(\'DRDC\', 2, 1, \'Master Data\', \'drdc/SHGData.php\', 1),'
          . '(\'DRDC\', 3, 1, \'SHGs\', \'drdc/SHGroups.php\', 1),'
          . '(\'DRDC\', 4, 1, \'Reports\', \'drdc/Reports.php\', 1),'
          . '(\'DRDC\', 5, 1, \'Helpline\', \'drdc/Helpline.php\', 1),'
          . '(\'DRDC\', 6, 1, \'Log Out!\', \'login.php?LogOut=1\', 1);';
      break;

    case 'DRDC_Helpline':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
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
