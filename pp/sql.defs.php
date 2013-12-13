<?php

function SQLDefs($ObjectName) {
  $SqlDB = '';
  switch ($ObjectName) {
    case 'PP_Districts':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`DistCode` varchar(2) DEFAULT NULL,'
              . '`DistrictName` varchar(17) DEFAULT NULL,'
              . '`UserMapID` int(5) DEFAULT 1'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'PP_DataDistricts':
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . 'PP_Districts` (`DistCode`, `DistrictName`) VALUES'
              . '(\'15\', \'Paschim Medinipur\');';
      break;
    case 'PP_SubDivns':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`SubDivnCode` varchar(4) NOT NULL,'
              . '`SubDivnName` varchar(25) DEFAULT NULL,'
              . '`DistCode` varchar(2) DEFAULT NULL,'
              . ' PRIMARY KEY (`SubDivnCode`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'PP_DataSubDivns':
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . 'PP_SubDivns` (`SubDivnCode`, `SubDivnName`,`DistCode`) VALUES'
              . '(\'1501\', \'Sadar\', \'15\'),'
              . '(\'1502\', \'Kharagpur\', \'15\'),'
              . '(\'1503\', \'Ghatal\', \'15\'),'
              . '(\'1504\', \'Jhargram\', \'15\');';
      break;
    case 'PP_Blocks':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`BlockCode` varchar(3) NOT NULL,'
              . '`BlockName` varchar(25) DEFAULT NULL,'
              . '`SubDivnCode` varchar(4) DEFAULT NULL,'
              . ' PRIMARY KEY (`BlockCode`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'PP_DataBlocks':
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . 'PP_Blocks` (`BlockCode`, `BlockName`, `SubDivnCode`) VALUES'
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
    case 'PP_Status':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`StatusCode` varchar(2) NOT NULL,'
              . '`StatusDesc` varchar(25) DEFAULT NULL,'
              . ' PRIMARY KEY (`StatusCode`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'PP_DataStatus':
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . 'PP_Status` (`StatusCode`,`StatusDesc`) VALUES'
              . '( \'01\', \'Central Government\'),'
              . '( \'02\', \'State Government\'),'
              . '( \'03\', \'Central Govt. Undertaking\'),'
              . '( \'04\', \'State Govt. Undertaking\'),'
              . '( \'05\', \'Local Bodies\'),'
              . '( \'06\', \'Govt. Aided Organization\'),'
              . '( \'07\', \'Autonomous Body\'),'
              . '( \'08\', \'Others (Please Specify)\');';
      break;
    case 'PP_InstType':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`TypeCode` varchar(2) NOT NULL,'
              . '`TypeDesc` varchar(25) DEFAULT NULL,'
              . ' PRIMARY KEY (`TypeCode`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'PP_DataInstType':
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . 'PP_InstType` (`TypeCode`,`TypeDesc`) VALUES'
              . '( \'01\', \'Department/Directorate/Other subordinate Government Office\'),'
              . '( \'02\', \'Railways\'),'
              . '( \'03\', \'BSNL\'),'
              . '( \'04\', \'Bank\'),'
              . '( \'05\', \'L1C/GIC etc Financial Institution\'),'
              . '( \'06\', \'Income Tax/Customs or other Revenue Collection Authority\'),'
              . '( \'07\', \'Primary School\'),'
              . '( \'08\', \'Secondary/Higher Secondary School\'),'
              . '( \'09\', \'College\'),'
              . '( \'10\', \'University\'),'
              . '( \'11\', \'Water/Electricity Supply\'),'
              . '( \'12\', \'Panchayat Body\'),'
              . '( \'13\', \'Municipal Body\'),'
              . '( \'14\', \'Others (Please Specify)\');';
      break;
    case 'PP_PoliceStns':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`PSCode` varchar(2) NOT NULL,'
              . '`PSName` varchar(25) DEFAULT NULL,'
              . '`SubDivnCode` varchar(4) DEFAULT NULL,'
              . ' PRIMARY KEY (`PSCode`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'PP_DataPoliceStns':
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . 'PP_PoliceStns` (`PSCode`, `PSName`, `SubDivnCode`) VALUES'
              . '(\'01\', \'KOTWALI\', \'1501\'),'
              . '(\'02\', \'SALBONI\', \'1501\'),'
              . '(\'03\', \'KESHPUR\', \'1501\'),'
              . '(\'04\', \'GARBETA\', \'1501\'),'
              . '(\'05\', \'GOALTORE\', \'1501\'),'
              . '(\'06\', \'KHARAGPUR(L)\', \'1502\'),'
              . '(\'07\', \'KHARAGPUR(R )\', \'1502\'),'
              . '(\'08\', \'DEBRA\', \'1502\'),'
              . '(\'09\', \'PINGLA\', \'1502\'),'
              . '(\'10\', \'KESHIARY\', \'1502\'),'
              . '(\'11\', \'DANTAN\', \'1502\'),'
              . '(\'12\', \'BELDA\', \'1502\'),'
              . '(\'13\', \'NARAYANGARH\', \'1502\'),'
              . '(\'14\', \'MOHANPUR\', \'1502\'),'
              . '(\'15\', \'SABONG\', \'1502\'),'
              . '(\'16\', \'CHANDRAKONA\', \'1503\'),'
              . '(\'17\', \'GHATAL\', \'1503\'),'
              . '(\'18\', \'DASPUR\', \'1503\'),'
              . '(\'19\', \'JHARGRAM\', \'1504\'),'
              . '(\'20\', \'BELPAHARI\', \'1504\'),'
              . '(\'21\', \'BINPUR\', \'1504\'),'
              . '(\'22\', \'LALGARH\', \'1504\'),'
              . '(\'23\', \'JAMBONI\', \'1504\'),'
              . '(\'24\', \'NAYAGRAM\', \'1504\'),'
              . '(\'25\', \'SANKRAIL\', \'1504\'),'
              . '(\'26\', \'GOPIBALLAVPUR\', \'1504\'),'
              . '(\'27\', \'BELIABERAH\', \'1504\'),'
              . '(\'99\', \'NA\', NULL);';
      break;
    case 'PP_ACs':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`ACNo` varchar(3) DEFAULT NULL,'
              . '`ACName` varchar(25) DEFAULT NULL,'
              . '`DistCode` varchar(2) DEFAULT NULL,'
              . '`UserMapID` int(5) DEFAULT 1'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'PP_DataACs':
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . 'PP_ACs` (`ACNo`, `ACName`, `DistCode`, `UserMapID`) VALUES'
              . '(\'219\', \'DANTAN\', \'15\', 1),'
              . '(\'220\', \'NAYAGRAM (ST)\', \'15\', 1),'
              . '(\'221\', \'GOPIBALLAVPUR\', \'15\', 1),'
              . '(\'222\', \'JHARGRAM\', \'15\', 1),'
              . '(\'223\', \'KESHIARY (ST)\', \'15\', 1),'
              . '(\'224\', \'KHARAGPUR SADAR\', \'15\', 1),'
              . '(\'225\', \'NARAYANGARH\', \'15\', 1),'
              . '(\'226\', \'SABANG\', \'15\', 1),'
              . '(\'227\', \'PINGLA\', \'15\', 1),'
              . '(\'228\', \'KHARAGPUR\', \'15\', 1),'
              . '(\'229\', \'DEBRA\', \'15\', 1),'
              . '(\'230\', \'DASPUR\', \'15\', 1),'
              . '(\'231\', \'GHATAL (SC)\', \'15\', 1),'
              . '(\'232\', \'CHANDRAKONA (SC)\', \'15\', 1),'
              . '(\'233\', \'GARBETA\', \'15\', 1),'
              . '(\'234\', \'SALBONI\', \'15\', 1),'
              . '(\'235\', \'KESHPUR (SC)\', \'15\', 1),'
              . '(\'236\', \'MEDINIPUR\', \'15\', 1),'
              . '(\'237\', \'BINPUR (ST)\', \'15\', 1);';
      break;
    case 'PP_Offices':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`OfficeSL` bigint(20) NOT NULL AUTO_INCREMENT, '
              . '`OfficeCode` varchar(8) DEFAULT NULL, '
              . '`OfficeName` varchar(50) DEFAULT NULL, '
              . '`DesgOC` varchar(30) DEFAULT NULL, '
              . '`AddrPTS` varchar(50) DEFAULT NULL, '
              . '`AddrVTM` varchar(50) DEFAULT NULL, '
              . '`PostOffice` varchar(20) DEFAULT NULL, '
              . '`PSCode` varchar(2) DEFAULT NULL, '
              . '`SubDivnCode` varchar(4) DEFAULT NULL, '
              . '`DistCode` varchar(2) DEFAULT NULL, '
              . '`PinCode` varchar(6) DEFAULT NULL, '
              . '`Status` varchar(2) DEFAULT NULL, '
              . '`TypeCode` varchar(2) DEFAULT NULL, '
              . '`Phone` varchar(11) DEFAULT NULL, '
              . '`Fax` varchar(11) DEFAULT NULL, '
              . '`Mobile` varchar(10) DEFAULT NULL, '
              . '`EMail` varchar(25) DEFAULT NULL, '
              . '`Staffs` int(5) DEFAULT NULL, '
              . '`ACNo` varchar(3) DEFAULT NULL, '
              . ' PRIMARY KEY (`OfficeSL`)'
              . ' ) ENGINE = InnoDB DEFAULT CHARSET = utf8;
    ';
      break;
    case 'PP_FieldNames':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
              . '`FieldName` varchar(25) NOT NULL, '
              . '`Description` varchar(100) DEFAULT NULL, '
              . ' PRIMARY KEY (`FieldName`)'
              . ' ) ENGINE = InnoDB DEFAULT CHARSET = utf8;
    ';
      break;
    case 'PP_DataFieldNames':
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . $ObjectName . '` (`FieldName`, `Description`) VALUES'
              . ' ( \'ACName\', \'AC Name\'),'
              . '(\'DesgOC\', \'Designation of Officer-in-Charge\'),'
              . '(\'AddrPTS\', \'Para/Tola/Street\'),'
              . '(\'AddrVTM\', \'Vill/Town/Metro\'),'
              . '(\'SubDivn\', \'Sub-Division\'),'
              . '(\'EMail\', \'E-Mail Address\');';
      break;
  }
  return $SqlDB;
}

?>
