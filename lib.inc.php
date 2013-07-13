<?php

/**
 * @todo Unique Random ID Generator function to be included
 */
include_once 'MySQLiDB.inc.php';

/**
 * Generates a strong password
 *
 * @link http://www.dougv.com/demo/php_password_generator/index.php
 * @param int $l Password Length
 * @param int $c No. of CAPITAL letters
 * @param int $n No. of Integers
 * @param int $s No. of $~mb()|$
 * @return boolean
 */
function generatePassword($l = 8, $c = 0, $n = 0, $s = 0) {
  // get count of all required minimum special chars
  $count = $c + $n + $s;

  // sanitize inputs; should be self-explanatory
  if (!is_int($l) || !is_int($c) || !is_int($n) || !is_int($s)) {
    trigger_error('Argument(s) not an integer', E_USER_WARNING);
    return false;
  } elseif ($l < 0 || $l > 20 || $c < 0 || $n < 0 || $s < 0) {
    trigger_error('Argument(s) out of range', E_USER_WARNING);
    return false;
  } elseif ($c > $l) {
    trigger_error('Number of password capitals required exceeds password length', E_USER_WARNING);
    return false;
  } elseif ($n > $l) {
    trigger_error('Number of password numerals exceeds password length', E_USER_WARNING);
    return false;
  } elseif ($s > $l) {
    trigger_error('Number of password capitals exceeds password length', E_USER_WARNING);
    return false;
  } elseif ($count > $l) {
    trigger_error('Number of password special characters exceeds specified password length', E_USER_WARNING);
    return false;
  }

  // all inputs clean, proceed to build password
  // change these strings if you want to include or exclude possible password characters
  $chars = "abcdefghijklmnopqrstuvwxyz";
  $caps = strtoupper($chars);
  $nums = "0123456789";
  $syms = "!@#$%^&*()-+?";
  $out = '';
  // build the base password of all lower-case letters
  for ($i = 0; $i < $l; $i++) {
    $out .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
  }

  // create arrays if special character(s) required
  if ($count) {
    // split base password to array; create special chars array
    $tmp1 = str_split($out);
    $tmp2 = array();

    // add required special character(s) to second array
    for ($i = 0; $i < $c; $i++) {
      array_push($tmp2, substr($caps, mt_rand(0, strlen($caps) - 1), 1));
    }
    for ($i = 0; $i < $n; $i++) {
      array_push($tmp2, substr($nums, mt_rand(0, strlen($nums) - 1), 1));
    }
    for ($i = 0; $i < $s; $i++) {
      array_push($tmp2, substr($syms, mt_rand(0, strlen($syms) - 1), 1));
    }

    // hack off a chunk of the base password array that's as big as the special chars array
    $tmp1 = array_slice($tmp1, 0, $l - $count);
    // merge special character(s) array with base password array
    $tmp1 = array_merge($tmp1, $tmp2);
    // mix the characters up
    shuffle($tmp1);
    // convert to string for output
    $out = implode('', $tmp1);
  }

  return $out;
}

/**
 * Generates DOCTYPE and Page Title for HTML5
 *
 * Title: {$PageTitle} - {$AppTitle}; AppTitle is Defined in DatabaseCofig.inc.php
 * @param string $PageTitle Title of the page
 */
function Html5Header($PageTitle = "Paschim Medinipur") {
  $AppTitle = AppTitle;
  echo '<!DOCTYPE html>';
  echo '<html xmlns="http://www.w3.org/1999/xhtml">';
  echo '<head>';
  echo "<title>{$PageTitle} - {$AppTitle}</title>";
  echo '<meta name="robots" content="noarchive,noodp">';
  echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
}

/**
 * Generates call to jQuery Scripts in Head Section
 */
function jQueryInclude() {
  echo '<link type="text/css" href="' . GetAbsoluteURLFolder() . '/css/dark-hive/jquery-ui-1.10.3.custom.min.css" rel="Stylesheet" />'
  . '<script type="text/javascript" src="' . GetAbsoluteURLFolder() . 'js/jquery-1.10.2.min.js"></script>'
  . '<script type="text/javascript" src="' . GetAbsoluteURLFolder() . 'js/jquery-ui-1.10.3.custom.min.js"></script>';
}

/**
 * IncludeJS($JavaScript)
 *
 * Generates Script tag
 *
 * @param string $JavaScript src including path
 */
