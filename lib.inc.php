<?php

include_once 'MySQLiDB.inc.php';

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
  echo '<link type="text/css" href="css/ui-lightness/jquery-ui-1.10.2.custom.min.css" rel="Stylesheet" />'
  . '<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>'
  . '<script type="text/javascript" src="js/jquery-ui-1.10.2.custom.min.js"></script>';
}

/**
 * IncludeJS($JavaScript)
 *
 * Generates Script tag
 *
 * @param string $JavaScript src including path
 */
function IncludeJS($JavaScript) {
  echo '<script type="text/javascript" src="' . $JavaScript . '"></script>';
}

/**
 * IncludeCSS([$CSS = "css/Style.css"])
 *
 * Generates link to css specified by $CSS
 *
 * @param string $CSS href including path
 */
function IncludeCSS($CSS = "css/Style.css") {
  echo '<link type="text/css" href="' . $CSS . '" rel="Stylesheet" />';
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

  //$_SESSION['Debug']=GetVal($_SESSION,'Debug')."InInitPage(".GetVal($_SESSION,'Client_SID')."=".GetVal($_COOKIE,'Client_SID').")";
  setcookie("Client_SID", $sess_id, (time() + (LifeTime * 60)));
  $_SESSION['Client_SID'] = $sess_id;
  $_SESSION['LifeTime'] = time();
  Html5Header($PageTitle);
  $t = GetVal($_SERVER, 'HTTP_REFERER');
  $reg = new MySQLiDB();
  $reg->do_ins_query("INSERT INTO " . MySQL_Pre . "Logs(IP,URL,UserAgent,Referrer,SessionID) values"
          . "('" . $_SERVER['REMOTE_ADDR'] . "','" . $_SERVER['PHP_SELF'] . "','" . $_SERVER['HTTP_USER_AGENT'] . "','<" . $t . ">','" . session_id() . "');");
  if (GetVal($_REQUEST, 'show_src')) {
    if (GetVal($_REQUEST, 'show_src') == "me")
      show_source(substr($_SERVER['PHP_SELF'], 1, strlen($_SERVER['PHP_SELF'])));
  }
}

/**
 * Returns value of an array element without cousing warning/error
 *
 * @param array $Array eg. $_SESSION
 * @param string $Index eg.
 * @return null|$Array[$Index]
 */
function GetVal($Array, $Index) {
  if (!isset($Array[$Index])) {
    return NULL;
  } else {
    return $Array[$Index];
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
    echo '<span class="Message">' . GetVal($_SESSION, 'Msg') . '</span><br/>';
    $_SESSION['Msg'] = "";
  }
}

/**
 * Displays visit Count and also logs the Visits in MySQL_Pre.Visits table
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
  $visitor_num = $reg->do_max_query("select VisitCount from " . MySQL_Pre . "Visits where PageURL='" . $_SERVER['PHP_SELF'] . "'");
  $LastVisit = $reg->do_max_query("select timestamp(LastVisit) from " . MySQL_Pre . "Visits where PageURL like '" . $_SERVER['PHP_SELF'] . "'");
  if ($visitor_num > 0)
    $reg->do_ins_query("update " . MySQL_Pre . "Visits set `VisitCount`=`VisitCount`+1, VisitorIP='" . $_SERVER['REMOTE_ADDR'] . "' where PageURL='" . $_SERVER['PHP_SELF'] . "'");
  else
    $reg->do_ins_query("Insert into " . MySQL_Pre . "Visits(PageURL,VisitorIP) values('" . $_SERVER['PHP_SELF'] . "','" . $_SERVER['REMOTE_ADDR'] . "')");
  $_SESSION['LifeTime'] = time();
  echo "<strong > Last Updated On:</strong> &nbsp;&nbsp;" . date("l d F Y g:i:s A ", filemtime($strfile))
  . " IST &nbsp;&nbsp;&nbsp;<b>Your IP: </b>" . $_SERVER['REMOTE_ADDR']
  . "&nbsp;&nbsp;&nbsp;<b>Visits:</b>&nbsp;&nbsp;" . $visitor_num
  . " <b>Last Visit:</b> " . date(" g:i:s A ", strtotime($LastVisit))
  . "";
  $reg->do_close();
}

/**
 * Static footer information
 */
