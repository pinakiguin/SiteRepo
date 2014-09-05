<?php

function CreateSchemas() {
  $ObjDB = new MySQLiDBHelper();
  $ObjDB->ddlQuery(SQLDefs('MPR_UserMaps'));
  $ObjDB->ddlQuery(SQLDefs('MPR_Schemes'));
  $ObjDB->ddlQuery(SQLDefs('MPR_Works'));
  $ObjDB->ddlQuery(SQLDefs('MPR_SchemeAllotments'));
  $ObjDB->ddlQuery(SQLDefs('MPR_Progress'));
  $ObjDB->ddlQuery(SQLDefs('MenuData'));
  $ObjDB->ddlQuery(SQLDefs('MPR_UserSchemeAllotments'));
  $ObjDB->ddlQuery(SQLDefs('MPR_SchemeWiseExpenditure'));
  unset($ObjDB);
}

function SQLDefs($ObjectName) {
  $SqlDB = '';
  switch ($ObjectName) {

    case 'MPR_UserMaps':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
        . '`UserMapID` bigint NOT NULL AUTO_INCREMENT,'
        . '`UserLevel` VARCHAR(100) DEFAULT NULL,'
        . ' PRIMARY KEY (`UserMapID`)'
        . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;

    case 'MPR_Schemes':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
        . '`SchemeID` bigint NOT NULL AUTO_INCREMENT,'
        . '`SchemeName` VARCHAR(100) DEFAULT NULL,'
        . '`UserMapID` bigint,'
        . ' PRIMARY KEY (`SchemeID`),'
        . ' FOREIGN KEY (`UserMapID`)'
        . ' REFERENCES `' . MySQL_Pre . 'MPR_UserMaps`(`UserMapID`)'
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
        . '`UserMapID` int NOT NULL,'
        . '`AllotmentAmount` bigint NOT NULL,'
        . '`WorkDescription` text NOT NULL,'
        . '`EstimatedCost` bigint NOT NULL,'
        . ' PRIMARY KEY (`WorkID`),'
        . ' FOREIGN KEY (`SchemeID`)'
        . ' REFERENCES `' . MySQL_Pre . 'MPR_Schemes`(`SchemeID`)'
        . ') ENGINE=InnoDB  DEFAULT CHARSET=utf8;';
      break;

    case 'MPR_Progress':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
        . '`ProgressID` bigint NOT NULL AUTO_INCREMENT,'
        . '`WorkID` bigint,'
        . '`ExpenditureAmount` BIGINT DEFAULT 0,'
        . '`Date` DATE,'
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

    case 'MPR_SchemeWiseExpenditure':
      $SqlDB = 'CREATE OR REPLACE VIEW `' . MySQL_Pre . $ObjectName . '` AS '
        . 'select `A`.`Year` AS `Year`,'
        . '`S`.`SchemeID` AS `SchemeID`,`S`.`SchemeName` AS `SchemeName`,'
        . 'sum(`A`.`Amount`) AS `Amount`,'
        . 'max(`P`.`ExpenditureAmount`) AS `ExpenditureAmount`'
        . 'from ((`' . MySQL_Pre . 'MPR_SchemeAllotments` `A` join '
        . '(`' . MySQL_Pre . 'MPR_Works` `W` left join `' . MySQL_Pre . 'MPR_Progress` `P`'
        . ' on((`W`.`WorkID` = `P`.`WorkID`)))'
        . ' on((`A`.`SchemeID` = `W`.`SchemeID`))) join'
        . ' `' . MySQL_Pre . 'MPR_Schemes` `S` on((`A`.`SchemeID` = `S`.`SchemeID`)))'
        . ' group by `A`.`Year`,`S`.`SchemeID`,`S`.`SchemeName`;';
      break;

  }
  return $SqlDB;
}
?>