function IncludeJS($PathToJS) {
  echo '<script type="text/javascript" src="' . GetAbsoluteURLFolder() . $PathToJS . '"></script>';
}

/**
 * IncludeCSS([$CSS = "css/Style.css"])
 *
 * Generates link to css specified by $CSS
 *
 * @param string $CSS href including path
 */
function IncludeCSS($PathToCSS = "css/Style.css") {
  echo '<link type="text/css" href="' . GetAbsoluteURLFolder() . $PathToCSS . '" rel="Stylesheet" />';
}

/**
 * initHTML5page([$PageTitle = ""])
 *
 * Starts a Session and Html5Header function
 *
 * @param string $PageTitle Title of the page
 */
function initHTML5page($PageTitle = "") {
  session_start();
  $sess_id = md5(microtime());
  $_SESSION['ET'] = microtime(TRUE);
  setcookie("Client_SID", $sess_id, (time() + (LifeTime * 60)), BaseDIR);
  $_SESSION['Client_SID'] = $sess_id;
  $_SESSION['LifeTime'] = time();
  Html5Header($PageTitle);
  if (GetVal($_REQUEST, 'show_src')) {
    if (GetVal($_REQUEST, 'show_src') == "me")
      show_source(substr($_SERVER['PHP_SELF'], 1, strlen($_SERVER['PHP_SELF'])));
  }
}

/**
 * <b>GetVal($Array, $Index, [$ForSQL = FALSE, [$HTMLSafe = TRUE]])</b>
 *
 * Returns value of an array element without cousing warning/error
 *
 * @param array $Array eg. $_SESSION
 * @param string $Index eg. "index"
 * @param bool $ForSQL If set to true then SQLSafe else htmlspecialchars will be applied
 * @param bool $HTMLSafe If FALSE then OutPut without htmlspecialchars
 * @return null|$Array[$Index]
 * @example GetVal($Array, $Index) = htmlspecialchars
 * @example GetVal($Array, $Index, TRUE) = SqlSafe
 * @example GetVal($Array, $Index, FALSE, FALSE) = raw output
 */
function GetVal($Array, $Index, $ForSQL = FALSE, $HTMLSafe = TRUE) {
  if (!isset($Array[$Index])) {
    return ($ForSQL) ? "" : NULL;
  } else {
    if ($ForSQL) {
      $Data = new MySQLiDB();
      $Value = $Data->SqlSafe($Array[$Index]);
      $Data->do_close();
      unset($Data);
      return $Value;
    } else {
      if ($HTMLSafe) {
        return htmlspecialchars($Array[$Index]);
      } else {
        return $Array[$Index];
      }
    }
  }
}

/**
 * Converts a date string into DD-MM-YYYY format
 *
 * @param string $AppDate
 * @return string
 */
function ToDate($AppDate) {
  if ($AppDate != "")
    return date("d-m-Y", strtotime($AppDate));
  else
    return date("d-m-Y", time());
}

/**
 * Converts a date string into MySQL Date Format i.e. YYYY-MM-DD
 *
 * @param string $AppDate
 * @return string
 */
function ToDBDate($AppDate) {
  if ($AppDate == "")
    return date("Y-m-d", time());
  else
    return date("Y-m-d", strtotime($AppDate));
}

/**
 * Returns a random string of specified length
 *
 * @param int $length Length of the String to be returned
 * @return string Random String
 */
function RandStr($length) {
  $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $size = strlen($chars);
  $str = "";
  for ($i = 0; $i < $length; $i++) {
    $Chr = $chars[rand(0, $size - 1)];
    $str .=$Chr;
    $chars = str_replace($Chr, "", $chars);
    $size = strlen($chars);
  }
  return $str;
}

/**
 * Returns absolute web directory based on BaseDIR(defined constant).
 *
 * @return string Absolute web directory path eg. https://www.paschimmedinipur.gov.in/eRecruitment/
 */
function GetAbsoluteURLFolder() {
  $scriptFolder = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
  $scriptFolder .= $_SERVER['HTTP_HOST'] . BaseDIR;
  return $scriptFolder;
}

/**
 * InpSanitize($PostData)
 *
 * Sanitize the Inputs for inserting into mysql
 *
 * @param array $PostData
 * @return array
 */
