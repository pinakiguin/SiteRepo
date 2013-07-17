<?php

/**
 * Defined constants for database, session and page
 * @version v1.0
 */
/**
 * Defines MySQL Server Hostname
 */
define('HOST_Name', 'localhost');
/**
 * Defines MySQL Server Username
 */
define('MySQL_User', 'root');
/**
 * Defines MySQL Server password
 */
define('MySQL_Pass', 'mysql');
/**
 * Defines MySQL Server DB Name
 */
define('MySQL_DB', 'WebSite');
/**
 * Defines MySQL Server Hostname
 */
define('MySQL_Pre', 'WebSite_');
/**
 * Defines Session Timeout value in minutes
 */
define('LifeTime', '20');
/**
 * Defines path after Hostname of the script to generate menu links
 */
define('BaseDIR', '/SiteRepo/');
/**
 * Defines Title of the page
 */
define('AppTitle', 'Paschim Medinipur');
/**
 * Defines Application's Unique Installation ID
 *
 * 1. Validates Against Multiple sessions
 * 2. Used to Encrypt Passwords in Database
 */
define('AppKey', 'e$#KH+)&Q5&CP3798k7$quyxGfR48+vX');
/**
 * Defines Existence of tables
 *
 * If set to TRUE then Databse will be created
 */
define('NeedsDB', TRUE);
?>
