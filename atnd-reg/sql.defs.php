<?php

function SQLDefs($ObjectName) {
  $SqlDB = '';
  switch ($ObjectName) {
    case 'ATND_Register':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . 'ATND_Register` ('
              . '`AtndID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,'
              . '`UserMapID` int(11) NOT NULL,'
              . '`InDateTime` timestamp NULL,'
              . '`OutDateTime` timestamp NULL,'
              . ' PRIMARY KEY (`AtndID`)'
              . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
  }
  return $SqlDB;
}

?>