function InpSanitize($PostData) {
  $Fields = "";
  $Data = new MySQLiDB();
  foreach ($PostData as $FieldName => &$Value) {
    $Value = $Data->SqlSafe($Value);
    $Fields = $Fields . "<br />" . $FieldName;
    if ($Value == "") {
      $_SESSION['Msg'] = '<b>Message:</b> Field ' . GetColHead($FieldName) . ' left unfilled.';
    }
  }
  unset($Value);
  $PostData['Fields'] = $Fields;
//echo "Total Fields:".count($PostData);
  return $PostData;
}

/*
 * Shows the content of $_SESSION['Msg']
 */

function ShowMsg() {
  if (GetVal($_SESSION, "Msg") != "") {
    echo '<span class="Message">' . GetVal($_SESSION, 'Msg', FALSE, FALSE) . '</span><br/>';
    $_SESSION['Msg'] = "";
  }
}

/**
 * Displays Page Informations and Records Visit Count in MySQL_Pre.Visits table
 *
 */
function pageinfo() {
  $strfile = strtok($_SERVER['PHP_SELF'], "/");
//echo $_SERVER['PHP_SELF'].' | '.$strfile;
  $str = strtok("/");
//echo ' | '.$str;
  while ($str) {
    $strfile = $str;
//echo ' | '.$strfile;
    $str = strtok("/");
  }
  $reg = new MySQLiDB();
  $visitor_num = $reg->do_max_query("select VisitCount from `" . MySQL_Pre . "Visits` "
          . " Where PageURL='" . $_SERVER['PHP_SELF'] . "'");
//$LastVisit = $reg->do_max_query("select timestamp(LastVisit) from " . MySQL_Pre . "Visits where PageURL like '" . $_SERVER['PHP_SELF'] . "'");
  if ($visitor_num > 0)
    $reg->do_ins_query("update " . MySQL_Pre . "Visits "
            . " Set `VisitCount`=`VisitCount`+1, VisitorIP='" . $_SERVER['REMOTE_ADDR'] . "'"
            . " Where PageURL='" . $_SERVER['PHP_SELF'] . "'");
  else
    $reg->do_ins_query("Insert into " . MySQL_Pre . "Visits(PageURL,VisitorIP)"
            . " Values('" . $_SERVER['PHP_SELF'] . "','" . $_SERVER['REMOTE_ADDR'] . "');");
  $_SESSION['LifeTime'] = time();
  echo "<strong > Last Updated On:</strong> &nbsp;&nbsp;" . date("l d F Y g:i:s A ", filemtime($strfile))
  . " IST &nbsp;&nbsp;&nbsp;<b>Your IP: </b>" . $_SERVER['REMOTE_ADDR']
  . "&nbsp;&nbsp;&nbsp;<b>Visits:</b>&nbsp;&nbsp;" . $visitor_num
  . " <b>Loaded In:</b> " . round(microtime(TRUE) - GetVal($_SESSION, 'ET'), 3) . " Sec";
  $reg->do_close();
}

/**
 * Shows Static Footer Information and Records Execution Duration with Visitor Logs
 */
function footerinfo() {
  echo 'Designed and Developed By <strong>National Informatics Centre</strong>, Paschim Medinipur District Centre<br/>'
  . 'L. A. Building (2nd floor), Collectorate Compound, Midnapore<br/>'
  . 'West Bengal - 721101 , India Phone : +91-3222-263506, Email: wbmdp(a)nic.in<br/>';
  $_SESSION['ED'] = round(microtime(TRUE) - GetVal($_SESSION, 'ET'), 3);
  $reg = new MySQLiDB();
  $reg->do_ins_query("INSERT INTO " . MySQL_Pre . "VisitorLogs(`SessionID`, `IP`, `Referrer`, `UserAgent`, `URL`, `Action`, `Method`, `URI`, `ED`)"
          . " Values('" . GetVal($_SESSION, 'ID', TRUE) . "', '" . $_SERVER['REMOTE_ADDR'] . "', '"
          . GetVal($_SERVER, 'HTTP_REFERER', TRUE) . "', '"
          . $reg->SqlSafe($_SERVER['HTTP_USER_AGENT']) . "', '"
          . $reg->SqlSafe($_SERVER['PHP_SELF']) . "', '"
          . $reg->SqlSafe($_SERVER['SCRIPT_NAME']) . "', '"
          . $reg->SqlSafe($_SERVER['REQUEST_METHOD']) . "', '"
          . $reg->SqlSafe($_SERVER['REQUEST_URI']) . "',"
          . GetVal($_SESSION, 'ED') . ");");
  $reg->do_close();
  $_SESSION['ED'] = 0;
}

