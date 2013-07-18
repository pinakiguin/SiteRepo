<?php

/**
 * API For Ajax Calls from a valid authenticated session.
 *
 * The JSON Object will Contain Four Top Level Nodes
 * 1. $DataResp['AjaxToken'] => Token for preventing atacks like CSRF and Sesion Hijack
 * 2. $DataResp['Data']
 * 3. $DataResp['Mail']
 * 4. $DataResp['Msg']
 * 5. $DataResp['RT'] => Response Time of the Script
 *
 * * @example ($_POST=array(
 *              'CallAPI'=>'GetData',
 *              'AjaxToken'=>'$$$$')
 *
 * @return json
 *

 */
require_once('lib.inc.php');
require_once('class.MySQLiDBHelper.php');
require_once 'php-mailer/GMail.lib.php';
if (!isset($_SESSION))
  session_start();
//@todo Enable AjaxToken currently disabled
$CSRF = TRUE; //(WebLib::GetVal($_POST, 'AjaxToken') === WebLib::GetVal($_SESSION, 'Token'));
if ((WebLib::CheckAuth() === 'Valid') && $CSRF) {
  $_SESSION['LifeTime'] = time();
  $_SESSION['RT'] = microtime(TRUE);
  $_SESSION['CheckAuth'] = 'Valid';
  $_SESSION['Token'] = md5($_SERVER['REMOTE_ADDR'] . session_id() . $_SESSION['ET']);
  $DataResp['AjaxToken'] = $_SESSION['Token'];
  $DataResp['Data'] = array();
  $DataResp['Mail'] = array();
  $DataResp['Msg'] = '';
  switch (WebLib::GetVal($_POST, 'CallAPI')) {

    case 'ChgPwd':
      ChangePassword($DataResp, WebLib::GetVal($_POST, 'OldPass'));
      break;

    case 'GetSRERData':
      SetCurrForm(WebLib::GetVal($_POST, 'TableName'));
      $Query = 'Select ' . WebLib::GetVal($_SESSION, 'Fields', FALSE, FALSE)
              . ' FROM ' . WebLib::GetVal($_SESSION, 'TableName', FALSE, FALSE)
              . ' Where `PartID`=? LIMIT ?,?';
      doQuery($DataResp, $Query, WebLib::GetVal($_POST, 'Params', FALSE, FALSE));
      break;

    // @todo [Currently Working to Insert Data]
    case 'PutSRERData':
      SetCurrForm(WebLib::GetVal($_POST, 'TableName'));
      $Params = WebLib::GetVal($_POST, 'Params', FALSE, FALSE);
      $DataResp['Data']['POST'] = $_POST;
      for ($i = 0; $i < count($Params); $i++) {
        SaveData($DataResp, $_SESSION['TableName'], $Params[$i]);
      }
      //doQuery($DataResp, $Query, $PostData[0]);
      break;

    case 'GetACParts':
      $Query = 'Select `ACNo`,`ACName`'
              . ' FROM `' . MySQL_Pre . 'SRER_ACs`'
              . ' Where `PartMapID`=?';
      $DataResp['ACs'] = array();
      doQuery($DataResp['ACs'], $Query, array(WebLib::GetVal($_SESSION, 'UserMapID')));
      $Query = 'Select `PartID`,`PartNo`,`PartName`,`ACNo`'
              . ' FROM `' . MySQL_Pre . 'SRER_PartMap`'
              . ' Where `PartMapID`=?';
      $DataResp['Parts'] = array();
      doQuery($DataResp['Parts'], $Query, array(WebLib::GetVal($_SESSION, 'UserMapID')));
      break;
  }
  $DataResp['RT'] = '<b>Response Time:</b> '
          . round(microtime(TRUE) - WebLib::GetVal($_SESSION, 'RT'), 6) . ' Sec';
  //PHP 5.4+ is required for JSON_PRETTY_PRINT
  //@todo Remove PRETTY_PRINT for Production
  if (strnatcmp(phpversion(), '5.4') >= 0) {
    $AjaxResp = json_encode($DataResp, JSON_PRETTY_PRINT);
  } else {
    $AjaxResp = WebLib::prettyPrint(json_encode($DataResp));
  }
  unset($DataResp);

  header('Content-Type: application/json');
  header('Content-Length: ' . strlen($AjaxResp));
  echo $AjaxResp;
  exit();
}
header("HTTP/1.1 404 Not Found");
exit();

/**
 * Changes the password of current user
 * @todo Verify the Salting method
 * @param type $DataResp
 * @param string $OldPass Salted MD5 String as MD5(PassWord.MD5(Salt))
 */
