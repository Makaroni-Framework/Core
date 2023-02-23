<?php

namespace Makaroni\Core\Test;

use Makaroni\Core\Route\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{

    /** @test */
    public function can_get_all_or_one_request_input_test()
    {

        $router = $this->createMock(Router::class);

        $router->add('/', ['_controller' => 'foo', '_method' => 'bar'], 'root-test');
        $router->add('/post/{slug}', ['_controller' => 'foo', '_method' => 'bar'], 'post-slug-test');
        $router->add('/posts', ['_controller' => 'foo', '_method' => 'bar'], 'post-slug-test');

        $this->assertNotNull($router->find('/'));
        $this->assertNotNull($router->find('/posts'));
        $this->assertEmpty($router->find('/post/test')); // because `post/{slug}` and `posts` route are same name

    }
}