/**
 * Returns SQL Query of the specified object
 *
 * @param string $TableName
 * @return string SQL Query for the requested object
 */
function GetTableDefs($TableName) {
  $SqlDB = "";
  switch ($TableName) {
    case "Visits":
      $SqlDB = "CREATE TABLE IF NOT EXISTS `" . MySQL_Pre . "Visits` ("
              . "`PageID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,"
              . "`PageURL` text NOT NULL,"
              . "`VisitCount` bigint(20) NOT NULL DEFAULT '1',"
              . "`LastVisit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,"
              . "`PageTitle` text,"
              . "`VisitorIP` text NOT NULL,"
              . " PRIMARY KEY (`PageID`)"
              . ") ENGINE = InnoDB DEFAULT CHARSET = utf8;";
      break;
    case "Logs":
      $SqlDB = "CREATE TABLE IF NOT EXISTS `" . MySQL_Pre . "Logs` ("
              . "`LogID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,"
              . "`SessionID` varchar(32) DEFAULT NULL,"
              . "`IP` varchar(15) DEFAULT NULL,"
              . "`Referrer` longtext,"
              . "`UserAgent` longtext,"
              . "`UserID` varchar(20) NOT NULL,"
              . "`URL` longtext,"
              . "`Action` longtext,"
              . "`Method` varchar(10) DEFAULT NULL,"
              . "`URI` longtext,"
              . "`AccessTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,"
              . "  PRIMARY KEY (`LogID`)"
              . ") ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
      break;
    case "VisitorLogs":
      $SqlDB = "CREATE TABLE IF NOT EXISTS `" . MySQL_Pre . "VisitorLogs` ("
              . "`LogID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,"
              . "`SessionID` varchar(32) DEFAULT NULL,"
              . "`IP` varchar(15) DEFAULT NULL,"
              . "`Referrer` longtext,"
              . "`UserAgent` longtext,"
              . "`URL` longtext,"
              . "`Action` longtext,"
              . "`Method` varchar(10) DEFAULT NULL,"
              . "`URI` longtext,"
              . "`ED` DECIMAL(4,4) NOT NULL," //DECIMAL(M,D) as M.D ; M>=D;
              . "`AccessTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,"
              . "  PRIMARY KEY (`LogID`)"
              . ") ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
      break;
    case "Uploads":
      $SqlDB = "CREATE TABLE IF NOT EXISTS `" . MySQL_Pre . "Uploads` ("
              . "`UploadID` int(11) NOT NULL AUTO_INCREMENT,"
              . "`Dept` text NOT NULL,"
              . "`Subject` varchar(250) NOT NULL,"
              . "`Topic` int(11) NOT NULL,"
              . "`Dated` date NOT NULL,"
              . "`Expiry` date DEFAULT NULL,"
              . "`Attachment` text NOT NULL,"
              . "`size` int(11) NOT NULL,"
              . "`mime` text NOT NULL,"
              . "`file` longblob,"
              . "`UploadedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,"
              . "`Deleted` tinyint(1) NOT NULL,"
              . " PRIMARY KEY (`UploadID`)"
              . ") ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
      break;
    case "Users":
      $SqlDB = "CREATE TABLE IF NOT EXISTS `" . MySQL_Pre . "Users` ("
              . "`UserMapID` int(10) NOT NULL AUTO_INCREMENT,"
              . "`UserID` varchar(255) DEFAULT NULL,"
              . "`MobileNo` varchar(10) DEFAULT NULL,"
              . "`UserName` varchar(255) DEFAULT NULL,"
              . "`UserPass` varchar(255) DEFAULT NULL,"
              . "`CtrlMapID` int(10) NOT NULL,"
              . "`Remarks` varchar(255) DEFAULT NULL,"
              . "`LoginCount` int(10) DEFAULT '0',"
              . "`LastLoginTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,"
              . "`Registered` tinyint(1) NOT NULL,"
              . "`Activated` tinyint(1) NOT NULL,"
              . " PRIMARY KEY (`UserMapID`)"
              . ") ENGINE=InnoDB DEFAULT CHARSET=utf8;";
      break;
    case "UsersData":
// Super Admin Password "test@123"
      $SqlDB = "INSERT INTO `" . MySQL_Pre . "Users`"
              . "(`UserID`, `UserName`, `UserPass`, `UserMapID`, `CtrlMapID`,`Registered`, `Activated`) "
              . "VALUES ('Admin','Super Administrator','ceb6c970658f31504a901b89dcd3e461',1,0,1,1);";
      break;
    case "SRER_FieldNames":
      $SqlDB = "CREATE TABLE IF NOT EXISTS `" . MySQL_Pre . "SRER_FieldNames` ("
              . "`FieldName` varchar(20) NOT NULL,"
              . "`Description` varchar(255) DEFAULT NULL,"
              . " PRIMARY KEY (`FieldName`)"
              . ") ENGINE=InnoDB DEFAULT CHARSET=utf8;";
      break;
    case "SRER_FieldNameData":
      $SqlDB = "INSERT INTO `" . MySQL_Pre . "SRER_FieldNames` (`FieldName`, `Description`) VALUES"
              . "('ACNo', 'AC Name'),"
              . "('Action', 'Action (Page)'),"
              . "('AppName', 'Name of Applicant'),"
              . "('CountF6', 'Form 6 Data Count'),"
              . "('CountF6A', 'Form 6A Data Count'),"
              . "('CountF7', 'Form 7 Data Count'),"
              . "('CountF8', 'Form 8 Data Count'),"
              . "('CountF8A', 'Form 8A Data Count'),"
              . "('DelPersonName', 'Name of the Person to be Deleted'),"
              . "('IP', 'IP Address'),"
              . "('LastAccessTime', 'Last Accessed On'),"
              . "('LastLoginTime', 'Last Login Time'),"
              . "('LoginCount', 'Login Count'),"
              . "('ObjectorName', 'Name of Objector'),"
              . "('ObjectReason', 'Reason of Objection'),"
              . "('PartNo', 'Part Number of Objected Person'),"
              . "('ReceiptDate', 'Date of Receipt'),"
              . "('Relationship', 'Relationship'),"
              . "('RelationshipName', 'Name of Father/ Mother/ Husband/ Others'),"
              . "('SerialNoInPart', 'Serial No. in Concerned Part'),"
              . "('SlNo', 'Serial No.'),"
              . "('Status', 'Status'),"
              . "('UserName', 'Block');";
    case "`SRER_Form6`":
      $SqlDB = "CREATE TABLE IF NOT EXISTS `" . MySQL_Pre . "SRER_Form6` ("
              . "`RowID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,"
              . "`SlNo` int(10) DEFAULT NULL,"
              . "`PartID` int(10) DEFAULT NULL,"
              . "`ReceiptDate` varchar(10) DEFAULT NULL,"
              . "`AppName` varchar(255) DEFAULT NULL,"
              . "`RelationshipName` varchar(255) DEFAULT NULL,"
              . "`Relationship` varchar(255) DEFAULT NULL,"
              . "`Status` varchar(255) DEFAULT NULL,"
              . " PRIMARY KEY (`RowID`)"
              . ") ENGINE = InnoDB DEFAULT CHARSET = utf8;";
      break;
    case "SRER_Form6A":
      $SqlDB = "CREATE TABLE IF NOT EXISTS `" . MySQL_Pre . "SRER_Form6A` ("
              . "`RowID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,"
              . "`SlNo` int(10) DEFAULT NULL,"
              . "`PartID` int(10) DEFAULT NULL,"
              . "`ReceiptDate` varchar(10) DEFAULT NULL,"
              . "`AppName` varchar(255) DEFAULT NULL,"
              . "`RelationshipName` varchar(255) DEFAULT NULL,"
              . "`Relationship` varchar(255) DEFAULT NULL,"
              . "`Status` varchar(255) DEFAULT NULL,"
              . " PRIMARY KEY (`RowID`)"
              . ") ENGINE = InnoDB DEFAULT CHARSET = utf8;";
      break;
    case "SRER_Form7":
      $SqlDB = "CREATE TABLE IF NOT EXISTS `" . MySQL_Pre . "SRER_Form7` ("
              . "`RowID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,"
              . "`PartID` int(10) DEFAULT NULL,"
              . "`ReceiptDate` varchar(10) DEFAULT NULL,"
              . "`ObjectorName` varchar(255) DEFAULT NULL,"
              . "`PartNo` varchar(255) DEFAULT NULL,"
              . "`SerialNoInPart` int(10) DEFAULT NULL,"
              . "`DelPersonName` varchar(255) DEFAULT NULL,"
              . "`ObjectReason` varchar(255) DEFAULT NULL,"
              . "`Status` varchar(255) DEFAULT NULL,"
              . "`SlNo` int(10) DEFAULT NULL,"
              . " PRIMARY KEY (`RowID`)"
              . ") ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
      break;
    case "SRER_Form8":
      $SqlDB = "CREATE TABLE IF NOT EXISTS `" . MySQL_Pre . "SRER_Form8` ("
              . "`RowID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,"
              . "`SlNo` int(10) DEFAULT NULL,"
              . "`PartID` int(10) DEFAULT NULL,"
              . "`ReceiptDate` varchar(10) DEFAULT NULL,"
              . "`AppName` varchar(255) DEFAULT NULL,"
              . "`RelationshipName` varchar(255) DEFAULT NULL,"
              . "`Relationship` varchar(255) DEFAULT NULL,"
              . "`Status` varchar(255) DEFAULT NULL,"
              . " PRIMARY KEY (`RowID`)"
              . ") ENGINE = InnoDB DEFAULT CHARSET = utf8;";
      break;
    case "SRER_Form8A":
      $SqlDB = "CREATE TABLE IF NOT EXISTS `" . MySQL_Pre . "SRER_Form8A` ("
              . "`RowID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,"
              . "`SlNo` int(10) DEFAULT NULL,"
              . "`PartID` int(10) DEFAULT NULL,"
              . "`ReceiptDate` varchar(10) DEFAULT NULL,"
              . "`AppName` varchar(255) DEFAULT NULL,"
              . "`RelationshipName` varchar(255) DEFAULT NULL,"
              . "`Relationship` varchar(255) DEFAULT NULL,"
              . "`Status` varchar(255) DEFAULT NULL,"
              . " PRIMARY KEY (`RowID`)"
              . ") ENGINE = InnoDB DEFAULT CHARSET = utf8;";
      break;
    case "SRER_PartMap":
      $SqlDB = "CREATE TABLE IF NOT EXISTS `" . MySQL_Pre . "SRER_PartMap` ("
              . "`PartID` int(10) NOT NULL AUTO_INCREMENT,"
              . "`PartMapID` int(10) DEFAULT NULL,"
              . "`PartNo` varchar(255) DEFAULT NULL,"
              . "`PartName` varchar(255) DEFAULT NULL,"
              . "`ACNo` varchar(255) DEFAULT NULL,"
              . " PRIMARY KEY (`PartID`)"
              . ") ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
      break;
  }
  return $SqlDB;
}

