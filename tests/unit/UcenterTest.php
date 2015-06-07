<?php

use Mockery as m;

class UcenterTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected $config;

    protected $ucneter;

    protected $faker;

    protected $username;

    protected $password;

    protected $email;

    public function __construct(){

    }

    protected function _before()
    {
        $config = [
            'connect'    => 'mysql',
            'dbhost'     => 'localhost',
            'dbuser'     => 'root',
            'dbpw'       => '',
            'dbname'     => 'ucenter',
            'dbconnect'  => '0',
            'dbcharset'  => 'utf8',
            'dbtablepre' => '`ucenter`.uc_',
            'key'        => '8b01LtwuRJw2NmcjA77MjFLKPQ7XmpRjTMcosGI',
            'api'        => 'http://localhost/ucenter',
            'charset'    => 'utf-8',
            'ip'         => '127.0.0.1',
            'appid'      => '1',
            'ppp'        => '20',
        ];
        $this->config = m::mock('alias:Config');
        $this->config->shouldReceive('get')->with('ucenter')->andReturn($config);

        //$this->ucenter = m::mock('alias:Ucenter');
        $this->ucenter = new Binaryoung\Ucenter\Ucenter;

        $this->faker = Faker\Factory::create();
    }

    protected function _after()
    {
        m::close();
    }

    public function userRegister()
    {
        $this->username = $this->faker->userName;
        $this->password = $this->faker->state;//faker生成的密码含许多ucenter不支持的字符
        $this->email = $this->faker->email;
        $uid = $this->ucenter->uc_user_register($this->username, $this->password, $this->email);
        if ($uid > 0) {
            return $uid;
        } else {
            $this->userRegister();
        }
    }

    // user register
    public function testUserRegister()
    {
        //正常注册
        $uid = $this->userRegister();
        $this->assertEquals(1, $uid);
        $this->tester->seeInDatabase('uc_members', ['username' => $this->username, 'email' => $this->email]);

        //用户名不合法
        $return = $this->ucenter->uc_user_register('aa', $this->password, $this->faker->email);
        $this->assertEquals(-1, $return);

        //用户名已存在
        $return = $this->ucenter->uc_user_register($this->username, $this->password, $this->faker->email);
        $this->assertEquals(-3, $return);

        //Email 格式有误
        $return = $this->ucenter->uc_user_register($this->faker->userName, $this->password, $this->username);
        $this->assertEquals(-4, $return);

        //Email 已经被注册
        $return = $this->ucenter->uc_user_register('test', $this->password, $this->email);
        $this->assertEquals(-6, $return);

    }

    //user login
    public function testUserLogin()
    {

        $this->userRegister();

        //正确用户名密码
        $return = $this->ucenter->uc_user_login($this->username, $this->password);
        $result = ['1', $this->username, $this->password, $this->email, 0];
        $this->assertEquals($result, $return);

        //错误密码
        $return = $this->ucenter->uc_user_login($this->username, $this->faker->password);
        $this->assertEquals(-2, $return[0]);

        //错误用户名
        $return = $this->ucenter->uc_user_login($this->faker->userName, $this->password);
        $this->assertEquals(-1, $return[0]);
    }

    // get user
    public function testGetUser()
    {
        $this->userRegister();

        $result = [1, $this->username, $this->email];

        //用户名
        $return = $this->ucenter->uc_get_user($this->username);
        $this->assertEquals($result, $return);

        //id
        $return = $this->ucenter->uc_get_user(1, 1);
        $this->assertEquals($result, $return);

        //不存在用户名
        $return = $this->ucenter->uc_get_user($this->faker->userName);
        $this->assertEquals(0, $return);

        //不存在id
        $return = $this->ucenter->uc_get_user(2, 1);
        $this->assertEquals(0, $return);

    }

    //edit user
    public function testEditUser()
    {
        $this->userRegister();

        $username = $this->faker->userName;
        $password = $this->faker->password;
        $email = $this->faker->email;

        //正确修改
        $return = $this->ucenter->uc_user_edit($this->username, $this->password, $password, $email);
        $this->assertEquals(1, $return);
        $this->tester->seeInDatabase('uc_members', ['username' => $this->username, 'email' => $email]);

        //未作任何修改
        $return = $this->ucenter->uc_user_edit($this->username, $password, $password, $email);
        $this->assertEquals(0, $return);

        //旧密码不正确
        $return = $this->ucenter->uc_user_edit($this->username, $this->password, $password, $email);
        $this->assertEquals(-1, $return);

    }

    //delete user
    //似乎这个函数并不能删除用户，测试了用户名，id,都不行，只会返回并不在文档上的状态代码4。
    public function testDeleteUser()
    {
        $this->userRegister();

        $return = $this->ucenter->uc_user_delete(1);
        $this->assertEquals(4, $return);
        $this->tester->dontSeeInDatabase('uc_members', ['username' => $this->username, 'email' => $this->email]);

    }

    //check username
    public function testCheckUsername()
    {
        $this->userRegister();

        //不存在用户名
        $username = $this->faker->userName;
        $return = $this->ucenter->uc_user_checkname('test');
        $this->assertEquals(1, $return);

        //存在用户名
        $return = $this->ucenter->uc_user_checkname($this->username);
        $this->assertEquals(-3, $return);

        //非法用户名
        $return = $this->ucenter->uc_user_checkname('aa');
        $this->assertEquals(-1, $return);
    }

    //check email
    public function testCheckEmail()
    {
        $this->userRegister();

        //不存在邮箱
        $email = $this->faker->email;
        $return = $this->ucenter->uc_user_checkemail($email);
        $this->assertEquals(1, $return);

        //存在邮箱
        $return = $this->ucenter->uc_user_checkemail($this->email);
        $this->assertEquals(-6, $return);

        //非法邮箱
        $return = $this->ucenter->uc_user_checkemail($this->password);
        $this->assertEquals(-4, $return);
    }

}
