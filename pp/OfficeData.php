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
        if ($_SESSION['Msg'] === "") {
          $Query = 'Insert Into `' . MySQL_Pre . 'PP_Offices` (`OfficeName`, `DesgOC`, `AddrPTS`, `AddrVTM`, '
                  . '`PostOffice`, `PSCode`, `SubDivnCode`, `DistCode`, `PinCode`, `Status`, `TypeCode`, '
                  . '`Phone`, `Fax`, `Mobile`, `EMail`, `Staffs`, `ACNo`,`UserMapID`)'
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
                  . '\',\'' . WebLib::GetVal($_SESSION['PostData'], 'TypeCode', TRUE)
                  . '\',\'' . WebLib::GetVal($_SESSION['PostData'], 'Phone', TRUE)
                  . '\',\'' . WebLib::GetVal($_SESSION['PostData'], 'Fax', TRUE)
                  . '\',\'' . WebLib::GetVal($_SESSION['PostData'], 'Mobile', TRUE)
                  . '\',\'' . WebLib::GetVal($_SESSION['PostData'], 'EMail', TRUE)
                  . '\',\'' . WebLib::GetVal($_SESSION['PostData'], 'Staffs', TRUE)
                  . '\',\'' . WebLib::GetVal($_SESSION['PostData'], 'ACNo', TRUE)
                  . '\',' . WebLib::GetVal($_SESSION, 'UserMapID', TRUE) . ');';
        }
        break;

      case 'Update':
        $Query = 'Update `' . MySQL_Pre . 'PP_Offices` Set '
                . '`OfficeName`=\'' . WebLib::GetVal($_SESSION['PostData'], 'OfficeName', TRUE) . '\','
                . '`DesgOC`=\'' . WebLib::GetVal($_SESSION['PostData'], 'DesgOC', TRUE) . '\','
                . '`AddrPTS`=\'' . WebLib::GetVal($_SESSION['PostData'], 'AddrPTS', TRUE) . '\','
                . '`AddrVTM`=\'' . WebLib::GetVal($_SESSION['PostData'], 'AddrVTM', TRUE) . '\', '
                . '`PostOffice`=\'' . WebLib::GetVal($_SESSION['PostData'], 'PostOffice', TRUE) . '\','
                . '`PSCode`=\'' . WebLib::GetVal($_SESSION['PostData'], 'PSCode', TRUE) . '\','
                . '`PinCode`=\'' . WebLib::GetVal($_SESSION['PostData'], 'PinCode', TRUE) . '\', '
                . '`Status`=\'' . WebLib::GetVal($_SESSION['PostData'], 'Status', TRUE) . '\', '
                . '`TypeCode`=\'' . WebLib::GetVal($_SESSION['PostData'], 'TypeCode', TRUE) . '\', '
                . '`Phone`=\'' . WebLib::GetVal($_SESSION['PostData'], 'Phone', TRUE) . '\', '
                . '`Fax`=\'' . WebLib::GetVal($_SESSION['PostData'], 'Fax', TRUE) . '\', '
                . '`Mobile`=\'' . WebLib::GetVal($_SESSION['PostData'], 'Mobile', TRUE) . '\', '
                . '`EMail`=\'' . WebLib::GetVal($_SESSION['PostData'], 'EMail', TRUE) . '\', '
                . '`Staffs`=\'' . WebLib::GetVal($_SESSION['PostData'], 'Staffs', TRUE) . '\', '
                . '`ACNo`=\'' . WebLib::GetVal($_SESSION['PostData'], 'ACNo', TRUE) . '\''
                . ' Where `OfficeSL`=' . WebLib::GetVal($_POST, 'OfficeSL', true);
        break;

      case 'Delete':
        $Query = 'Delete from `' . MySQL_Pre . 'PP_Offices` '
                . ' Where `OfficeSL`=' . WebLib::GetVal($_POST, 'OfficeSL', true);
        break;
    }
    if ($Query !== '') {
      $Inserted = $Data->do_ins_query($Query);
      if ($Inserted > 0) {
        $_SESSION['Msg'] = 'Office ' . WebLib::GetVal($_POST, 'CmdAction') . 'd Successfully!';
        $_SESSION['PostData'] = array('CmdAction' => 'Save');
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
