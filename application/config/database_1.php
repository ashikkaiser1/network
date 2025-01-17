<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'moremint_viru';
$db['default']['password'] = 'admin@123viru';
$db['default']['database'] = 'moremint_viral9';


//$db['default']['hostname'] = '206.189.74.170';
//$db['default']['username'] = 'partnersytzmedia';
//$db['default']['password'] = 'ObCeJHB7H5aQImmI';
//$db['default']['database'] = 'ytzmedia';

$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = FALSE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] =  APPPATH. 'cache/query/';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;
$db['default']['save_queries'] =TRUE;


$db['db_reader']['hostname'] = 'localhost';
$db['db_reader']['username'] = 'moremint_viru';
$db['db_reader']['password'] = 'admin@123viru';
$db['db_reader']['database'] = 'moremint_viral9';

//$db['db_reader']['hostname'] = '206.189.74.170';
//$db['db_reader']['username'] = 'partnersytzmedia';
//$db['db_reader']['password'] = 'ObCeJHB7H5aQImmI';
//$db['db_reader']['database'] = 'ytzmedia';

$db['db_reader']['dbdriver'] = 'mysqli';
$db['db_reader']['dbprefix'] = '';
$db['db_reader']['pconnect'] = FALSE;
$db['db_reader']['db_debug'] = FALSE;
$db['db_reader']['cache_on'] = FALSE;
$db['db_reader']['cachedir'] =  APPPATH. 'cache/query/';
$db['db_reader']['char_set'] = 'utf8';
$db['db_reader']['dbcollat'] = 'utf8_general_ci';
$db['db_reader']['swap_pre'] = '';
$db['db_reader']['autoinit'] = TRUE;
$db['db_reader']['stricton'] = FALSE;
$db['db_reader']['save_queries'] =TRUE;

 
/* End of file database.php */
/* Location: ./application/config/database.php */