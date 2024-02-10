<?php

namespace Imi\Test\HttpServer\Tests;

use Imi\Util\Http\Consts\StatusCode;
use Yurun\Util\HttpRequest;

/**
 * @testdox HttpResponse
 */
class ResponseTest extends BaseTest
{
    /**
     * Middleware.
     *
     * @return void
     */
    public function testMiddleware()
    {
        $http = new HttpRequest();
        $response = $http->get($this->host . 'middleware');
        // global middleware
        $this->assertEquals('imiphp.com', $response->getHeaderLine('X-Powered-By'));
        // scoped middleware
        $this->assertEquals('1', $response->getHeaderLine('imi-middleware-1'));
        $this->assertEquals('2', $response->getHeaderLine('imi-middleware-2'));
        $this->assertEquals('3', $response->getHeaderLine('imi-middleware-3'));
        $this->assertEquals('4', $response->getHeaderLine('imi-middleware-4'));
    }

    /**
     * Options Middleware.
     *
     * @return void
     */
    public function testOptionsMiddleware()
    {
        $http = new HttpRequest();
        $response = $http->send($this->host, '', 'OPTIONS');
        // OPTIONS middleware
        $this->assertEquals('http://127.0.0.1', $response->getHeaderLine('Access-Control-Allow-Origin'));
        $this->assertEquals('Authorization, Content-Type, Accept, Origin, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With, X-Id, X-Token, Cookie', $response->getHeaderLine('Access-Control-Allow-Headers'));
        $this->assertEquals('Authorization, Content-Type, Accept, Origin, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With, X-Id, X-Token, Cookie', $response->getHeaderLine('Access-Control-Expose-Headers'));
        $this->assertEquals('GET, POST, PATCH, PUT, DELETE', $response->getHeaderLine('Access-Control-Allow-Methods'));
        $this->assertEquals('true', $response->getHeaderLine('Access-Control-Allow-Credentials'));
    }

    /**
     * Cookie.
     *
     * @return void
     */
    public function testCookie()
    {
        $http = new HttpRequest();
        $http->get($this->host . 'cookie');
        $cookieManager = $http->getHandler()->getCookieManager();

        $this->assertNotNull($a = $cookieManager->getCookieItem('a'));
        $this->assertEquals('1', $a->value);

        $this->assertNotNull($b = $cookieManager->getCookieItem('b'));
        $this->assertEquals('2', $b->value);

        $this->assertNotNull($c = $cookieManager->getCookieItem('c'));
        $this->assertEquals('3', $c->value);

        $this->assertNotNull($d = $cookieManager->getCookieItem('d', '', '/a'));
        $this->assertEquals('4', $d->value);

        $this->assertNotNull($e = $cookieManager->getCookieItem('e', 'localhost', '/'));
        $this->assertEquals('5', $e->value);

        $this->assertNotNull($f = $cookieManager->getCookieItem('f'));
        $this->assertEquals('6', $f->value);
        $this->assertTrue($f->secure);
        $this->assertNotTrue($f->httpOnly);

        $this->assertNotNull($g = $cookieManager->getCookieItem('g'));
        $this->assertEquals('7', $g->value);
        $this->assertTrue($g->secure);
        $this->assertTrue($g->httpOnly);
    }

    /**
     * Headers.
     *
     * @return void
     */
    public function testHeaders()
    {
        $http = new HttpRequest();
        $response = $http->get($this->host . 'headers');

        $this->assertEquals('1,11', $response->getHeaderLine('a'));
        $this->assertEquals('2', $response->getHeaderLine('b'));
    }

    /**
     * Redirect.
     *
     * @return void
     */
    public function testRedirect()
    {
        $http = new HttpRequest();
        $http->followLocation = false;
        $response = $http->get($this->host . 'redirect');
        $this->assertEquals(StatusCode::MOVED_PERMANENTLY, $response->getStatusCode());
        $this->assertEquals('/', $response->getHeaderLine('location'));
    }

    /**
     * Download.
     *
     * @return void
     */
    public function testDownload()
    {
        $http = new HttpRequest();
        $response = $http->get($this->host . 'download');
        $this->assertEquals(file_get_contents(\dirname(__DIR__) . '/ApiServer/Controller/IndexController.php'), $response->body());
    }
}
