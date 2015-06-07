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
            'dbpw'       => 'root',
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

    // user register
    public function testUserRegister()
    {
        $this->username = $this->faker->userName;
        $this->password = $this->faker->password;
        $this->email = $this->faker->email;
        $uid = $this->ucenter->uc_user_register($this->username, $this->password, $this->email);

        $this->assertEquals(1, $uid);
        $this->tester->seeInDatabase('uc_members', ['username' => $this->username, 'email' => $this->email]);
    }

}