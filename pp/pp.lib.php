<?php

require_once(__DIR__ . '/../lib.inc.php');

/**
 * Functions related to PP Module
 */
class LibPP {

  /**
   * Sets the values for $_SESSION['SubDivnCode'], $_SESSION['DistCode']
   * depending upon UserMapID on PP_UserBlockMaps Table
   */
  public static function SetUserEnv() {
    if (WebLib::GetVal($_SESSION, 'SubDivnCode') === null) {
      $Data = new MySQLiDB();
      $_SESSION['SubDivnCode'] = $Data->do_max_query('Select `SubDivnCode` from `' . MySQL_Pre . 'PP_UserBlockMaps` M'
              . ' JOIN `' . MySQL_Pre . 'PP_Blocks` B ON (B.BlockCode=M.BlockCode)'
              . ' Where `UserMapID`=' . WebLib::GetVal($_SESSION, 'UserMapID'));
      $Data->do_close();
      unset($Data);
      $_SESSION['DistCode'] = '15';
    }
  }

}

function GetColHead($ColName) {
  $Fields = new MySQLiDB();
  $ColHead = $Fields->do_max_query('Select Description from `' . MySQL_Pre . 'PP_FieldNames`'
          . ' Where FieldName=\'' . $ColName . '\'');
  $Fields->do_close();
  unset($Fields);
  return (!$ColHead ? $ColName : $ColHead);
}

?>
