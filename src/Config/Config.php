<?php

namespace Makaroni\Core\Config;

class Config
{

    public function __construct(private array $config)
    {
    }

    public function get(string|int $key)
    {
        $keys = explode('.', $key);

        $config = $this->config;

        foreach ($keys as $key) {
            if (!array_key_exists($key, $config)) {
                throw new \OutOfBoundsException("The {$key} Key is not valid!");
            }

            $config = $config[$key];
        }
        return $config;
    }
}
