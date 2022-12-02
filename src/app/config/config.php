<?php
define('DB_TABLE_USERS', 'users');

define('COOKIE_AUTH', 'auth');
define('COOKIE_AUTH_SECRET', 'fikronganteng');
define('COOKIE_AUTH_TIME', 60 * 60 * 24);

define('BINOTIFY_APP_DB', getenv('BINOTIFY_APP_DB'));
define('BINOTIFY_APP_DB_USER', getenv('BINOTIFY_APP_DB_USER'));
define('BINOTIFY_APP_DB_PASSWORD', getenv('BINOTIFY_APP_DB_PASSWORD'));
define('BINOTIFY_APP_DB_NAME', getenv('BINOTIFY_APP_DB_NAME'));

define('BINOTIFY_APP_SOAP_API_KEY', getenv('BINOTIFY_APP_SOAP_API_KEY'));
// echo BINOTIFY_APP_SOAP_API_KEY;
?>