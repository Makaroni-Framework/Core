<?php

namespace Makaroni\Core\Test;

use Makaroni\Core\Request\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{

    /** @test */
    public function can_get_all_or_one_request_input_test()
    {

        $_REQUEST = [
            'title' => 'foo',
        ];

        $request = new Request();

        $this->assertSame(['title' => 'foo'], $request->all());
        $this->assertSame('foo', $request->input('title'));
        $this->assertNull($request->input('body'));
    }
}
