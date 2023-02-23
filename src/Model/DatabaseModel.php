<?php

namespace Makaroni\Core\Model;

use Makaroni\Core\Model\Traits\HasQueryBuilder;

class DatabaseModel
{
    use HasQueryBuilder;

    public static function __callStatic($name, $arguments)
    {
        return isset(static::$table)
        ? (new static )->query()->table(static::$table)->$name(...$arguments)
        : (new static )->query()->$name(...$arguments);
    }
}
