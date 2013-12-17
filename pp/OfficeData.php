<?php

/*
 * @ todo Fetch District AC and Parts Combo Data on seperate request via ajax
 * @todo Keep All District, AC, Parts available for parent users
 */

$Data = new MySQLiDB();
$_SESSION['action'] = 0;
$Query = '';
if (WebLib::GetVal($_POST, 'FormToken') !== NULL) {
  if (WebLib::GetVal($_POST, 'FormToken') !== WebLib::GetVal($_SESSION, 'FormToken')) {
    $_SESSION['action'] = 1;
  } else {
    // Authenticated Inputs
    switch (WebLib::GetVal($_POST, 'CmdAction')) {

      case 'Save':
        $Query = 'Insert Into `' . MySQL_Pre . 'PP_Offices` (`OfficeName`, `DesgOC`, `AddrPTS`, `AddrVTM`, '
                . '`PostOffice`, `PSCode`, `SubDivnCode`, `DistCode`, `PinCode`, `Status`, `TypeCode`, '
                . '`Phone`, `Fax`, `Mobile`, `EMail`, `Staffs`, `ACNo`)'
                . ' Values(\'' . WebLib::GetVal($_SESSION['PostData'], 'OfficeName', TRUE)
                . '\',\'' . WebLib::GetVal($_SESSION['PostData'], 'DesgOC', TRUE)
                . '\',\'' . WebLib::GetVal($_SESSION['PostData'], 'AddrPTS', TRUE)
                . '\',\'' . WebLib::GetVal($_SESSION['PostData'], 'AddrVTM', TRUE)
                . '\',\'' . WebLib::GetVal($_SESSION['PostData'], 'PostOffice', TRUE)
                . '\',\'' . WebLib::GetVal($_SESSION['PostData'], 'PSCode', TRUE)
                . '\',\'' . WebLib::GetVal($_SESSION, 'SubDivnCode', TRUE)
                . '\',\'' . WebLib::GetVal($_SESSION, 'DistCode', TRUE)
                . '\',\'' . WebLib::GetVal($_SESSION['PostData'], 'PinCode', TRUE)
                . '\',\'' . WebLib::GetVal($_SESSION['PostData'], 'Status', TRUE)
                . '\',\'' . WebLib::GetVal($_SESSION['PostData'], 'InstType', TRUE)
                . '\',\'' . WebLib::GetVal($_SESSION['PostData'], 'Phone', TRUE)
                . '\',\'' . WebLib::GetVal($_SESSION['PostData'], 'Fax', TRUE)
                . '\',\'' . WebLib::GetVal($_SESSION['PostData'], 'Mobile', TRUE)
                . '\',\'' . WebLib::GetVal($_SESSION['PostData'], 'EMail', TRUE)
                . '\',\'' . WebLib::GetVal($_SESSION['PostData'], 'Staffs', TRUE)
                . '\',\'' . WebLib::GetVal($_SESSION['PostData'], 'ACNo', TRUE) . '\');';
        break;

      case 'Update':
        $Query = 'Update `' . MySQL_Pre . 'PP_Offices` Set `OfficeName`=\''
                . WebLib::GetVal($_SESSION['PostData'], 'OfficeName', TRUE) . '\''
                . ' Where `OfficeSL`=' . WebLib::GetVal($_POST, 'OfficeSL', true);
        break;

      case 'Delete':
        $Query = 'Update `' . MySQL_Pre . 'PP_Offices` Set `Activated`=0'
                . ' Where `Activated`=1 AND `CtrlMapID`=' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE)
                . ' AND `UserMapID`=' . WebLib::GetVal($_POST, 'UserMapID');
        break;
    }
    if ($Query !== '') {
      $Inserted = $Data->do_ins_query($Query);
      if ($Inserted > 0) {
        $_SESSION['Msg'] = 'Office ' . WebLib::GetVal($_POST, 'CmdAction') . 'd Successfully!';
        $_SESSION['PostData'] = array();
      } else {
        $_SESSION['Msg'] = 'Unable to ' . WebLib::GetVal($_POST, 'CmdAction') . '!' . $Query;
      }
    }
  }
}
$_SESSION['FormToken'] = md5($_SERVER['REMOTE_ADDR'] . session_id() . microtime());
$Data->do_close();
unset($Mail);
unset($GmailResp);
unset($Data);
?>
