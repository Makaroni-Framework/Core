<?php 
namespace Makaroni\Core\Model\Traits;

use Makaroni\Core\Database\QueryBuilder;

trait HasQueryBuilder{

    public static function query()
    {
        return new QueryBuilder;
    }
}