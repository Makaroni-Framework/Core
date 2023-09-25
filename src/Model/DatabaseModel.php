<?php

namespace Makaroni\Core\Model;

use Makaroni\Core\Database\Builder\QueryBuilder;
use ReflectionClass;

class DatabaseModel
{
    protected string $table = '';

    public function query(): QueryBuilder
    {
        return new QueryBuilder;
    }

    public static function __callStatic($name, $arguments)
    {
        return (new static)->__call($name, $arguments);
    }

    public function __call($name, $arguments)
    {
        $this->resolveTableName($this->table);
        return $this->query()->table($this->table)->$name(...$arguments);
    }

    private function resolveTableName($table)
    {
        if (empty($table)) {
            $class = (new ReflectionClass(get_called_class()))->getShortName();
            $table = strtolower($class) . 's';
            $this->table = $table;
        }
    }
}
