<?php

function CreateSchemas() {
  $ObjDB = new MySQLiDBHelper();
  $ObjDB->ddlQuery(SQLDefs('MPR_UserMaps'));
  $ObjDB->ddlQuery(SQLDefs('MPR_Schemes'));
  $ObjDB->ddlQuery(SQLDefs('MPR_Works'));
  $ObjDB->ddlQuery(SQLDefs('MPR_SchemeAllotments'));
  $ObjDB->ddlQuery(SQLDefs('MPR_Progress'));
  $ObjDB->ddlQuery(SQLDefs('MenuData'));
  $ObjDB->ddlQuery(SQLDefs('MPR_MappedUsers'));
  $ObjDB->ddlQuery(SQLDefs('MPR_UserWorks'));
  $ObjDB->ddlQuery(SQLDefs('MPR_WorkerSchemes'));
  $ObjDB->ddlQuery(SQLDefs('MPR_UserSchemeAllotments'));
  $ObjDB->ddlQuery(SQLDefs('MPR_SchemeWiseExpenditure'));
  $ObjDB->ddlQuery(SQLDefs('MPR_SchemeWiseAllotments'));
  $ObjDB->ddlQuery(SQLDefs('MPR_SchemeWiseFunds'));
  unset($ObjDB);
}

function SQLDefs($ObjectName) {
  $SqlDB = '';
  switch ($ObjectName) {

    case 'MPR_UserMaps':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
        . '`MprMapID` bigint NOT NULL AUTO_INCREMENT,'
        . '`UserMapID` bigint NOT NULL,'
        . '`CtrlMapID` bigint NOT NULL,'
        . '`UserLevel` VARCHAR(100) DEFAULT NULL,'
        . ' PRIMARY KEY (`MprMapID`),'
        . ' UNIQUE KEY (`UserMapID`,`CtrlMapID`)'
        . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'MPR_Schemes':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
        . '`SchemeID` bigint NOT NULL AUTO_INCREMENT,'
        . '`SchemeName` VARCHAR(100) DEFAULT NULL,'
        . '`UserMapID` bigint NOT NULL,'
        . ' PRIMARY KEY (`SchemeID`),'
        . ' FOREIGN KEY (`UserMapID`)'
        . ' REFERENCES `' . MySQL_Pre . 'MPR_UserMaps`(`UserMapID`),'
        . ' UNIQUE KEY (`SchemeName`)'
        . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'MPR_SchemeAllotments':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
        . '`AllotmentID` bigint NOT NULL AUTO_INCREMENT,'
        . '`SchemeID` bigint NOT NULL,'
        . '`Amount` bigint DEFAULT NULL,'
        . '`OrderNo` text,'
        . '`Date` date,'
        . '`Year` text NOT NULL,'
        . ' PRIMARY KEY (`AllotmentID`),'
        . ' FOREIGN KEY (`SchemeID`)'
        . ' REFERENCES `' . MySQL_Pre . 'MPR_Schemes`(`SchemeID`)'
        . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'MPR_Works':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
        . '`WorkID` bigint NOT NULL AUTO_INCREMENT,'
        . '`SchemeID` bigint NOT NULL,'
        . '`MprMapID` bigint NOT NULL,'
        . '`AllotmentAmount` bigint NOT NULL,'
        . '`WorkDescription` text NOT NULL,'
        . '`EstimatedCost` bigint NOT NULL,'
        . '`AsOnDate` date,'
        . ' PRIMARY KEY (`WorkID`),'
        . ' FOREIGN KEY (`SchemeID`)'
        . ' REFERENCES `' . MySQL_Pre . 'MPR_Schemes`(`SchemeID`),'
        . ' FOREIGN KEY (`MprMapID`)'
        . ' REFERENCES `' . MySQL_Pre . 'MPR_UserMaps`(`MprMapID`)'
        . ') ENGINE=InnoDB  DEFAULT CHARSET=utf8;';
      break;

    case 'MPR_Progress':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
        . '`ProgressID` bigint NOT NULL AUTO_INCREMENT,'
        . '`WorkID` bigint,'
        . '`Progress` tinyint DEFAULT 0,'
        . '`ExpenditureAmount` BIGINT DEFAULT 0,'
        . '`ReportDate` DATE,'
        . '`Balance` BIGINT DEFAULT 0,'
        . '`Remarks` VARCHAR(300) DEFAULT NULL,'
        . ' PRIMARY KEY (`ProgressID`),'
        . ' FOREIGN KEY (`WorkID`)'
        . ' REFERENCES `' . MySQL_Pre . 'MPR_Works`(`WorkID`)'
        . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'MenuData':
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . 'MenuItems` '
        . '(`AppID`,`MenuOrder`,`AuthMenu`,`Caption`,`URL`,`Activated`) VALUES'
        . '(\'MPR\', 1, 0, \'Home\', \'index.php\', 1),'
        . '(\'MPR\', 2, 1, \'Users\', \'mpr/Users.php\', 1),'
        . '(\'MPR\', 4, 1, \'Schemes\', \'mpr/Schemes.php\', 1),'
        . '(\'MPR\', 5, 1, \'Works\', \'mpr/Works.php\', 1),'
        . '(\'MPR\', 6, 1, \'Progress\', \'mpr/Progress.php\', 1),'
        . '(\'MPR\', 8, 1, \'Reports\', \'mpr/Reports.php\', 1),'
        . '(\'MPR\', 9, 1, \'Log Out!\', \'login.php?LogOut=1\', 1);';
      break;

    case 'MPR_UserSchemeAllotments':
      $SqlDB = 'CREATE OR REPLACE VIEW `' . MySQL_Pre . $ObjectName . '` AS '
        . 'select `A`.`SchemeID` AS `SchemeID`,`S`.`SchemeName` AS `SchemeName`,'
        . '`A`.`AllotmentID` AS `AllotmentID`,`A`.`Amount` AS `Amount`,'
        . '`A`.`OrderNo` AS `OrderNo`,`A`.`Date` AS `Date`,'
        . '`A`.`Year` AS `Year`,`S`.`UserMapID` AS `UserMapID`'
        . ' from (`' . MySQL_Pre . 'MPR_SchemeAllotments` `A` join `' . MySQL_Pre . 'MPR_Schemes` `S`'
        . ' on(`S`.`SchemeID` = `A`.`SchemeID`));';
      break;

    case 'MPR_MappedUsers':
      $SqlDB = 'CREATE OR REPLACE VIEW `' . MySQL_Pre . $ObjectName . '` AS '
        . 'select `M`.`MprMapID` AS `MprMapID`,`U`.`UserMapID` AS `UserMapID`,'
        . '`U`.`UserName` AS `UserName`,`M`.`CtrlMapID` AS `CtrlMapID`'
        . ' from (`' . MySQL_Pre . 'MPR_UserMaps` `M` join `' . MySQL_Pre . 'Users` `U`'
        . ' on(`M`.`UserMapID` = `U`.`UserMapID`));';
      break;

    /*
     * COALESCE, an SQL command that selects the first non-null from a range of values
     */
    case 'MPR_UserWorks':
      $SqlDB = 'CREATE OR REPLACE VIEW `' . MySQL_Pre . $ObjectName . '` AS '
        . 'select `W`.`WorkID` AS `WorkID`,`W`.`WorkDescription` AS `Work`,'
        . '`W`.`SchemeID` AS `SchemeID`,`M`.`UserMapID` AS `UserMapID`,'
        . '`M`.`CtrlMapID` AS `CtrlMapID`,`S`.`SchemeName` AS `SchemeName`,'
        . '`EstimatedCost`,`AsOnDate`,`W`.`AllotmentAmount` AS `Allotments`,'
        . 'COALESCE(SUM(`P`.`ExpenditureAmount`), 0) AS `Expenditure`,'
        . '`W`.`AllotmentAmount`-COALESCE(SUM(`P`.`ExpenditureAmount`), 0) AS `Balance`'
        . ' from (`' . MySQL_Pre . 'MPR_UserMaps` `M` join `' . MySQL_Pre . 'MPR_Works` `W`'
        . ' on(`M`.`MprMapID` = `W`.`MprMapID`)) join `' . MySQL_Pre . 'MPR_Schemes` `S`'
        . ' on(`S`.`SchemeID`=`W`.`SchemeID`) left join `' . MySQL_Pre . 'MPR_Progress` `P`'
        . ' on(`P`.`WorkID`=`W`.`WorkID`) Group By `W`.`WorkID`';
      break;

    case 'MPR_WorkerSchemes':
      $SqlDB = 'CREATE OR REPLACE VIEW `' . MySQL_Pre . $ObjectName . '` AS '
        . 'select `W`.`SchemeID` AS `SchemeID`,`S`.`SchemeName` AS `SchemeName`,'
        . '`M`.`UserMapID` AS `UserMapID`'
        . ' from (`' . MySQL_Pre . 'MPR_UserMaps` `M` join `' . MySQL_Pre . 'MPR_Works` `W`'
        . ' on(`M`.`MprMapID` = `W`.`MprMapID`)) join `' . MySQL_Pre . 'MPR_Schemes` `S`'
        . ' on(`S`.`SchemeID`=`W`.`SchemeID`) '
        . 'Group By `S`.`SchemeID`,`S`.`SchemeName`,`M`.`UserMapID`;';
      break;

    case 'MPR_SchemeWiseExpenditure':
      $SqlDB = 'CREATE OR REPLACE VIEW `' . MySQL_Pre . $ObjectName . '` AS '
        . 'select `A`.`Year` AS `Year`,`S`.`SchemeID` AS `SchemeID`,'
        . '`S`.`SchemeName` AS `SchemeName`,COALESCE(SUM(`P`.`ExpenditureAmount`), 0) AS `Expense` '
        . 'from (((`' . MySQL_Pre . 'MPR_Schemes` `S`'
        . ' LEFT JOIN `' . MySQL_Pre . 'MPR_SchemeAllotments` `A` on(`A`.`SchemeID` = `S`.`SchemeID`))'
        . ' LEFT JOIN `' . MySQL_Pre . 'MPR_Works` `W` on(`W`.`SchemeID` = `S`.`SchemeID`))'
        . ' LEFT JOIN `' . MySQL_Pre . 'MPR_Progress` `P` on(`W`.`WorkID` = `P`.`WorkID`))'
        . ' GROUP BY `A`.`Year`,`S`.`SchemeID`,`S`.`SchemeName`;';
      break;

    case 'MPR_SchemeWiseAllotments':
      $SqlDB = 'CREATE OR REPLACE VIEW `' . MySQL_Pre . $ObjectName . '` AS '
        . 'select `A`.`Year` AS `Year`,`S`.`SchemeID` AS `SchemeID`,'
        . '`S`.`SchemeName` AS `SchemeName`,SUM(`A`.`Amount`) AS `Funds`'
        . ' from `' . MySQL_Pre . 'MPR_Schemes` `S`'
        . ' LEFT JOIN `' . MySQL_Pre . 'MPR_SchemeAllotments` `A` on(`A`.`SchemeID` = `S`.`SchemeID`)'
        . ' GROUP BY `A`.`Year`,`S`.`SchemeID`,`S`.`SchemeName`;';
      break;

    case 'MPR_SchemeWiseFunds':
      $SqlDB = 'CREATE OR REPLACE VIEW `' . MySQL_Pre . $ObjectName . '` AS '
        . 'select `A`.`Year` AS `Year`,`A`.`SchemeID` AS `SchemeID`,'
        . '`A`.`SchemeName` AS `SchemeName`,`Funds`,`Expense`, '
        . ' `A`.`Funds`-`E`.`Expense` AS `Balance`'
        . ' from `' . MySQL_Pre . 'MPR_SchemeWiseAllotments` `A`'
        . ' LEFT JOIN `' . MySQL_Pre . 'MPR_SchemeWiseExpenditure` `E` '
        . ' on((`A`.`SchemeID` = `E`.`SchemeID`) AND (`A`.`Year`=`E`.`Year`))'
        . ' GROUP BY `A`.`Year`,`A`.`SchemeID`,`A`.`SchemeName`;';
      break;

  }
  return $SqlDB;
}

?>


