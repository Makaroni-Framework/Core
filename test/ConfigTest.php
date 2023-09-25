<?php

namespace Makaroni\Core\Test;

use Makaroni\Core\Config\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{

    /** @test */
    public function can_get_config_test()
    {
        $options = [
            'database' => [
                'host' => 'localhost',
            ],
            'server' => [
                'port' => 8080,
            ],
        ];

        $config = new Config($options);

        $this->assertSame(['host' => 'localhost'], $config->get('database'));
        $this->assertSame(8080, $config->get('server.port'));

        $this->expectException(\OutOfBoundsException::class);
        $this->assertNull($config->get('foo'));
    }
}
