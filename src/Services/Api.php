<?php namespace Binaryoung\Ucenter\Services;

use Binaryoung\Ucenter\Services\Help;

class Api implements \Binaryoung\Ucenter\Contracts\Api
{
    use Help;
    
    public static function test($get, $post)
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

    public static function getcreditsettings($get, $post)
    {
        if (!API_GETCREDIT) {
            return API_RETURN_FORBIDDEN;
        }
    }

    public static function updatecreditsettings($get, $post)
    {
        if (!API_GETCREDIT) {
            return API_RETURN_FORBIDDEN;
        }
    }
}