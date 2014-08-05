<?php

function CreateSchemas() {
  $ObjDB = new MySQLiDBHelper();
  $ObjDB->ddlQuery(SQLDefs('DRDC_SHGroups'));
  $ObjDB->ddlQuery(SQLDefs('DRDC_Members'));
  $ObjDB->ddlQuery(SQLDefs('DRDC_GroupStatus'));
  $ObjDB->ddlQuery(SQLDefs('DRDC_BankAccounts'));
  $ObjDB->ddlQuery(SQLDefs('DRDC_Banks'));
  $ObjDB->ddlQuery(SQLDefs('DRDC_Blocks'));
  $ObjDB->ddlQuery(SQLDefs('DRDC_Districts'));
  $ObjDB->ddlQuery(SQLDefs('DRDC_Subdivisions'));
  $ObjDB->ddlQuery(SQLDefs('DRDC_MenuData'));
  $ObjDB->ddlQuery(SQLDefs('DRDC_Helpline'));
  unset($ObjDB);
}

function SQLDefs($ObjectName) {
  $SqlDB = '';
  switch ($ObjectName) {
    case 'DRDC_MenuData':
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . 'MenuItems` '
          . '(`AppID`,`MenuOrder`,`AuthMenu`,`Caption`,`URL`,`Activated`) VALUES'
          . '(\'DRDC\', 1, 0, \'Home\', \'index.php\', 1),'
          . '(\'DRDC\', 2, 1, \'Master Data\', \'drdc/SHGData.php\', 0),'
          . '(\'DRDC\', 3, 1, \'SHGs\', \'drdc/SHGroups.php\', 1),'
          . '(\'DRDC\', 4, 1, \'Reports\', \'drdc/Reports.php\', 0),'
          . '(\'DRDC\', 5, 1, \'Helpline\', \'drdc/Helpline.php\', 0),'
          . '(\'DRDC\', 6, 1, \'Log Out!\', \'login.php?LogOut=1\', 1);';
      break;

    case 'DRDC_Helpline':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName. '` ('
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
