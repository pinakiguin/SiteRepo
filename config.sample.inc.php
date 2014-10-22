<?php

/**
 * Defined constants for database, session and page
 * @version v1.0
 */
/**
 * Defines MySQL Server Hostname
 */
const DB_HOST = 'localhost';

/**
 * Defines MySQL Server Username
 */
const DB_USER = 'root';

/**
 * Defines MySQL Server password
 */
const DB_PASS = 'mysql';

/**
 * Defines MySQL Server Database Name
 */
const DB_NAME = 'WebSite';

/**
 * Defines MySQL Database Table Prefix
 */
const TABLE_PREFIX = 'WebSite_';

/**
 * Defines Session Timeout value in minutes
 */
const SESSION_LIFETIME_MINUTES = '20';

/**
 * Defines District Code to display SRER Reports
 */
const DIST_CODE = '16';

/**
 * Defines Title of the page
 */
const APP_NAME = 'Paschim Medinipur';

/**
 * Defines Application's Unique Installation ID
 *
 * 1. Validates Against Multiple applications in the same domain
 * 2. Used to Encrypt Passwords in Database (kept at server side never sent to client)
 */
const APP_KEY = 'eKHQ5CP3798k7quyxGfR48vX';

/**
 * Defines Existence of tables
 *
 * If set to TRUE then Database tables will be created
 */
const NEEDS_CREATE_DB = true;

/**
 * Defines use of SMS Gateway
 *
 * If set to TRUE then SMSs will be Sent
 */
const USE_SMS_GATEWAY = false;

/**
 * Google API Credentials
 */
const CLIENT_ID = '<YOUR_CLIENT_ID>';
const CLIENT_SECRET = '<YOUR_CLIENT_SECRET>';
const REDIRECT_URI = '<YOUR_REDIRECT_URI>';
