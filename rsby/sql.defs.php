<?php

function SQLDefs($ObjectName) {
  $SqlDB = '';
  switch ($ObjectName) {
    case 'RSBY_MstBlock':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`SerialNo` int(10) NOT NULL,'
              . '`StateCode` varchar(2) NOT NULL,'
              . '`DistrictCode` varchar(2) NOT NULL,'
              . '`BlockCode` varchar(7) NOT NULL,'
              . '`BlockName` varchar(50) DEFAULT NULL,'
              . '`Status` tinyint(1) NOT NULL,'
              . 'PRIMARY KEY (`StateCode`, `DistrictCode`, `BlockCode`)'
              . ') ENGINE = InnoDB DEFAULT CHARSET = utf8;';
      break;
    case 'RSBY_MstCategory':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`SerialNo` int(10) NOT NULL,'
              . '`CatCode` varchar(2) NOT NULL,'
              . '`CatName` varchar(50) DEFAULT NULL'
              . ') ENGINE = InnoDB DEFAULT CHARSET = utf8;';
      break;
    case 'RSBY_MstPanchayatTown':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`SerialNo` int(10) NOT NULL,'
              . '`StateCode` varchar(2) NOT NULL,'
              . '`DistrictCode` varchar(2) NOT NULL,'
              . '`BlockCode` varchar(7) NOT NULL,'
              . '`Panchayat_TownCode` varchar(10) NOT NULL,'
              . '`Panchayat_TownName` varchar(50) DEFAULT NULL,'
              . '`Status` tinyint(1) NOT NULL'
              . ') ENGINE = InnoDB DEFAULT CHARSET = utf8;';
      break;
    case 'RSBY_MstRelation':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`SerialNo` int(10) NOT NULL,'
              . '`RelationCode` int(10) NOT NULL,'
              . '`RelationDescription` varchar(50) DEFAULT NULL'
              . ') ENGINE = InnoDB DEFAULT CHARSET = utf8;';
      break;
    case 'RSBY_MstVillage':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`SerialNo` int(10) NOT NULL,'
              . '`StateCode` varchar(2) NOT NULL,'
              . '`DistrictCode` varchar(2) NOT NULL,'
              . '`BlockCode` varchar(7) NOT NULL,'
              . '`Panchayat_TownCode` varchar(10) NOT NULL,'
              . '`VillageCode` varchar(8) NOT NULL,'
              . '`VillageName` varchar(50) DEFAULT NULL,'
              . '`LocationType` varchar(1) DEFAULT NULL,'
              . '`Status` tinyint(1) NOT NULL'
              . ') ENGINE = InnoDB DEFAULT CHARSET = utf8;';
      break;
    case 'RSBY_TxnDependents':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`URN` varchar(17) DEFAULT NULL,'
              . '`MemberID` int(10) DEFAULT NULL,'
              . '`MemberName` varchar(75) DEFAULT NULL,'
              . '`Gender` int(10) DEFAULT NULL,'
              . '`Age` int(10) DEFAULT NULL,'
              . '`RelationCode` int(10) DEFAULT NULL,'
              . '`Status` tinyint(1) NOT NULL'
              . ') ENGINE = InnoDB DEFAULT CHARSET = utf8;';
      break;
    case 'RSBY_TxnEnrollment':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`URN` varchar(17) NOT NULL,'
              . '`EName` varchar(75) DEFAULT NULL,'
              . '`Father_HusbandName` varchar(75) DEFAULT NULL,'
              . '`Door_HouseNo` varchar(50) DEFAULT NULL,'
              . '`VillageCode` varchar(8) NOT NULL,'
              . '`Panchayat_TownCode` varchar(10) NOT NULL,'
              . '`BlockCode` varchar(7) NOT NULL,'
              . '`DistrictCode` varchar(2) NOT NULL,'
              . '`StateCode` varchar(2) NOT NULL,'
              . '`RSBYType` varchar(2) DEFAULT NULL,'
              . '`CatCode` varchar(2) DEFAULT NULL,'
              . '`BPLCitizen` varchar(2) DEFAULT NULL,'
              . '`Minority` varchar(1) DEFAULT NULL,'
              . ') ENGINE = InnoDB DEFAULT CHARSET = utf8;';
      break;
  }
  return $SqlDB;
}

?>
