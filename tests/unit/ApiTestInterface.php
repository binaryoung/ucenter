<?php

use Binaryoung\Ucenter\Services\Help;

class TestApiInterface implements \Binaryoung\Ucenter\Contracts\Api
{
    use Help;

    public $get = [];

    public $post = [];
    
    public  function test()
    {
        return API_RETURN_SUCCEED;
    }
    
    public  function deleteuser()
    {
        $uids = $this->get['ids'];
       
        /*
        同步删除用户代码
         */
        
        return API_RETURN_SUCCEED;
    }
    
    public  function renameuser()
    {
        $uid = $this->get['uid'];
        $oldusername = $this->get['oldusername'];
        $newusername = $this->get['newusername'];
        
        /*
        同步重命名用户代码
        */
        
        return API_RETURN_SUCCEED;
    }

    public  function updatepw()
    {

        $username = $this->get['username'];
        $password = $this->get['password'];

        /*
        同步更新用户密码
         */
        
        return API_RETURN_SUCCEED;
    }

    public  function gettag()
    {
        $name = $this->get['id'];
        
        $threadlist = [];
        $threadlist[] = [
            'name' => 'updatehosts',
            'uid' => '1',
            'username' => 'admin',
            'url' => 'http://www.yourwebsite.com/thread.php?id=1',
            'image' => 'http://www.yourwebsite.com/threadimage.php?id=1',
        ];
        $return = ['tag', $threadlist];
        return $this->serialize($return, 1);
    }

    public  function synlogin()
    {
        $uid = $this->get['uid'];
        $username = $this->get['username'];

        /*
        
        同步登陆代码
        
        */
        return API_RETURN_SUCCEED;
    }

    public  function synlogout()
    {

        /*
        
        同步注销代码
        
        */
        return API_RETURN_SUCCEED;
    }


    public  function updatebadwords()
    {

        $cachefile = API_ROOT.'uc_client/data/cache/badwords.php';
        $fp = fopen($cachefile, 'w');
        $data = array();
        if (is_array($this->post)) {
            foreach ($this->post as $k => $v) {
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

    public  function updatehosts()
    {
        $fakeData = [
            'name' => 'updatehosts',
            'uid' => '1',
            'username' => 'admin',
            'url' => 'http://www.yourwebsite.com/thread.php?id=1',
            'image' => 'http://www.yourwebsite.com/threadimage.php?id=1',
        ];
        $cachefile = API_ROOT.'uc_client/data/cache/hosts.php';
        $fp = fopen($cachefile, 'w');
        $s = "<?php\r\n";
        $s .= '$_CACHE[\'hosts\'] = '.var_export($fakeData, true).";\r\n";
        fwrite($fp, $s);
        fclose($fp);
        
        return API_RETURN_SUCCEED;
    }

    public  function updateapps()
    {

        $cachefile = API_ROOT.'uc_client/data/cache/apps.php';
        $fp = fopen($cachefile, 'w');
        $s = "<?php\r\n";
        $s .= '$_CACHE[\'apps\'] = '.var_export($this->post, true).";\r\n";
        fwrite($fp, $s);
        fclose($fp);
        
        return API_RETURN_SUCCEED;
    }

    public  function updateclient()
    {

        $cachefile = API_ROOT.'uc_client/data/cache/settings.php';
        $fp = @fopen($cachefile, 'w');
        $s = "<?php\r\n";
        $s .= '$_CACHE[\'settings\'] = '.var_export($this->post, true).";\r\n";
        @fwrite($fp, $s);
        @fclose($fp);
        
        return API_RETURN_SUCCEED;
    }
    
    /*public  function updatesmsapi()
    {

        $cachefile = API_ROOT.'./uc_client/data/cache/smsapi.php';
        $fp = @fopen($cachefile, 'w');
        $s = "<?php\r\n";
        $s .= '$_CACHE[\'smsapi\'] = '.var_export($this->post, true).";\r\n";
        @fwrite($fp, $s);
        @fclose($fp);
        
        return API_RETURN_SUCCEED;
    }*/
   
    public  function updatecredit()
    {

        $credit = $this->get['credit'];
        $amount = $this->get['amount'];
        $uid = $this->get['uid'];
        
        return API_RETURN_SUCCEED;
    }

    public  function getcreditsettings()
    {

        $credits = [];
        return $this->serialize($credits);
    }

    public  function updatecreditsettings()
    {

        $credit = $this->get['credit'];
        return API_RETURN_SUCCEED;
    }

    public  function getcredit()
    {
        $uid = $this->get['uid'];
        $credit = $this->get['credit'];

        return API_RETURN_SUCCEED;
    }

    public function __call($function, $arguments)
    {
        if (method_exists($this, $function)) {
            return call_user_func_array([$this, $function], $arguments);
        } else {
            throw new Exception("function not exists");           
        }
    }
}