function ChangePassword(&$DataResp, $OldPass) {
  $Pass = WebLib::GeneratePassword(10, 2, 2, 2);
  $UserMapID = $_SESSION['UserMapID'];
  $Data = new MySQLiDBHelper(HOST_Name, MySQL_User, MySQL_Pass, MySQL_DB);
  $Data->where('UserMapID', $UserMapID);
  $Data->where('UserPass', $OldPass);

  $Updated = $Data->update('`' . MySQL_Pre . 'Users`', array('UserPass' => md5($Pass)));
  if ($Updated) {
    $Data->where('UserMapID', $UserMapID);
    $Result = $Data->query('Select `UserName`,`UserID` FROM `' . MySQL_Pre . 'Users`');
    $Subject = 'Change User Passowrd - SRER 2014';
    $Body = '<span>Your new password for UserID: <b>'
            . $Result[0]['UserID'] . '</b> is <b>' . $Pass . '</b></span>';
    $Mail = json_decode(GMailSMTP($Result[0]['UserID'], $Result[0]['UserName'], $Subject, $Body));
    if ($Mail->Sent === TRUE) {
      $DataResp['Msg'] = 'Password Changed Successfully!';
    }
  } else {
    $DataResp['Msg'] = 'Unable to Change Password!';
  }
  unset($Result);
  unset($Data);
}

/**
 * Perfroms Select Query to the database
 *
 * @param ref     $DataResp
 * @param string  $Query
 * @param array   $Params
 * @example GetData(&$DataResp, "Select a,b,c from Table Where c=? Order By b LIMIT ?,?", array('1',30,10))
 */
function doQuery(&$DataResp, $Query, $Params = NULL) {
  $Data = new MySQLiDBHelper(HOST_Name, MySQL_User, MySQL_Pass, MySQL_DB);
  $Result = $Data->rawQuery($Query, $Params);
  $DataResp['Data'] = $Result;
  $DataResp['Msg'] = 'Total Rows: ' . count($Result);
  unset($Result);
  unset($Data);
}

/**
 * Performs Insert Query
 *
 * @param ref $DataResp
 * @param string $tableName
 * @param Object $insertData
 */
function SaveData(&$DataResp, $tableName, $insertData) {
  $Data = new MySQLiDBHelper(HOST_Name, MySQL_User, MySQL_Pass, MySQL_DB);
  $DataResp['Data']['Row'] = $insertData;
  if ($insertData['RowID'] === "") {
    $Saved = $Data->insert($tableName, $insertData);
  } else {
    $Data->where('RowID', $insertData['RowID']);
    $Saved = $Data->update($tableName, $insertData);
  }
  if ($Saved) {
    $DataResp['Msg'] = 'Saved Successfully!';
  } else {
    $DataResp['Msg'] = 'Unable to Saved!';
  }
  unset($Data);
}

/**
 * Return the Queries related to SRER Forms
 *
 * ***Important*** $FormName variable should not be directly used in Query for security reasons
 *
 * @param type $FormName
 */
function SetCurrForm($FormName = 'SRERForm6I') {
  Switch ($FormName) {
    case 'SRERForm6I':
      $_SESSION['TableName'] = '' . MySQL_Pre . 'SRER_Form6';
      $_SESSION['Fields'] = '`RowID`,`SlNo`,`ReceiptDate`,`AppName`,`DOB`,`Sex`,`RelationshipName`,`Relationship`,`Status`';
      $_SESSION['InsFields'] = '`' . MySQL_Pre . 'SRER_Form6`'
              . '(`RowID`,`SlNo`,`ReceiptDate`,`AppName`,`DOB`,`Sex`,`RelationshipName`,`Relationship`,`Status`,`PartID`)';
      break;
    case 'SRERForm6A':
      $_SESSION['TableName'] = '`' . MySQL_Pre . 'SRER_Form6A`';
      $_SESSION['Fields'] = '`SlNo`, `ReceiptDate`, `AppName`, `RelationshipName`, `Relationship`, `Status`';
      break;
    case 'SRERForm7I':
      $_SESSION['TableName'] = '`' . MySQL_Pre . 'SRER_Form7`';
      $_SESSION['Fields'] = '`SlNo`, `ReceiptDate`, `ObjectorName`, `PartNo`, `SerialNoInPart`, `DelPersonName`, `ObjectReason`, `Status` ';
      break;
    case 'SRERForm8I':
      $_SESSION['TableName'] = '`' . MySQL_Pre . 'SRER_Form8`';
      $_SESSION['Fields'] = '`SlNo`, `ReceiptDate`, `AppName`, `RelationshipName`, `Relationship`, `Status`';
      break;
    case 'SRERForm8A':
      $_SESSION['TableName'] = '`' . MySQL_Pre . 'SRER_Form8A`';
      $_SESSION['Fields'] = '`SlNo`, `ReceiptDate`, `AppName`, `RelationshipName`, `Relationship`, `Status`';
      break;
  }
  if (WebLib::GetVal($_POST, 'FormName') != '')
    $_SESSION['FormName'] = WebLib::GetVal($_POST, 'FormName');
}

?>
