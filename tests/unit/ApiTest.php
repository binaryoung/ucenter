<?php

use Mockery as m;
use Binaryoung\Ucenter\Services\Help;

class ApiTest extends \Codeception\TestCase\Test
{
    use Help;

    /**
     * @var \UnitTester
     */
    protected $tester;

    protected $api;

    protected $request;

    protected $config;

    protected $apiController;

    public function __construct()
    {

    }

    protected function _before()
    {
        $controller = m::mock('App\Http\Controllers\Controller');
        
        $this->request = m::mock('alias:Request');
        
        $this->config = m::mock('alias:Config');
        $this->config->shouldReceive('get')->with('ucenter.key')->andReturn('8b01LtwuRJw2NmcjA77MjFLKPQ7XmpRjTMcosGI');
        
        $this->apiController = new Binaryoung\Ucenter\Controllers\ApiController;
        $this->api = new TestApiInterface;

    }

    protected function _after()
    {
        m::close();
    }

    public function encode($action, array $arguments, $key = null)
    {
        $arguments['time'] = time();
        $arguments['action'] = $action;
        return self::authcode(http_build_query($arguments), 'ENCODE', $key);
    }

    // test
    public function testTest()
    {
        $action = 'test';
        $arguments = [];
        
        $code = self::encode($action, $arguments);
        $this->request->shouldReceive('input')->with('code')->times(1)->andReturn($code);
        
        $response = $this->apiController->run($this->api);
        
        $this->assertEquals(1, $response);
        $this->assertEquals($action, $this->api->get['action']);
    }

    // delete user
    public function testDeleteUser()
    {
        $action = 'deleteuser';
        $arguments = ['ids' => '1,2'];
        
        $code = self::encode($action, $arguments);
        $this->request->shouldReceive('input')->with('code')->times(1)->andReturn($code);
        
        $response = $this->apiController->run($this->api);
        
        $this->assertEquals(1, $response);
        $this->assertEquals($action, $this->api->get['action']);
        $this->assertEquals('1,2', $this->api->get['ids']);
    }

    // get tag
    public function testGetTag()
    {
        $action = 'gettag';
        $arguments = ['id' => 1];
        
        $code = self::encode($action, $arguments);
        $this->request->shouldReceive('input')->with('code')->times(1)->andReturn($code);

        //$api = m::mock('stdClass, Binaryoung\Ucenter\Contracts\Api')->shouldReceive('gettag')->times(1)->andReturn(self::serialize(['action' => $action], 1));

        $response = $this->apiController->run($this->api);

        $threadlist = [];
        $threadlist[] = [
            'name' => 'updatehosts',
            'uid' => '1',
            'username' => 'admin',
            'url' => 'http://www.yourwebsite.com/thread.php?id=1',
            'image' => 'http://www.yourwebsite.com/threadimage.php?id=1',
        ];
        $return = ['tag', $threadlist];
        
        $this->assertEquals($action, $this->api->get['action']);
        $this->assertEquals(self::serialize($return, 1), $response);
    }

    //update hosts
    public function testUpdateHosts()
    {
        $action = 'updatehosts';
        $arguments = [];
        
        $code = self::encode($action, $arguments);
        $this->request->shouldReceive('input')->with('code')->times(1)->andReturn($code);

        $fakeData = [
            'name' => 'updatehosts',
            'uid' => '1',
            'username' => 'admin',
            'url' => 'http://www.yourwebsite.com/thread.php?id=1',
            'image' => 'http://www.yourwebsite.com/threadimage.php?id=1',
        ];
        
        $response = $this->apiController->run($this->api);
        
        $this->assertEquals(1, $response);
        $this->assertEquals($action, $this->api->get['action']);

        require API_ROOT.'uc_client/data/cache/hosts.php';
        $this->assertEquals($fakeData, $_CACHE['hosts']);
    }

}