/**
 * Excutes DDL Queried for creating database objects
 *
 * @param string $ForWhat
 */
function CreateDB($ForWhat = "WebSite") {
  switch ($ForWhat) {
    case "WebSite":
      $ObjDB = new MySQLiDB();
      $ObjDB->do_ins_query(GetTableDefs("Visits"));
      $ObjDB->do_ins_query(GetTableDefs("VisitorLogs"));
      $ObjDB->do_ins_query(GetTableDefs("Logs"));
      $ObjDB->do_ins_query(GetTableDefs("Uploads"));
      $ObjDB->do_ins_query(GetTableDefs("Users"));
      $ObjDB->do_ins_query(GetTableDefs("UsersData"));
      $ObjDB->do_close();
      break;
    case "SRER":
      $ObjDB = new MySQLiDB();
      $ObjDB->do_ins_query(GetTableDefs("SRER_FieldNames"));
      $ObjDB->do_ins_query(GetTableDefs("SRER_FieldNameData"));
      $ObjDB->do_ins_query(GetTableDefs("SRER_Form6"));
      $ObjDB->do_ins_query(GetTableDefs("SRER_Form6A"));
      $ObjDB->do_ins_query(GetTableDefs("SRER_Form7"));
      $ObjDB->do_ins_query(GetTableDefs("SRER_Form8"));
      $ObjDB->do_ins_query(GetTableDefs("SRER_Form8A"));
      $ObjDB->do_ins_query(GetTableDefs("SRER_PartMap"));
      $ObjDB->do_close();
      break;
  }
}

