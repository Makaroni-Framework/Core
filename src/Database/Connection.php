<?php
namespace Makaroni\Core\Database;

class Connection
{

    private static $connection;

    private $options;

    private function __construct()
    {
    }

    public static function getInstance(): object
    {
        if (self::$connection == null) {
            self::$connection = new Connection;
        }
        return self::$connection;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    public function connect()
    {
        try {
            static::$connection = new \PDO("mysql:host=" . $this->options['host'] . ";dbname=" . $this->options['name'] . ";charset=utf8", $this->options['user_name'], $this->options['password']);
            static::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return static::$connection;
        } catch (\PDOException$exception) {
            die($exception->getMessage());
        }
    }
}