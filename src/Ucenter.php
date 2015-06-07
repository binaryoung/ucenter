<?php namespace Binaryoung\Ucenter;

use Config;

class Ucenter
{
    public function __construct()
    {

        if (!defined('UC_DBHOST')) {
            $config = Config::get('ucenter');
            define('UC_CONNECT', $config['connect']);
            define('UC_DBHOST', $config['dbhost']);
            define('UC_DBUSER', $config['dbuser']);
            define('UC_DBPW', $config['dbpw']);
            define('UC_DBNAME', $config['dbname']);
            define('UC_DBCONNECT', $config['dbconnect']);
            define('UC_DBCHARSET', $config['dbcharset']);
            define('UC_DBTABLEPRE', $config['dbtablepre']);
            if (!defined('UC_KEY')) {
            define('UC_KEY', $config['key']);
            }
            define('UC_API', $config['api']);
            define('UC_CHARSET', $config['charset']);
            define('UC_IP', $config['ip']);
            define('UC_APPID', $config['appid']);
            define('UC_PPP', $config['ppp']);
            include __DIR__.'/uc_client/client.php';
        }

    }

    public function __call($function, $arguments)
    {
        if (function_exists($function)) {
            return call_user_func_array($function, $arguments);
        } else {
            throw new Exception("function not exists");           
        }
    }
}
