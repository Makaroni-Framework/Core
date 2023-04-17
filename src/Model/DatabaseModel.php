<?php

namespace Makaroni\Core\Model;

use Makaroni\Core\Database\Builder\QueryBuilder;
use ReflectionClass;

class DatabaseModel
{
    protected static $table = '';

    public static function query(): QueryBuilder
    {
        return new QueryBuilder;
    }

    public static function __callStatic($name, $arguments)
    {
        static::resolveTableName(static::$table);
        return (new static)->query()->table(static::$table)->$name(...$arguments);
    }

    private static function resolveTableName($table)
    {
        if (empty($table)) {
            $class = (new ReflectionClass(get_called_class()))->getShortName();
            $table = strtolower($class) . 's';
            static::$table = $table;
        }
    }
}