/**
 * Checks if the current session is Valid
 *
 * @return string <b>(Browsing|LogOut|TimeOut|INVALID SESSION|Valid)</b>
 */
function CheckAuth() {
  $_SESSION['Debug'] = GetVal($_SESSION, 'Debug') . "CheckAuth";
  if ((GetVal($_SESSION, 'UserMapID') === NULL)) {
    return "Browsing";
  }
  if (GetVal($_REQUEST, 'LogOut')) {
    return "LogOut";
  } else if (GetVal($_SESSION, 'LifeTime') < (time() - (LifeTime * 60))) {
    return "TimeOut(" . GetVal($_SESSION, 'LifeTime') . "-" . (time() - (LifeTime * 60)) . ")";
  } else if (GetVal($_SESSION, 'SESSION_TOKEN') != GetVal($_COOKIE, 'SESSION_TOKEN')) {
    $_SESSION['Debug'] = "(" . GetVal($_SESSION, 'SESSION_TOKEN') . " = " . GetVal($_COOKIE, 'SESSION_TOKEN') . ")";
    return "INVALID SESSION (" . GetVal($_SESSION, 'SESSION_TOKEN') . " = " . GetVal($_COOKIE, 'SESSION_TOKEN') . ")";
  } elseif (GetVal($_SESSION, 'ID') !== session_id()) {
    $_SESSION['Debug'] = "(" . GetVal($_SESSION, 'ID') . " = " . session_id() . ")";
    return "INVALID SESSION (" . GetVal($_SESSION, 'ID') . " = " . session_id() . ")";
  } elseif (GetVal($_SESSION, 'UserMapID') !== NULL) {
    return "Valid";
  }
}

