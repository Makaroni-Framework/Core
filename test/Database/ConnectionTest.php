<?php

namespace Makaroni\Core\Test;

use Makaroni\Core\Database\Connection;
use PHPUnit\Framework\TestCase;

class ConnectionTest extends TestCase
{

    /** @test */
    public function connection_singleton_test()
    {

        $conn1 = Connection::getInstance();
        $conn2 = Connection::getInstance();

        $this->assertSame($conn1, $conn2);
    }
}
