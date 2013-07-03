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
 * Generates Script tag
 *
 * @param string $JavaScript src including path
 */
function IncludeJS($JavaScript) {
  echo '<script type="text/javascript" src="' . $JavaScript . '"></script>';
}

/**
 * Generates link to css specified by $CSS
 *
 * @param string $CSS href including path
 */
function IncludeCSS($CSS = "css/Style.css") {
  echo '<link type="text/css" href="' . $CSS . '" rel="Stylesheet" />';
}

/**
 * Starts a Session and Html5Header function
 */
function initHTML5page() {
  session_start();
  $sess_id = md5(microtime());

  //$_SESSION['Debug']=$_SESSION['Debug']."InInitPage(".$_SESSION['Client_SID']."=".$_COOKIE['Client_SID'].")";
  setcookie("Client_SID", $sess_id, (time() + (LifeTime * 60)));
  $_SESSION['Client_SID'] = $sess_id;
  $_SESSION['LifeTime'] = time();
  Html5Header();
  $t = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "");
  $reg = new DB();
  $reg->do_ins_query("INSERT INTO " . MySQL_Pre . "Logs(IP,URL,UserAgent,Referrer,SessionID) values"
          . "('" . $_SERVER['REMOTE_ADDR'] . "','" . $_SERVER['PHP_SELF'] . "','" . $_SERVER['HTTP_USER_AGENT'] . "','<" . $t . ">','" . session_id() . "');");
  if (isset($_REQUEST['show_src'])) {
    if ($_REQUEST['show_src'] == "me")
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

?>