/**
 * Initiates an UnAuthenticated Session
 *
 */
function initSess() {
  $sess_id = md5(microtime());
  $_SESSION['ET'] = microtime(TRUE);
  $_SESSION['Debug'] = GetVal($_SESSION, 'Debug') . "InInitPage(" . GetVal($_SESSION, 'SESSION_TOKEN') . " = " . GetVal($_COOKIE, 'SESSION_TOKEN', TRUE) . ")";
  setcookie("SESSION_TOKEN", $sess_id, (time() + (LifeTime * 60)), BaseDIR);
  $_SESSION['SESSION_TOKEN'] = $sess_id;
  $_SESSION['LifeTime'] = time();
  if (GetVal($_REQUEST, 'show_src')) {
    if ($_REQUEST['show_src'] == "me")
      show_source(substr($_SERVER['PHP_SELF'], 1, strlen($_SERVER['PHP_SELF'])));
  }
}

/**
 * Verifies Session Authentication and Logs Audit Trails
 * @todo Audit Trails to be logged with submitted data
 */
function AuthSession() {
  if (!isset($_SESSION))
    session_start();
  $_SESSION['ET'] = microtime(TRUE);
  $_SESSION['Debug'] = GetVal($_SESSION, 'Debug') . "InSession_AUTH";
  $SessRet = CheckAuth();
  $_SESSION['CheckAuth'] = $SessRet;
  $reg = new MySQLiDB();
  if (GetVal($_REQUEST, 'NoAuth'))
    initSess();
  else {
    if ($SessRet !== "Valid") {
      $reg->do_ins_query("INSERT INTO `" . MySQL_Pre . "Logs` (`SessionID`, `IP`, `Referrer`, `UserAgent`, `UserID`, `URL`, `Action`, `Method`, `URI`)"
              . " Values('" . GetVal($_SESSION, 'ID', TRUE) . "', '" . $_SERVER['REMOTE_ADDR'] . "', '"
              . GetVal($_SERVER, 'HTTP_REFERER', TRUE) . "', '"
              . $reg->SqlSafe($_SERVER['HTTP_USER_AGENT']) . "', '"
              . GetVal($_SESSION, 'UserMapID', TRUE) . "', '"
              . $reg->SqlSafe($_SERVER['PHP_SELF']) . "', '" . $SessRet . " ("
              . $reg->SqlSafe($_SERVER['SCRIPT_NAME']) . ")', '"
              . $reg->SqlSafe($_SERVER['REQUEST_METHOD']) . "', '"
              . $reg->SqlSafe($_SERVER['REQUEST_URI']) . "');");
      session_unset();
      session_destroy();
      session_start();
      $_SESSION = array();
      $_SESSION['Debug'] = GetVal($_SESSION, 'Debug') . $SessRet . "SESSION_TOKEN-!Valid";
      header("Location: " . BaseDIR . "login.php");
      exit;
    } else {
      $_SESSION['Debug'] = GetVal($_SESSION, 'Debug') . "SESSION_TOKEN-Valid";
      $sess_id = md5(microtime());
      setcookie("SESSION_TOKEN", $sess_id, (time() + (LifeTime * 60)), BaseDIR);
      $_SESSION['SESSION_TOKEN'] = $sess_id;
      $_SESSION['LifeTime'] = time();
      $LogQuery = "INSERT INTO `" . MySQL_Pre . "Logs` (`SessionID`, `IP`, `Referrer`, `UserAgent`, `UserID`, `URL`, `Action`, `Method`, `URI`) "
              . " Values('" . GetVal($_SESSION, 'ID') . "', '" . $_SERVER['REMOTE_ADDR'] . "', '"
              . GetVal($_SERVER, 'HTTP_REFERER', TRUE) . "', '"
              . GetVal($_SERVER, 'HTTP_USER_AGENT', TRUE) . "', '"
              . GetVal($_SESSION, 'UserMapID') . "', '"
              . $reg->SqlSafe($_SERVER['PHP_SELF']) . "', '" . $SessRet . " ("
              . $reg->SqlSafe($_SERVER['SCRIPT_NAME']) . ")', '"
              . $reg->SqlSafe($_SERVER['REQUEST_METHOD']) . "', '"
              . $reg->SqlSafe($_SERVER['REQUEST_URI']) . "');";
      $reg->do_ins_query($LogQuery);
    }
  }
  if (GetVal($_REQUEST, 'show_src') !== NULL) {
    echo $LogQuery;
    if ($_REQUEST['show_src'] == "me")
      show_source(substr($_SERVER['PHP_SELF'], 1, strlen($_SERVER['PHP_SELF'])));
  }
}

