<?php

namespace Makaroni\Core\Model;

use Makaroni\Core\Database\QueryBuilder;

class DatabaseModel
{
    protected static $table = '';

    public static function query(): QueryBuilder
    {
        return new QueryBuilder;
    }

    public static function __callStatic($name, $arguments)
    {
        return isset(static::$table)
        ? (new static )->query()->table(static::$table)->$name(...$arguments)
        : (new static )->query()->$name(...$arguments);
    }
}
