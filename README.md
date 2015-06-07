## Ucenter Service Provider For Laravel5

Ucenter Service Provider For Laravel5

[![Latest Stable Version](https://poser.pugx.org/binaryoung/ucenter/v/stable)](https://packagist.org/packages/binaryoung/ucenter) [![Total Downloads](https://poser.pugx.org/binaryoung/ucenter/downloads)](https://packagist.org/packages/binaryoung/ucenter) [![Latest Unstable Version](https://poser.pugx.org/binaryoung/ucenter/v/unstable)](https://packagist.org/packages/binaryoung/ucenter) [![License](https://poser.pugx.org/binaryoung/ucenter/license)](https://packagist.org/packages/binaryoung/ucenter)

[![Build Status](https://travis-ci.org/binaryoung/ucenter.svg?branch=master)](https://travis-ci.org/binaryoung/ucenter)

### 安装

- [Packagist](https://packagist.org/packages/binaryoung/ucenter)
- [GitHub](https://github.com/binaryoung/ucenter)

只要在你的 `composer.json` 文件require中加入下面内容，就能获得最新版.

~~~
"binaryoung/ucenter": "dev-master"
~~~

然后需要运行 "composer update" 来更新你的项目

安装完后，在 `app/config/app.php` 文件中找到 `providers` 键，

~~~
'providers' => array(

    'Binaryoung\Ucenter\UcenterServiceProvider'

)
~~~

找到 `aliases` 键，

~~~
'aliases' => array(

    'Ucenter' => 'Binaryoung\Ucenter\Facades\Ucenter'

)
~~~

## 配置
运行以下命令发布配置文件
~~~
php artisan vendor:publish
~~~
ucenter配置项
~~~
//config.php
'url'		=> '', // 网站UCenter接受数据地址
'api'		=> 'http://localhost/ucenter', // UCenter 的 URL 地址, 在调用头像时依赖此常量
'connect'	=> 'mysql', // 连接 UCenter 的方式: mysql/NULL, 默认为空时为 fscoketopen()
'dbhost'	=> 'localhost', // UCenter 数据库主机
'dbuser'	=> 'root', // UCenter 数据库用户名
'dbpw'		=> 'root', // UCenter 数据库密码
'dbname'	=> 'ucenter', // UCenter 数据库名称
'dbcharset'	=> 'utf8',// UCenter 数据库字符集
'dbtablepre'=> '`uc`.uc_', // UCenter 数据库表前缀
'key'		=> '666cLXgFsrl6TcvDflhrvdcziY8SnhP1eexl1eQ', // 与 UCenter 的通信密钥, 要与 UCenter 保持一致
'charset'	=> 'utf-8', // UCenter 的字符集
'ip'		=> '127.0.0.1', // UCenter 的 IP, 当 UC_CONNECT 为非 mysql 方式时, 并且当前应用服务器解析域名有问题时, 请设置此值
'appid'		=> 1, //当前应用的 ID
'ppp'		=> 20, //当前应用的 ID
~~~

## 使用
例如：获取用户名为test的信息
~~~
$result = Ucenter::uc_get_user('test');
var_dump($result);
~~~


## 联系我
有问题，请提交issue
