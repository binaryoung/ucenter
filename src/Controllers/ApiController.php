<?php namespace Binaryoung\Ucenter\Controllers;

use App\Http\Controllers\Controller;
use Binaryoung\Ucenter\Contracts\Api;
use Request,Config;
use Binaryoung\Ucenter\Services\Help;

class ApiController extends Controller 
{
    use Help;
    
	public function __construct()
	{
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

		define('API_ROOT', __DIR__.'/../');
	}

	public function run(Api $api)
	{
        $code = Request::input('code');
        parse_str(self::authcode($code, 'DECODE', UC_KEY), $get);

        if (empty($get)) {
            return 'Invalid Request';
        } elseif (time() - $get['time'] > 3600) {
            return 'Authracation has expiried';
        }
        
        $action = $get['action'];
        
        $actionList = [
            'test',
            'deleteuser',
            'renameuser',
            'updatepw',
            'gettag',
            'synlogin',
            'synlogout',
            'updatebadwords',
            'updatehosts',
            'updateapps',
            'updateclient',
            'updatecredit',
            'getcreditsettings',
            'updatecreditsettings',
            'getcredit',
        ];
        
        if (in_array($action, $actionList) && method_exists($api, $action)) {
        	$post = self::unserialize(file_get_contents('php://input'));
            return $api::$action($get, $post);
        } else {
            return API_RETURN_FAILED;
        }
	}
}