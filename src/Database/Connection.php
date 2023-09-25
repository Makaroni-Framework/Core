<?php

namespace Makaroni\Core\Database;

class Connection
{

    private $options;

    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    public function connect()
    {
        try {
            $connection = new \PDO("mysql:host=" . $this->options['host'] . ";dbname=" . $this->options['name'] . ";charset=utf8", $this->options['user_name'], $this->options['password']);
            $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $connection;
        } catch (\PDOException $exception) {
            die($exception->getMessage());
        }
    }
}
