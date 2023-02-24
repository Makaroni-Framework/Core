<?php
namespace Makaroni\Core\Test;

use Makaroni\Core\Config\Config;
use PHPUnit\Framework\TestCase;

class ConnectionTest extends TestCase
{

    /** @test */
    public function can_get_config_test()
    {
        $config = [
            'database' => [
                'host' => 'localhost',
            ],
            'server' => [
                'port' => 8080,
            ],
        ];

        $this->assertSame(['host' => 'localhost'], (new Config($config))->get('database'));
        $this->assertSame(8080, (new Config($config))->get('server.port'));

        $this->assertNull((new Config())->get('database')); //  because config array not defined

        $this->assertNull((new Config())->get('lang'));
    }
}
