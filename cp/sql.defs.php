<?php

function SQLDefs($ObjectName) {
  $SqlDB = '';
  switch ($ObjectName) {
    case 'CP_Groups':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'CP_Groups` ('
              . '`PersSL` int(11) NOT NULL,'
              . '`GroupID` varchar(4) NOT NULL,'
              . '`AssemblyCode` varchar(3) NOT NULL,'
              . 'PRIMARY KEY (`PersSL`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'CP_Blocks':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'CP_Blocks` ('
              . '`BlockCode` varchar(3) NOT NULL,'
              . '`BlockName` varchar(25) DEFAULT NULL,'
              . '`SubDivn` varchar(4) DEFAULT NULL,'
              . ' PRIMARY KEY (`BlockCode`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'CP_CountingTables':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'CP_CountingTables` ('
              . '`Assembly` varchar(3) DEFAULT NULL,'
              . '`Tables` int(3) DEFAULT NULL,'
              . ' PRIMARY KEY (`Assembly`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'CP_Personnel':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'CP_Personnel` ('
              . '`PersSL` int(10) NOT NULL AUTO_INCREMENT,'
              . '`off_code_cp` varchar(255) DEFAULT NULL,'
              . '`officer_nm` varchar(255) DEFAULT NULL,'
              . '`OFF_DESC` varchar(255) DEFAULT NULL,'
              . '`gender` varchar(255) DEFAULT NULL,'
              . '`BASICpay` double(15,5) DEFAULT NULL,'
              . '`mobile` varchar(255) DEFAULT NULL,'
              . '`STATUS` varchar(255) DEFAULT NULL,'
              . '`POSTING` varchar(2) DEFAULT NULL,'
              . '`OFFBLOCK_CODE` varchar(255) DEFAULT NULL,'
              . '`FORBLOCK_CODE` varchar(3) DEFAULT NULL,'
              . '`HOMEBLOCK_CODE` varchar(255) DEFAULT NULL,'
              . '`LastUpdated` varchar(255) DEFAULT NULL,'
              . '`Deleted` smallint(5) DEFAULT NULL,'
              . 'PRIMARY KEY `PersSL` (`PersSL`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'CP_Posting':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'CP_Posting` ('
              . '`PersSL` int(5) DEFAULT NULL,'
              . '`AssemblyCode` varchar(3) DEFAULT NULL, '
              . '`Post` int(1) DEFAULT NULL'
              . ' ) ENGINE = InnoDB DEFAULT CHARSET = utf8;';
      break;
    case 'CP_Pool':
      $SqlDB = 'CREATE OR REPLACE VIEW `' . MySQL_Pre . 'CP_Pool` AS '
              . ' Select `S`.`AssemblyCode` AS `AssemblyCode`, `S`.`PersSL` AS `PersSL`, `S`.`Post` AS `Post` '
              . ' from ((`' . MySQL_Pre . 'CP_Personnel` `P` '
              . ' join `' . MySQL_Pre . 'CP_Posting` `S` on((`P`.`PersSL` = `S`.`PersSL`))) '
              . ' left join `' . MySQL_Pre . 'CP_Groups` `G` on((`S`.`PersSL` = `G`.`PersSL`))) '
              . ' where ((`P`.`Deleted` = 0) and isnull(`G`.`PersSL`));';
      break;
  }
  return $SqlDB;
}

?>