/**
 * Shows the menubar and menu items depending on the session
 */
function ShowMenuBar() {
  echo '<div class="MenuBar"><ul>';
  ShowMenuitem("Home", "index.php");
  if (GetVal($_SESSION, 'CheckAuth') !== "Valid") {
    ShowMenuitem("Log In!", "login.php");
  } else {
    ShowMenuitem("Data Entry", "srer/DataEntry.php");
    ShowMenuitem("Admin Page", "srer/Admin.php");
    ShowMenuitem("Reports", "srer/Reports.php");
    ShowMenuitem(GetVal($_SESSION, 'UserName') . "'s Profile", "Profile.php");
    ShowMenuitem("Manage Users", "Users.php");
    ShowMenuitem("User Activity", "AuditLogs.php");
    ShowMenuitem("Log Out!", "login.php?LogOut=1");
  }
  //ShowMenuitem(GetVal($_SESSION, 'CheckAuth'), "#");
  echo '</ul></div>';
}

function ShowMenuitem($Caption, $URL) {
  $Class = ($_SERVER['SCRIPT_NAME'] === BaseDIR . $URL) ? "SelMenuitems" : "Menuitems";
  echo '<li class = "' . $Class . '">'
  . '<a href = "' . GetAbsoluteURLFolder() . $URL . '">' . $Caption . '</a>'
  . '</li>';
}

/**
 * Shows a Captcha with a text Field
 *
 * @param bool $ShowImage If true Shows the captcha otherwise validates
 * @return bool
 */
function StaticCaptcha($ShowImage = FALSE) {
  require_once 'captcha/securimage.php';
  $options = array(
      'database_driver' => Securimage::SI_DRIVER_MYSQL,
      'database_host' => HOST_Name,
      'database_user' => MySQL_User,
      'database_pass' => MySQL_Pass,
      'database_name' => MySQL_DB,
      'database_table' => MySQL_Pre . "CaptchaCodes",
      'captcha_type' => Securimage::SI_CAPTCHA_MATHEMATIC,
      'no_session' => true);
  if ($ShowImage) {
    $captchaId = Securimage::getCaptchaId(true, $options);
    echo '<input type="hidden" id="captchaId" name="captchaId" value="' . $captchaId . '" />'
    . '<img id="siimage" src="ShowCaptcha.php?captchaId=' . $captchaId . '" alt="captcha image" /><br/>'
    . '<label for="captcha_code">Solve the above: </label><br/>'
    . '<input placeholder="Solution of the math" type="text" name="captcha_code" value="" required />';
  } else {
    $captcha_code = GetVal($_POST, 'captcha_code');
    if ($captcha_code !== NULL) {
      $VerifyID = GetVal($_POST, 'captchaId');
      $ValidCaptcha = Securimage::checkByCaptchaId($VerifyID, $captcha_code, $options);
      return $ValidCaptcha;
    }
  }
}

?>
