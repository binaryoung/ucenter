<?php namespace Binaryoung\Ucenter;

use Config;

define('UC_CLIENT_VERSION', '1.6.0');    //note UCenter 版本标识
define('UC_CLIENT_RELEASE', '20110501');

define('API_DELETEUSER', 1);        //note 用户删除 API 接口开关
define('API_RENAMEUSER', 1);        //note 用户改名 API 接口开关
define('API_GETTAG', 1);        //note 获取标签 API 接口开关
define('API_SYNLOGIN', 1);        //note 同步登录 API 接口开关
define('API_SYNLOGOUT', 1);        //note 同步登出 API 接口开关
define('API_UPDATEPW', 1);        //note 更改用户密码 开关
define('API_UPDATEBADWORDS', 1);    //note 更新关键字列表 开关
define('API_UPDATEHOSTS', 1);        //note 更新域名解析缓存 开关
define('API_UPDATEAPPS', 1);        //note 更新应用列表 开关
define('API_UPDATECLIENT', 1);        //note 更新客户端缓存 开关
define('API_UPDATECREDIT', 1);        //note 更新用户积分 开关
define('API_GETCREDITSETTINGS', 1);    //note 向 UCenter 提供积分设置 开关
define('API_GETCREDIT', 1);        //note 获取用户的某项积分 开关
define('API_UPDATECREDITSETTINGS', 1);    //note 更新应用积分设置 开关

define('API_RETURN_SUCCEED', 1);
define('API_RETURN_FAILED', -1);
define('API_RETURN_FORBIDDEN', -2);

define('UC_KEY', Config::get('ucenter.key'));

define('API_ROOT', __DIR__.'/');

class Api implements Contracts\Api
{

    public static function init()
    {
        $get = $post = array();
        $code = isset($_GET['code'])?trim($_GET['code']):'';
        parse_str(self::authcode($code, 'DECODE', UC_KEY), $get);
        $timestamp = time();
        if (empty($get)) {
            return 'Invalid Request';
        } elseif ($timestamp - $get['time'] > 3600) {
            return 'Authracation has expiried';
        }
        $action = $get['action'];
        $post = self::unserialize(file_get_contents('php://input'));
        $actionList = array(
            'test',
            'deleteuser',
            'renameuser',
            'gettag',
            'synlogin',
            'synlogout',
            'updatepw',
            'updatebadwords',
            'updatehosts',
            'updateapps',
            'updatesmsapi',
            'updateclient',
            'updatecredit',
            'getcreditsettings',
            'updatecreditsettings'
        );
        if (in_array($get['action'], $actionList)) {
            return self::$get['action']($get, $post);
        } else {
            return API_RETURN_FAILED;
        }
    }
    
    public static function test()
    {
        return API_RETURN_SUCCEED;
    }
    
    public static function deleteuser($get, $post)
    {
        $uids = $get['ids'];
        if (! API_DELETEUSER) {
            return API_RETURN_FORBIDDEN;
        }
        return API_RETURN_SUCCEED;
    }
    
    public static function renameuser($get, $post)
    {
        $uid = $get['uid'];
        $usernameold = $get['oldusername'];
        $usernamenew = $get['newusername'];
        if (!API_RENAMEUSER) {
            return API_RETURN_FORBIDDEN;
        }
        
        return API_RETURN_SUCCEED;
    }
    
    public static function gettag($get, $post)
    {
        $name = $get['id'];
        if (!API_GETTAG) {
            return API_RETURN_FORBIDDEN;
        }
        
        $return = array();
        return self::serialize($return, 1);
    }

    public static function synlogin($get, $post)
    {
        $uid = $get['uid'];
        ;
        $username = $get['username'];
        if (!API_SYNLOGIN) {
            return API_RETURN_FORBIDDEN;
        }
        /*
        
        同步登陆代码
        
        */
        return API_RETURN_SUCCEED;
    }

    public static function synlogout($get, $post)
    {
        if (!API_SYNLOGOUT) {
            return API_RETURN_FORBIDDEN;
        }
        /*
        
        同步注销代码
        
        */
        return API_RETURN_SUCCEED;
    }

    public static function updatepw($get, $post)
    {
        if (!API_UPDATEPW) {
            return API_RETURN_FORBIDDEN;
        }
        $username = $get['username'];
        $password = $get['password'];
        return API_RETURN_SUCCEED;
    }

