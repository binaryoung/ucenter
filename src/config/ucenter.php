<?php

return [
    'connect' 		=> env('UC_CONNECT', 'mysql'),
    'dbhost' 		=> env('UC_DBHOST', 'localhost'),
    'dbuser' 		=> env('UC_DBUSER', 'root'),
    'dbpw' 			=> env('UC_DBPW', 'root'),
    'dbname' 		=> env('UC_DBNAME', 'ucenter'),
    'dbcharset' 	=> env('UC_DBCHARSET', 'utf8'),
    'dbtablepre' 	=> env('UC_DBTABLEPRE', 'uc_'),
    'dbconnect' 	=> env('UC_DBCONNECT', '0'),
    'key' 			=> env('UC_KEY', '666cLXgFsrl6TcvDflhrvdcziY8SnhP1eexl1eQ'),
    'api' 			=> env('UC_API', 'http://localhost/ucenter'),
    'ip' 			=> env('UC_IP', '127.0.0.1'),
    'charset' 		=> env('UC_CHARSET', 'utf-8'),
    'appid' 		=> env('UC_APPID', '1'),
    'ppp' 			=> env('UC_PPP', '20'),
];
