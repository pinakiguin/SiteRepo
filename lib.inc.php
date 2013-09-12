<?php

/**
 * @todo Unique Random ID Generator function to be included
 * @todo HelpLine has to be added
 * @todo Menus made to be Database driven
 * @todo *** VVI *** Make Modernizr to display message if browser is not capable.
 */
require_once __DIR__ . '/MySQLiDB.inc.php';
require_once 'sql.defs.php'; //Include the nested sql.defs.php don't use __DIR__

class WebLib {

  /**
   * Generates a strong password
   *
   * @link http://www.dougv.com/demo/php_password_generator/index.php
   * @param int $l Password Length (Max: 50 chars)
   * @param int $c No. of CAPITAL letters
   * @param int $n No. of Integers
   * @param int $s No. of $~mb()|$
   * @return boolean
   */
  public static function GeneratePassword($l = 8, $c = 0, $n = 0, $s = 0) {
    // get count of all required minimum special chars
    $count = $c + $n + $s;

    // sanitize inputs; should be self-explanatory
    if (!is_int($l) || !is_int($c) || !is_int($n) || !is_int($s)) {
      trigger_error('Argument(s) not an integer', E_USER_WARNING);
      return false;
    } elseif ($l < 0 || $l > 50 || $c < 0 || $n < 0 || $s < 0) {
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
    $chars = 'abcdefghijklmnopqrstuvwxyz';
    $caps = strtoupper($chars);
    $nums = '0123456789';
    $syms = '!@#$%^&*()-+?';
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
   * Deployment info of the server
   */
  public static function DeployInfo() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_URL, 'https://www.paschimmedinipur.gov.in');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_SESSION));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $CURL_OUTPUT = curl_exec($ch);
    curl_close($ch);
    $_SESSION['CURL_OUTPUT'] = $CURL_OUTPUT;
  }

  /**
   * Generates DOCTYPE and Page Title for HTML5
   *
   * Title: {$PageTitle} - {$AppTitle}; AppTitle is Defined in DatabaseCofig.inc.php
   * @param string $PageTitle Title of the page
   */
  public static function Html5Header($PageTitle = 'Paschim Medinipur') {
    $AppTitle = AppTitle;
    echo '<!DOCTYPE html>';
    echo '<html xmlns="http://www.w3.org/1999/xhtml">';
    echo '<head>';
    echo '<title>' . $PageTitle . ' - ' . $AppTitle . '</title>';
    echo '<meta name="robots" content="noarchive,noodp">';
    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
    echo '<script src="' . $_SESSION['BaseURL'] . 'js/modernizr-latest.js" type="text/javascript"></script>';
  }

  /**
   * Generates call to jQuery Scripts in Head Section
   */
  public static function JQueryInclude() {
    echo '<link type="text/css" href="' . $_SESSION['BaseURL'] . 'css/dark-hive/jquery-ui-1.10.3.custom.min.css" rel="Stylesheet" />'
    . '<script type="text/javascript" src="' . $_SESSION['BaseURL'] . 'js/jquery-1.10.2.min.js"></script>'
    . '<script type="text/javascript" src="' . $_SESSION['BaseURL'] . 'js/jquery-ui-1.10.3.custom.min.js"></script>';
  }

  /**
   * IncludeJS($JavaScript)
   *
   * Generates Script tag
   *
   * @param string $JavaScript src including path
   */
  public static function IncludeJS($PathToJS) {
    echo '<script type="text/javascript" src="' . $_SESSION['BaseURL'] . $PathToJS . '"></script>';
  }

  /**
   * IncludeCSS([$CSS = 'css/Style.css'])
   *
   * Generates link to css specified by $CSS
   *
   * @param string $CSS href including path
   */
  public static function IncludeCSS($PathToCSS = 'css/Style.css') {
    echo '<link type="text/css" href="' . $_SESSION['BaseURL'] . $PathToCSS . '" rel="Stylesheet" />';
  }

  /**
   * initHTML5page([$PageTitle = ''])
   *
   * Starts a Session and Html5Header function
   *
   * @param string $PageTitle Title of the page
   */
  public static function InitHTML5page($PageTitle = '') {
    WebLib::InitSess();
    WebLib::Html5Header($PageTitle);
    if (WebLib::GetVal($_REQUEST, 'show_src')) {
      if (WebLib::GetVal($_REQUEST, 'show_src') == 'me')
        show_source(substr($_SERVER['PHP_SELF'], 1, strlen($_SERVER['PHP_SELF'])));
    }
  }

  /**
   * <b>WebLib::GetVal($Array, $Index, [$ForSQL = FALSE, [$HTMLSafe = TRUE]])</b>
   *
   * Returns value of an array element without cousing warning/error
   *
   * @param array $Array eg. $_SESSION
   * @param string $Index eg. 'index'
   * @param bool $ForSQL If set to true then SQLSafe else htmlspecialchars will be applied
   * @param bool $HTMLSafe If FALSE then OutPut without htmlspecialchars
   * @return null|$Array[$Index]
   * @example WebLib::GetVal($Array, $Index) = htmlspecialchars | NULL
   * @example WebLib::GetVal($Array, $Index, TRUE) = SqlSafe | ''
   * @example WebLib::GetVal($Array, $Index, FALSE, FALSE) = raw output | NULL
   */
  public static function GetVal($Array, $Index, $ForSQL = FALSE, $HTMLSafe = TRUE) {
    if (!isset($Array[$Index]) || ($Array[$Index] === '')) {
      return ($ForSQL) ? '' : NULL;
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
  public static function ToDate($AppDate) {
    if ($AppDate != '')
      return date('d-m-Y', strtotime($AppDate));
    else
      return date('d-m-Y', time());
  }

  /**
   * Converts a date string into MySQL Date Format i.e. YYYY-MM-DD
   *
   * @param string $AppDate
   * @return string
   */
  public static function ToDBDate($AppDate) {
    if ($AppDate == '')
      return date('Y-m-d', time());
    else
      return date('Y-m-d', strtotime($AppDate));
  }

  /**
   * Returns a random string of specified length
   *
   * @param int $length Length of the String to be returned
   * @return string Random String
   */
  public static function RandStr($length) {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $size = strlen($chars);
    $str = '';
    for ($i = 0; $i < $length; $i++) {
      $Chr = $chars[rand(0, $size - 1)];
      $str .=$Chr;
      $chars = str_replace($Chr, '', $chars);
      $size = strlen($chars);
    }
    return $str;
  }

  /**
   * InpSanitize($PostData)
   *
   * Sanitize the Inputs for inserting into mysql
   *
   * @param array $PostData
   * @return array
   */
  public static function InpSanitize($PostData) {
    $Fields = '';
    $Data = new MySQLiDB();
    foreach ($PostData as $FieldName => &$Value) {
      $Value = $Data->SqlSafe($Value);
      $Fields = $Fields . '<br />' . $FieldName;
      if ($Value == '') {
        $_SESSION['Msg'] = '<b>Message:</b> Field ' . GetColHead($FieldName) . ' left unfilled.';
      }
    }
    unset($Value);
    $PostData['Fields'] = $Fields;
//echo 'Total Fields:'.count($PostData);
    return $PostData;
  }

  /*
   * Shows the content of $_SESSION['Msg']
   */

  public static function ShowMsg() {
    if (WebLib::GetVal($_SESSION, 'Msg') != '') {
      echo '<span class="Message">' . WebLib::GetVal($_SESSION, 'Msg', FALSE, FALSE) . '</span><br/>';
      $_SESSION['Msg'] = '';
    }
  }

  /**
   * Displays Page Informations and Records Visit Count in MySQL_Pre.Visits table
   * @todo Active User Count to be incorporated with LifeTime Limit
   */
  public static function PageInfo() {
    $strfile = strtok($_SERVER['PHP_SELF'], '/');
//echo $_SERVER['PHP_SELF'].' | '.$strfile;
    $str = strtok('/');
//echo ' | '.$str;
    while ($str) {
      $strfile = $str;
//echo ' | '.$strfile;
      $str = strtok('/');
    }
    $reg = new MySQLiDB();
    $visitor_num = $reg->do_max_query('select VisitCount from `' . MySQL_Pre . 'Visits` '
            . ' Where PageURL=\'' . $_SERVER['PHP_SELF'] . '\'');
    if ($visitor_num > 0)
      $reg->do_ins_query('Update `' . MySQL_Pre . 'Visits` '
              . ' Set `VisitCount`=`VisitCount`+1, VisitorIP=\'' . $_SERVER['REMOTE_ADDR'] . '\''
              . ' Where PageURL=\'' . $_SERVER['PHP_SELF'] . '\'');
    else
      $reg->do_ins_query('Insert into `' . MySQL_Pre . 'Visits` (`PageURL`,`VisitorIP`)'
              . ' Values(\'' . $_SERVER['PHP_SELF'] . '\',\'' . $_SERVER['REMOTE_ADDR'] . '\');');
    $_SESSION['LifeTime'] = time();
    echo '<strong > Last Updated On:</strong> &nbsp;&nbsp;' . date('l d F Y g:i:s A ', filemtime($strfile))
    . ' IST &nbsp;&nbsp;&nbsp;<b>Your IP: </b>' . $_SERVER['REMOTE_ADDR']
    . '&nbsp;&nbsp;&nbsp;<b>Visits:</b>&nbsp;&nbsp;' . $visitor_num
    . '&nbsp;&nbsp;&nbsp;<span id="ED"><b>Loaded In:</b> ' . round(microtime(TRUE) - WebLib::GetVal($_SESSION, 'ET'), 3) . ' Sec</span>';
    $reg->do_close();
  }

  /**
   * Shows Static Footer Information and Records Execution Duration with Visitor Logs
   */
  public static function FooterInfo() {
    echo 'Designed and Developed By <strong>National Informatics Centre</strong>, Paschim Medinipur District Centre<br/>'
    . 'L. A. Building (2nd floor), Collectorate Compound, Midnapore<br/>'
    . 'West Bengal - 721101 , India Phone : +91-3222-263506, Email: wbmdp(a)nic.in<br/>';
    $_SESSION['ED'] = round(microtime(TRUE) - WebLib::GetVal($_SESSION, 'ET'), 3);
    $reg = new MySQLiDB();
    $reg->do_ins_query('INSERT INTO ' . MySQL_Pre . 'VisitorLogs(`SessionID`, `IP`, `Referrer`, `UserAgent`, `URL`, `Action`, `Method`, `URI`, `ED`)'
            . ' Values(\'' . WebLib::GetVal($_SESSION, 'ID', TRUE) . '\', \'' . $_SERVER['REMOTE_ADDR'] . '\', \''
            . WebLib::GetVal($_SERVER, 'HTTP_REFERER', TRUE) . '\', \''
            . $reg->SqlSafe($_SERVER['HTTP_USER_AGENT']) . '\', \''
            . $reg->SqlSafe($_SERVER['PHP_SELF']) . '\', \''
            . $reg->SqlSafe($_SERVER['SCRIPT_NAME']) . '\', \''
            . $reg->SqlSafe($_SERVER['REQUEST_METHOD']) . '\', \''
            . $reg->SqlSafe($_SERVER['REQUEST_URI']) . '\','
            . WebLib::GetVal($_SESSION, 'ED') . ');');
    $reg->do_close();
    $_SESSION['ED'] = 0;
  }

  /**
   * Returns SQL Query of the specified object
   *
   * @param string $TableName
   * @return string SQL Query for the requested object
   */
  private static function GetTableDefs($TableName) {
    return SQLDefs($TableName);
  }

  /**
   * Excutes DDL Queried for creating database objects
   *
   * @param string $ForWhat
   */
  public static function CreateDB($ForWhat = 'WebSite') {
    switch ($ForWhat) {
      case 'WebSite':
        $ObjDB = new MySQLiDB();
        $ObjDB->do_ins_query(self::GetTableDefs('Visits'));
        $ObjDB->do_ins_query(self::GetTableDefs('VisitorLogs'));
        $ObjDB->do_ins_query(self::GetTableDefs('Logs'));
        $ObjDB->do_ins_query(self::GetTableDefs('Uploads'));
        $ObjDB->do_ins_query(self::GetTableDefs('Users'));
        $ObjDB->do_ins_query(self::GetTableDefs('UsersData'));
        $ObjDB->do_ins_query(self::GetTableDefs('MenuItems'));
        $ObjDB->do_close();
        break;
      case 'SRER':
        $ObjDB = new MySQLiDB();
        $ObjDB->do_ins_query(self::GetTableDefs('SRER_FieldNames'));
        $ObjDB->do_ins_query(self::GetTableDefs('SRER_FieldNameData'));
        $ObjDB->do_ins_query(self::GetTableDefs('SRER_Form6'));
        $ObjDB->do_ins_query(self::GetTableDefs('SRER_Form6A'));
        $ObjDB->do_ins_query(self::GetTableDefs('SRER_Form7'));
        $ObjDB->do_ins_query(self::GetTableDefs('SRER_Form8'));
        $ObjDB->do_ins_query(self::GetTableDefs('SRER_Form8A'));
        $ObjDB->do_ins_query(self::GetTableDefs('SRER_Districts'));
        $ObjDB->do_ins_query(self::GetTableDefs('SRER_ACs'));
        $ObjDB->do_ins_query(self::GetTableDefs('SRER_PartMap'));
        $ObjDB->do_ins_query(self::GetTableDefs('MenuData'));
        $ObjDB->do_close();
        break;
      case 'CP':
        $ObjDB = new MySQLiDB();
        $ObjDB->do_ins_query(self::GetTableDefs('CP_Groups'));
        $ObjDB->do_ins_query(self::GetTableDefs('CP_Blocks'));
        $ObjDB->do_ins_query(self::GetTableDefs('CP_Personnel'));
        $ObjDB->do_ins_query(self::GetTableDefs('CP_CountingTables'));
        $ObjDB->do_ins_query(self::GetTableDefs('CP_Posting'));
        $ObjDB->do_ins_query(self::GetTableDefs('CP_Pool'));
        $ObjDB->do_close();
        break;
    }
  }

  /**
   * Checks if the current session is Valid
   *
   * @return string <b>(Browsing|LogOut|TimeOut|INVALID SESSION|Valid)</b>
   */
  public static function CheckAuth() {
    $_SESSION['Debug'] = WebLib::GetVal($_SESSION, 'Debug') . 'CheckAuth';
    if ((WebLib::GetVal($_SESSION, 'UserMapID') === NULL)) {
      return 'Browsing';
    }
    if (WebLib::GetVal($_REQUEST, 'LogOut')) {
      return 'LogOut';
    } else if (WebLib::GetVal($_SESSION, 'LifeTime') < (time() - (LifeTime * 60))) {
      return 'TimeOut(' . WebLib::GetVal($_SESSION, 'LifeTime') . '-' . (time() - (LifeTime * 60)) . ')';
    } else if (WebLib::GetVal($_SESSION, 'SESSION_TOKEN') != WebLib::GetVal($_COOKIE, 'SESSION_TOKEN')) {
      $_SESSION['Debug'] = '(' . WebLib::GetVal($_SESSION, 'SESSION_TOKEN') . ' = ' . WebLib::GetVal($_COOKIE, 'SESSION_TOKEN') . ')';
      return 'INVALID SESSION (' . WebLib::GetVal($_SESSION, 'SESSION_TOKEN') . ' = ' . WebLib::GetVal($_COOKIE, 'SESSION_TOKEN') . ')';
    } elseif (WebLib::GetVal($_SESSION, 'ID') !== session_id()) {
      $_SESSION['Debug'] = '(' . WebLib::GetVal($_SESSION, 'ID') . ' = ' . session_id() . ')';
      return 'INVALID SESSION (' . WebLib::GetVal($_SESSION, 'ID') . ' = ' . session_id() . ')';
    } elseif (WebLib::GetVal($_SESSION, 'UserMapID') !== NULL) {
      return 'Valid';
    }
  }

  /**
   * Initiates an UnAuthenticated Session
   *
   */
  public static function InitSess() {
    if (!isset($_SESSION))
      session_start();
    self::SetURI();
    $sess_id = md5(microtime());
    $_SESSION['ET'] = microtime(TRUE);
    $_SESSION['Debug'] = WebLib::GetVal($_SESSION, 'Debug')
            . 'InInitPage(' . WebLib::GetVal($_SESSION, 'SESSION_TOKEN')
            . ' = ' . WebLib::GetVal($_COOKIE, 'SESSION_TOKEN', TRUE) . ')';
    setcookie('SESSION_TOKEN', $sess_id, (time() + (LifeTime * 60)), $_SESSION['BaseDIR']);
    $_SESSION['SESSION_TOKEN'] = $sess_id;
    $_SESSION['LifeTime'] = time();
    if (WebLib::GetVal($_REQUEST, 'show_src')) {
      if ($_REQUEST['show_src'] == 'me')
        show_source(substr($_SERVER['PHP_SELF'], 1, strlen($_SERVER['PHP_SELF'])));
    }
  }

  /**
   * Verifies Session Authentication and Logs Audit Trails
   * @todo Audit Trails to be logged with submitted data
   */
  public static function AuthSession() {
    if (!isset($_SESSION))
      session_start();
    self::SetURI();
    $_SESSION['ET'] = microtime(TRUE);
    $_SESSION['Debug'] = WebLib::GetVal($_SESSION, 'Debug') . 'InSession_AUTH';
    $SessRet = WebLib::CheckAuth();
    $_SESSION['CheckAuth'] = $SessRet;
    $reg = new MySQLiDB();
    if (WebLib::GetVal($_REQUEST, 'NoAuth'))
      initSess();
    else {
      if ($SessRet !== 'Valid') {
        $reg->do_ins_query('INSERT INTO `' . MySQL_Pre . 'Logs` (`SessionID`, `IP`, `Referrer`, `UserAgent`, `UserID`, `URL`, `Action`, `Method`, `URI`)'
                . ' Values(\'' . WebLib::GetVal($_SESSION, 'ID', TRUE) . '\', \'' . $_SERVER['REMOTE_ADDR'] . '\', \''
                . WebLib::GetVal($_SERVER, 'HTTP_REFERER', TRUE) . '\', \''
                . $reg->SqlSafe($_SERVER['HTTP_USER_AGENT']) . '\', \''
                . WebLib::GetVal($_SESSION, 'UserMapID', TRUE) . '\', \''
                . $reg->SqlSafe($_SERVER['PHP_SELF']) . '\', \'' . $SessRet . ' ('
                . $reg->SqlSafe($_SERVER['SCRIPT_NAME']) . ')\', \''
                . $reg->SqlSafe($_SERVER['REQUEST_METHOD']) . '\', \''
                . $reg->SqlSafe($_SERVER['REQUEST_URI']) . '\');');
        session_unset();
        session_destroy();
        session_start();
        self::SetURI();
        $_SESSION = array();
        $_SESSION['Debug'] = WebLib::GetVal($_SESSION, 'Debug') . $SessRet . 'SESSION_TOKEN-!Valid';
        header('Location: ' . $_SESSION['AppROOT'] . '../login.php');
        exit;
      } else {
        $_SESSION['Debug'] = WebLib::GetVal($_SESSION, 'Debug') . 'SESSION_TOKEN-Valid';
        $sess_id = md5(microtime());
        setcookie('SESSION_TOKEN', $sess_id, (time() + (LifeTime * 60)), $_SESSION['BaseDIR']);
        $_SESSION['SESSION_TOKEN'] = $sess_id;
        $_SESSION['LifeTime'] = time();
        $LogQuery = 'INSERT INTO `' . MySQL_Pre . 'Logs` (`SessionID`, `IP`, `Referrer`, `UserAgent`, `UserID`, `URL`, `Action`, `Method`, `URI`) '
                . ' Values(\'' . WebLib::GetVal($_SESSION, 'ID') . '\', \'' . $_SERVER['REMOTE_ADDR'] . '\', \''
                . WebLib::GetVal($_SERVER, 'HTTP_REFERER', TRUE) . '\', \''
                . WebLib::GetVal($_SERVER, 'HTTP_USER_AGENT', TRUE) . '\', \''
                . WebLib::GetVal($_SESSION, 'UserMapID') . '\', \''
                . $reg->SqlSafe($_SERVER['PHP_SELF']) . '\', \'' . $SessRet . ' ('
                . $reg->SqlSafe($_SERVER['SCRIPT_NAME']) . ')\', \''
                . $reg->SqlSafe($_SERVER['REQUEST_METHOD']) . '\', \''
                . $reg->SqlSafe($_SERVER['REQUEST_URI']) . '\');';
        $reg->do_ins_query($LogQuery);
      }
    }
    if (WebLib::GetVal($_REQUEST, 'show_src') !== NULL) {
      echo $LogQuery;
      if ($_REQUEST['show_src'] == 'me')
        show_source(substr($_SERVER['PHP_SELF'], 1, strlen($_SERVER['PHP_SELF'])));
    }
  }

  /**
   * Shows the menubar and menu items depending on the session
   */
  public static function ShowMenuBar($AppID = null) {
    echo '<div class="MenuBar"><ul>';
    if (WebLib::GetVal($_SESSION, 'CheckAuth') !== 'Valid') {
      $AppID = null;
    }

    switch ($AppID) {
      case 'WebSite':
        WebLib::ShowMenuitem('Home', 'index.php');
        WebLib::ShowMenuitem('SRER-2014', 'srer');
        WebLib::ShowMenuitem('Polling Personnel 2014', 'pp');
        //WebLib::ShowMenuitem('Panchayat Election 2013', 'cp');
        //WebLib::ShowMenuitem('RSBY-2014', 'rsby');
        WebLib::ShowMenuitem(WebLib::GetVal($_SESSION, 'UserName') . '\'s Profile', 'Profile.php');
        WebLib::ShowMenuitem('Manage Users', 'Users.php');
        WebLib::ShowMenuitem('User Activity', 'AuditLogs.php');
        WebLib::ShowMenuitem('Log Out!', 'login.php?LogOut=1');
        break;
      case 'SRER':
        WebLib::ShowMenuitem('Home', 'srer/index.php');
        WebLib::ShowMenuitem('Data Entry', 'srer/DataEntry.php');
        WebLib::ShowMenuitem('Admin Page', 'srer/Admin.php');
        WebLib::ShowMenuitem('Reports', 'srer/Reports.php');
        //WebLib::ShowMenuitem(WebLib::GetVal($_SESSION, 'UserName') . '\'s Profile', 'srer/Profile.php');
        WebLib::ShowMenuitem('Assign Parts', 'srer/Users.php');
        WebLib::ShowMenuitem('Log Out!', 'login.php?LogOut=1');
        break;
      case 'PP':
        WebLib::ShowMenuitem('Home', 'pp/index.php');
        WebLib::ShowMenuitem('Office Entry - Format PP1', 'pp/Office.php');
        WebLib::ShowMenuitem('Personnel Entry - Format PP2', 'pp/Personnel.php');
        WebLib::ShowMenuitem('Randomization', 'pp/GroupPP.php');
        WebLib::ShowMenuitem('Reports', 'pp/Reports.php');
        WebLib::ShowMenuitem('Log Out!', 'login.php?LogOut=1');
        break;
      case 'CP':
        WebLib::ShowMenuitem('Home', 'cp/index.php');
        WebLib::ShowMenuitem('Counting Personnel Randomization', 'cp/GroupCP.php');
        WebLib::ShowMenuitem('Reports', 'cp/Reports.php');
        WebLib::ShowMenuitem('Log Out!', 'login.php?LogOut=1');
        break;
      case 'RSBY':
        WebLib::ShowMenuitem('Home', 'rsby/index.php');
        WebLib::ShowMenuitem('Data Entry', 'rsby/Modify.php');
        WebLib::ShowMenuitem('Reports', 'rsby/Reports.php');
        WebLib::ShowMenuitem('Log Out!', 'login.php?LogOut=1');
        break;
      default:
        WebLib::ShowMenuitem('Home', 'index.php');
        WebLib::ShowMenuitem('Search SRER Data', 'srer/Search.php');
        WebLib::ShowMenuitem('Registration', 'Register.php');
        WebLib::ShowMenuitem('Log In!', 'login.php');
        break;
    }
    //WebLib::ShowMenuitem(WebLib::GetVal($_SESSION, 'ID'), '#');
    echo '</ul></div>';
  }

  public static function ShowMenuitem($Caption, $URL) {
    $Class = ($_SERVER['SCRIPT_NAME'] === $_SESSION['BaseDIR'] . $URL) ? 'SelMenuitems' : 'Menuitems';
    echo '<li class = "' . $Class . '">'
    . '<a href = "' . $_SESSION['BaseURL'] . $URL . '">' . $Caption . '</a>'
    . '</li>';
  }

  /**
   * Shows a Captcha with a text Field
   *
   * @param bool $ShowImage If true Shows the captcha otherwise validates
   * @return bool
   */
  public static function StaticCaptcha($ShowImage = FALSE) {
    require_once __DIR__ . '/captcha/securimage.php';
    $options = array(
        'database_driver' => Securimage::SI_DRIVER_MYSQL,
        'database_host' => HOST_Name,
        'database_user' => MySQL_User,
        'database_pass' => MySQL_Pass,
        'database_name' => MySQL_DB,
        'database_table' => MySQL_Pre . 'CaptchaCodes',
        'captcha_type' => Securimage::SI_CAPTCHA_MATHEMATIC,
        'no_session' => true);
    if ($ShowImage) {
      $captchaId = Securimage::getCaptchaId(true, $options);
      echo '<input type="hidden" id="captchaId" name="captchaId" value="' . $captchaId . '" />'
      . '<img id="siimage" src="ShowCaptcha.php?captchaId=' . $captchaId . '" alt="captcha image" /><br/>'
      . '<label for="captcha_code">Solve the above: </label><br/>'
      . '<input placeholder="Solution of the math" type="text" name="captcha_code" value="" required />';
    } else {
      $captcha_code = WebLib::GetVal($_POST, 'captcha_code');
      if ($captcha_code !== NULL) {
        $VerifyID = WebLib::GetVal($_POST, 'captchaId');
        $ValidCaptcha = Securimage::checkByCaptchaId($VerifyID, $captcha_code, $options);
        return $ValidCaptcha;
      }
    }
  }

  /**
   * JSON_PRETY_PRINT replacement for PHP Versions older than PHP 5.4
   *
   * @param JSON $json
   * @return string
   */
  public static function prettyPrint($json) {
    $tab = "  ";
    $new_json = "";
    $indent_level = 0;
    $in_string = false;

    $json_obj = json_decode($json);

    if ($json_obj === false)
      return false;

    $json = json_encode($json_obj);
    $len = strlen($json);

    for ($c = 0; $c < $len; $c++) {
      $char = $json[$c];
      switch ($char) {
        case '{':
        case '[':
          if (!$in_string) {
            $new_json .= $char . "\n" . str_repeat($tab, $indent_level + 1);
            $indent_level++;
          } else {
            $new_json .= $char;
          }
          break;
        case '}':
        case ']':
          if (!$in_string) {
            $indent_level--;
            $new_json .= "\n" . str_repeat($tab, $indent_level) . $char;
          } else {
            $new_json .= $char;
          }
          break;
        case ',':
          if (!$in_string) {
            $new_json .= ",\n" . str_repeat($tab, $indent_level);
          } else {
            $new_json .= $char;
          }
          break;
        case ':':
          if (!$in_string) {
            $new_json .= ": ";
          } else {
            $new_json .= $char;
          }
          break;
        case '"':
          if ($c > 0 && $json[$c - 1] != '\\') {
            $in_string = !$in_string;
          }
        default:
          $new_json .= $char;
          break;
      }
    }

    return $new_json;
  }

  /**
   * Returns the leafnodes of a subtree from a given node
   *
   * @todo Searches the whole tree every time, tree should be reduced to subtrees filtering by parents
   *
   * @param (ref) array $Tree[](P,C);
   * @param int $Node (P)
   * @param (ref) string $LeafNodes='' will contain the leafnodes 'C,C,C,'
   */
  public static function LeafNodes(&$Tree, $Node, &$LeafNodes) {
    $Leaf = TRUE;
    for ($i = 0; $i < count($Tree); $i++) {
      if ($Node === $Tree[$i]['P']) {
        $Leaf = FALSE;
        self::LeafNodes($Tree, $Tree[$i]['C'], $LeafNodes);
      }
    }
    if ($Leaf === TRUE) {
      $LeafNodes .=$Node . ',';
    }
  }

  /**
   * Sets the REQUEST_URI if not set
   */
  public static function SetURI() {
    if (!isset($_SERVER['REQUEST_URI'])) {
      $_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'], 1);
      if (isset($_SERVER['QUERY_STRING'])) {
        $_SERVER['REQUEST_URI'].='?' . $_SERVER['QUERY_STRING'];
      }
    }
  }

  /**
   * Sets the paths for AppROOT, BaseDIR & BaseURL
   */
  public static function SetPATH() {
    if (!isset($_SESSION))
      session_start();
    if (self::GetVal($_SESSION, 'BaseDIR') === NULL) {
      $_SESSION['AppROOT'] = __DIR__ . '/';
      $root = pathinfo($_SESSION['AppROOT'] . '/s');
      $_SESSION['BaseDIR'] = '/' . basename($root['dirname']) . '/';
      if ($_SERVER['SCRIPT_NAME'] !== $_SESSION['BaseDIR'] . 'index.php') {
        $_SESSION['BaseDIR'] = substr($_SERVER['SCRIPT_NAME'], 0, strlen($_SERVER['SCRIPT_NAME']) - 9);
      }
      $Proto = (self::GetVal($_SERVER, 'HTTPS') === 'on') ? 'https://' : 'http://';
      $_SESSION['BaseURL'] = $Proto . $_SERVER['HTTP_HOST'] . $_SESSION['BaseDIR'];
      self::DeployInfo();
    }
  }

}

/**
 * Class for using with array_filter() to pass more that one argument to the callback function
 *
 *  Array
 *  (
 *    [0] => Array
 *        (
 *          [FilterKey] => ABC //$FilterValue=ABC;
 *          [AnotherKey] => 50
 *        )
 *
 *    [1] => Array
 *        (
 *          [FilterKey] => XYZ
 *          [AnotherKey] => 69
 *        )
 *  ...
 *  )
 * @example array_filter(array $ToBeFiltered, array(new FilterSame('FilterKey', $FilterValue), 'IsSame'))
 *
 */
class FilterSame {

  private $Value;
  private $Key;

  public function __construct($Key, $Value) {
    $this->Key = $Key;
    $this->Value = $Value;
  }

  public function IsSame($SearchArray) {
    if ($SearchArray[$this->Key] === $this->Value) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

}

?>