    public static function updatebadwords($get, $post)
    {
        if (!API_UPDATEBADWORDS) {
            return API_RETURN_FORBIDDEN;
        }
        $cachefile = API_ROOT.'uc_client/data/cache/badwords.php';
        $fp = fopen($cachefile, 'w');
        $data = array();
        if (is_array($post)) {
            foreach ($post as $k => $v) {
                $data['findpattern'][$k] = $v['findpattern'];
                $data['replace'][$k] = $v['replacement'];
            }
        }
        $s = "<?php\r\n";
        $s .= '$_CACHE[\'badwords\'] = '.var_export($data, true).";\r\n";
        fwrite($fp, $s);
        fclose($fp);
        return API_RETURN_SUCCEED;
    }

    public static function updatehosts($get, $post)
    {
        if (!API_UPDATEHOSTS) {
            return API_RETURN_FORBIDDEN;
        }
        $cachefile = API_ROOT.'uc_client/data/cache/hosts.php';
        $fp = fopen($cachefile, 'w');
        $s = "<?php\r\n";
        $s .= '$_CACHE[\'hosts\'] = '.var_export($post, true).";\r\n";
        fwrite($fp, $s);
        fclose($fp);
        return API_RETURN_SUCCEED;
    }

    public static function updateapps($get, $post)
    {
        if (!API_UPDATEAPPS) {
            return API_RETURN_FORBIDDEN;
        }
        //note 写 app 缓存文件
        $cachefile = API_ROOT.'uc_client/data/cache/apps.php';
        $fp = fopen($cachefile, 'w');
        $s = "<?php\r\n";
        $s .= '$_CACHE[\'apps\'] = '.var_export($post, true).";\r\n";
        fwrite($fp, $s);
        fclose($fp);
        return API_RETURN_SUCCEED;
    }

    public static function updateclient($get, $post)
    {
        if (!API_UPDATECLIENT) {
            return API_RETURN_FORBIDDEN;
        }
        $cachefile = API_ROOT.'./uc_client/data/cache/settings.php';
        $fp = @fopen($cachefile, 'w');
        $s = "<?php\r\n";
        $s .= '$_CACHE[\'settings\'] = '.var_export($post, true).";\r\n";
        @fwrite($fp, $s);
        @fclose($fp);
        return API_RETURN_SUCCEED;
    }
    public static function updatesmsapi($get, $post)
    {
        if (!API_UPDATECLIENT) {
            return API_RETURN_FORBIDDEN;
        }
        $cachefile = API_ROOT.'./uc_client/data/cache/smsapi.php';
        $fp = @fopen($cachefile, 'w');
        $s = "<?php\r\n";
        $s .= '$_CACHE[\'smsapi\'] = '.var_export($post, true).";\r\n";
        @fwrite($fp, $s);
        @fclose($fp);
        return API_RETURN_SUCCEED;
    }
    public static function updatecredit($get, $post)
    {
        if (!API_UPDATECREDIT) {
            return API_RETURN_FORBIDDEN;
        }
        $credit = $get['credit'];
        $amount = $get['amount'];
        $uid = $get['uid'];
        return API_RETURN_SUCCEED;
    }

    public static function getcredit($get, $post)
    {
        if (!API_GETCREDIT) {
            return API_RETURN_FORBIDDEN;
        }
    }
    public static function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
    {
        $ckey_length = 4;
    
        $key = md5($key ? $key : UC_KEY);
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
    
        $cryptkey = $keya.md5($keya.$keyc);
        $key_length = strlen($cryptkey);
    
        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
        $string_length = strlen($string);
    
        $result = '';
        $box = range(0, 255);
    
        $rndkey = array();
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }
    
        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
    
        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
    
        if ($operation == 'DECODE') {
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc.str_replace('=', '', base64_encode($result));
        }
    }
    
    public static function stripslashes($string)
    {
        if (is_array($string)) {
            foreach ($string as $key => $val) {
                $string[$key] = self::stripslashes($val);
            }
        } else {
            $string = stripslashes($string);
        }
        return $string;
    }
    
    public static function scookie($var, $value, $life = 0)
    {
        setcookie($var, $value, $life ? $life : 0, '/', '', $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
    }
    
    public static function serialize($arr, $htmlon = 0)
    {
        if (!function_exists('xml_serialize')) {
            include API_ROOT.'uc_client/lib/xml.class.php';
        }
        return xml_serialize($arr, $htmlon);
    }
    
    public static function unserialize($arr, $htmlon = 0)
    {
        if (!function_exists('xml_serialize')) {
            include API_ROOT.'uc_client/lib/xml.class.php';
        }
        return xml_unserialize($arr, $htmlon);
    }
}
