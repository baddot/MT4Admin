<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('APP_HEADER',		'mt4-api-header');
define('DEVICE_ID',			'Device-id');
define('DEVICE_MODEL',		'Device-model');
define('OS_TYPE',			'Os-type');
define('OS_VERSION',		'Os-version');
define('APP_VERSION',		'App-version');
define('APP_MARKET',		'App-market');
define('APP_KEY',			'App-key');

define('ADMIN_DEBUG_MODE',	true);
define('ADMIN_TEST',	true);

define('MODE_ADD', 0);
define('MODE_UPDATE', 1);
define('MODE_REMOVE', 2);

define('VALUE_OK', -100);
define('VALUE_FAIL', -1);

define('VALUE_ALL', 0);

define('ADMIN_DEFAULT_LIST_CNT',	20);

define('RESULT_OK', 'SUCCESS');
define('RESULT_FAIL', 'FAIL');

define('SQL_ARRAY', 1);
define('SQL_CNT', 2);
define('SQL_ERROR', 3);

/* End of file constants.php */
/* Location: ./application/config/constants.php */
