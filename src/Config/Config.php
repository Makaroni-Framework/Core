<?php

namespace Makaroni\Core\Config;

class Config
{

    public function __construct(private  ? array $config = null)
    {
        $this->config = $config;
    }

    public function get(string | int $key)
    {
        $keys = explode('.', $key);

        $config = $this->config;

        if (!is_null($config)) {

            foreach ($keys as $key) {
                if (!array_key_exists($key, $config)) {
                    throw new \Exception("The {$key} Key not defined!");
                }

                $config = $config[$key];
            }
            return $config;
        }
    }
}