function footerinfo() {
  echo 'Designed and Developed By <strong>National Informatics Centre</strong>, Paschim Medinipur District Centre<br/>'
  . 'L. A. Building (2nd floor), Collectorate Compound, Midnapore<br/>'
  . 'West Bengal - 721101 , India Phone : 91-3222-263506, Email: wbmdp(a)nic.in<br/>';
  //."DB_SID: ".$_SESSION['ID']." ORG: ".session_id()." Cookie:".$_COOKIE['LMS_SID']." VALID=".$_SESSION['Validity']." | ".LifeTime.$_SESSION['LMS_AUTH'];
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
              . "`UserID` varchar(20) DEFAULT NULL,"
              . "`URL` longtext,"
              . "`Action` longtext,"
              . "`Method` varchar(10) DEFAULT NULL,"
              . "`URI` longtext,"
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
      $SqlDB = "CREATE TABLE `" . MySQL_Pre . "Users` ("
              . "`UserID` varchar(255) DEFAULT NULL,"
              . "`UserName` varchar(255) DEFAULT NULL,"
              . "`UserPass` varchar(255) DEFAULT NULL,"
              . "`UserMapID` int(10) NOT NULL,"
              . "`Remarks` varchar(255) DEFAULT NULL,"
              . "`LoginCount` int(10) DEFAULT '0',"
              . "`LastLoginTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,"
              . "`Registered` tinyint(1) NOT NULL,"
              . "`Activated` tinyint(1) NOT NULL,"
              . " PRIMARY KEY (`UserMapID`)"
              . ") ENGINE=InnoDB DEFAULT CHARSET=utf8;";
      break;
    case "UsersData":
      $SqlDB = "INSERT INTO `" . MySQL_Pre . "Users` "
              . "VALUES ('admin','Administrator','ceb6c970658f31504a901b89dcd3e461',"
              . "0,NULL,14,'2013-05-03 22:47:45',1,1);";
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
      $ObjDB->do_ins_query(GetTableDefs("Logs"));
      $ObjDB->do_ins_query(GetTableDefs("Uploads"));
      $ObjDB->do_ins_query(GetTableDefs("Users"));
      $ObjDB->do_ins_query(GetTableDefs("UsersData"));
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
  if (GetVal($_SESSION, 'UserName') && GetVal($_SESSION, 'UserMapID')) {
    return "Browsing";
  }
  if (GetVal($_REQUEST, 'LogOut')) {
    return "LogOut";
  } else if (GetVal($_SESSION, 'LifeTime') < (time() - (LifeTime * 60))) {
    return "TimeOut(" . GetVal($_SESSION, 'LifeTime') . "-" . (time() - (LifeTime * 60)) . ")";
  } else if (GetVal($_SESSION, 'SESSION_TOKEN') != GetVal($_COOKIE, 'SESSION_TOKEN')) {
    $_SESSION['Debug'] = "(" . GetVal($_SESSION, 'SESSION_TOKEN') . "=" . GetVal($_COOKIE, 'SESSION_TOKEN') . ")";
    return "INVALID SESSION (" . GetVal($_SESSION, 'SESSION_TOKEN') . "=" . GetVal($_COOKIE, 'SESSION_TOKEN') . ")";
  } elseif (GetVal($_SESSION, 'ID') !== session_id()) {
    $_SESSION['Debug'] = "(" . GetVal($_SESSION, 'ID') . "=" . session_id() . ")";
    return "INVALID SESSION (" . GetVal($_SESSION, 'ID') . "=" . session_id() . ")";
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

  $_SESSION['Debug'] = GetVal($_SESSION, 'Debug') . "InInitPage(" . GetVal($_SESSION, 'SESSION_TOKEN') . "=" . GetVal($_COOKIE, 'SESSION_TOKEN') . ")";
  setcookie("SESSION_TOKEN", $sess_id, (time() + (LifeTime * 60)));
  $_SESSION['SESSION_TOKEN'] = $sess_id;
  $_SESSION['LifeTime'] = time();
  $t = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "");
  $reg = new MySQLiDB();
  $reg->do_ins_query("INSERT INTO " . MySQL_Pre . "Logs(IP,URL,UserAgent,Referrer) values"
          . "('" . $_SERVER['REMOTE_ADDR'] . "','" . htmlspecialchars($_SERVER['PHP_SELF']) . "','" . $_SERVER['HTTP_USER_AGENT']
          . "','<" . $t . ">');");
  if (GetVal($_REQUEST, 'show_src')) {
    if ($_REQUEST['show_src'] == "me")
      show_source(substr($_SERVER['PHP_SELF'], 1, strlen($_SERVER['PHP_SELF'])));
  }
}

function ShowMenuBar() {
  echo '<div class="MenuBar"><ul>';
  ShowMenuitem("Home", "index.php");
  if (CheckAuth() !== "Valid") {
    ShowMenuitem("Log In!", "login.php");
  } else {
    ShowMenuitem("Log Out!", "login.php?LogOut=1");
  }
  echo '</ul></div>';
}

function ShowMenuitem($Caption, $URL) {
  $Class = ($_SERVER['SCRIPT_NAME'] === BaseDIR . $URL) ? "SelMenuitems" : "Menuitems";
  echo '<li class="' . $Class . '">'
  . '<a href = "' . GetAbsoluteURLFolder() . $URL . '">' . $Caption . '</a>'
  . '</li>';
}

?>
