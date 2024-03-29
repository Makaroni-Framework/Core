<?php

namespace Makaroni\Core\Database\Builder;

use Makaroni\Core\App;

class QueryBuilder
{


    /**
     * Table name
     *
     * @var string
     */
    private static string $table;


    /**
     * Query string
     *
     * @var string
     */
    private static string $query = '';


    /**
     * Join string
     *
     * @var string
     */
    private static string $join = '';


    /**
     * AND operator
     *
     * @var string
     */
    private static string $and = '';


    /**
     * OR operator
     *
     * @var string
     */
    private static string $or = '';


    /**
     * Select statement
     *
     * @var string
     */
    private static string $select;


    /**
     * orderBy statement
     *
     * @var string
     */
    private static string $orderBy = '';


    /**
     * groupBy statement
     *
     * @var string
     */
    private static string $groupBy = '';


    /**
     * Limit clause
     *
     * @var string
     */
    private static string $limit = '';


    /**
     * Where condition
     *
     * @var string
     */
    private static string $where = '';


    /**
     * Between or notBetween operator
     *
     * @var string
     */
    private static string $betweenOrNotBetween = '';


    /**
     * In or notIn operator
     *
     * @var string
     */
    private static string $inOrNotIn = '';


    /**
     * Min variable
     *
     * @var string
     */
    private static string $min;


    /**
     * Max variable
     *
     * @var string
     */
    private static string $max;


    /**
     * Count variable
     *
     * @var string
     */
    private static string $count;


    /**
     * Get query string
     *
     * @return string
     */
    public static function getQuery(): string
    {
        self::$query = trim(implode('', [self::$query, self::$join, self::$where, self::$and, self::$or, self::$betweenOrNotBetween, self::$inOrNotIn, self::$groupBy, self::$orderBy, self::$limit]));
        self::clearVariables();
        return self::$query;
    }


    /**
     * Set the table name
     *
     * @param string $table
     * 
     * @return self
     */
    public static function table(string $table): self
    {
        self::$table = $table;
        return new QueryBuilder;
    }


    /**
     * Write your custom query
     *
     * @param string $query
     * 
     * @return self
     */
    public static function setQuery(string $query): self
    {
        self::$query = $query;
        return new QueryBuilder;
    }


    /**
     * Build select statement
     *
     * @param $columns
     * 
     * @return self
     */
    public static function select(...$columns): self
    {
        self::$select = implode(',', $columns);
        $query = " SELECT %s FROM `%s` ";
        self::$query = sprintf($query, self::$select, self::$table);
        return new QueryBuilder;
    }


    /**
     * Build insert statement
     *
     * @param array $columns
     * 
     * @return self
     */
    public static function insert(array $columns): self
    {
        $column = array_keys($columns);
        $value = array_values($columns);
        $query = " INSERT INTO `%s` (`%s`) VALUES ('%s') ";
        self::$query = sprintf($query, self::$table, implode("`,`", $column), implode("','", $value));
        return new QueryBuilder;
    }


    /**
     * Build update statement
     *
     * @param array $updates
     * 
     * @return self
     */
    public static function update(array $updates): self
    {
        $update = '';
        foreach ($updates as $key => $value) {
            $update .= "`$key` = '$value',";
        }
        $query = " UPDATE `%s` SET %s ";
        self::$query = sprintf($query, self::$table, rtrim($update, ','));
        return new QueryBuilder;
    }


    /**
     * Build delete statement
     *
     * @return self
     */
    public static function delete(): self
    {
        $query = " DELETE FROM `%s` ";
        self::$query = sprintf($query, self::$table);
        return new QueryBuilder;
    }


    /**
     * Build where statement
     *
     * @param array $condition
     * 
     * @return self
     */
    public static function where(array $condition): self
    {
        $column = $condition[0];
        $operator = $condition[1];
        $value = $condition[2];

        $query = " WHERE %s %s '%s' ";
        self::$where = sprintf($query, $column, $operator, $value);
        return new QueryBuilder;
    }


    /**
     * Minimum function 
     *
     * @param string $column
     * @param string $AS
     * 
     * @return string self::$min
     */
    public static function min(string $column, string $AS): string
    {
        $query = " MIN(%s) AS %s ";
        self::$min = sprintf($query, $column, $AS);
        return self::$min;
    }


    /**
     * Maximum function 
     *
     * @param string $column
     * @param string $AS
     * 
     * @return string self::$max
     */
    public static function max(string $column, string $AS): string
    {
        $query = " MAX(%s) AS %s ";
        self::$max = sprintf($query, $column, $AS);
        return self::$max;
    }


    /**
     * Count function 
     *
     * @param string $column
     * @param string $AS
     * 
     * @return string self::$count
     */
    public static function count(string $column, string $AS): string
    {
        $query = " COUNT(%s) AS %s ";
        self::$count = sprintf($query, $column, $AS);
        return self::$count;
    }


    /**
     * Random function 
     *
     * @param int $count
     * 
     * @return self 
     */
    public static function random(int $count = 0): self
    {
        $query = " SELECT RAND(%d) ";
        self::$query = sprintf($query, $count);
        return new QueryBuilder;
    }


    /**
     * Build join statement
     *
     * @param string $table
     * @param array $conditions
     * @param string $type
     * 
     * @return self
     */
    public static function join(string $table, array $condition, string $type = "INNER"): self
    {
        $query = " %s JOIN `%s` ON %s ";
        self::$join .= sprintf($query, $type, $table, implode(" ", $condition));
        return new QueryBuilder;
    }


    /**
     * Build and operator
     *
     * @param array $conditions
     * 
     * @return self
     */
    public static function and(array $condition): self
    {
        $column = $condition[0];
        $operator = $condition[1];
        $value = $condition[2];

        $query = " AND %s %s '%s' ";
        self::$and .= sprintf($query, $column, $operator, $value);
        return new QueryBuilder;
    }


    /**
     * Build or operator
     *
     * @param array $conditions
     * 
     * @return self
     */
    public static function or(array $condition): self
    {
        $column = $condition[0];
        $operator = $condition[1];
        $value = $condition[2];

        $query = " OR %s %s '%s' ";
        self::$or .= sprintf($query, $column, $operator, $value);
        return new QueryBuilder;
    }


    /**
     * Build limit clause
     *
     * @param integer $count
     * @param integer $offset
     * 
     * @return self
     */
    public static function limit(int $count, int $offset = null): self
    {
        $query = " LIMIT %d ";
        self::$limit = sprintf($query, $count);
        if ($offset) {
            $query .= " OFFSET %d";
            self::$limit = sprintf($query, $count, $offset);
        }
        return new QueryBuilder;
    }


    /**
     * Build orderBy statement
     *
     * @param array $column
     * @param string $sort
     * 
     * @return self
     */
    public static function orderBy(array $column, string $sort = 'ASC'): self
    {
        $query = " ORDER BY %s %s ";
        self::$orderBy = sprintf($query, implode(",", $column), $sort);
        return new QueryBuilder;
    }


    /**
     * Build groupBy statement
     *
     * @param array $columns
     * 
     * @return self
     */
    public static function groupBy(array $columns): self
    {
        $query = " GROUP BY %s ";
        self::$groupBy = sprintf($query, implode(",", $columns));
        return new QueryBuilder;
    }


    /**
     * Fetch all rows
     *
     * @return self
     */
    public static function all(): self
    {
        $query = " SELECT * FROM `%s` ";
        self::$query = sprintf($query, self::$table);
        return new QueryBuilder;
    }


    /**
     * Find row with id
     *
     * @param integer $id
     * 
     * @return self
     */
    public static function find(int $id): self
    {
        $query = " SELECT * FROM `%s` WHERE `id` = %d ";
        self::$query = sprintf($query, self::$table, $id);
        return new QueryBuilder;
    }


    /**
     * Build between or notBetween operator
     *
     * @param string $column 
     * @param $firstValue
     * @param $secondValue
     * @param boolean $notBetween
     * 
     * @return self
     */
    public static function betweenOrNotBetween(string $column, $firstValue, $secondValue, bool $notBetween = false): self
    {
        $query = " WHERE %s %s BETWEEN %s AND %s ";
        self::$betweenOrNotBetween = sprintf($query, $column, '', $firstValue, $secondValue);
        if ($notBetween) {
            self::$betweenOrNotBetween = sprintf($query, $column, 'NOT', $firstValue, $secondValue);
        }
        return new QueryBuilder;
    }


    /**
     * Build in or notIn operator
     *
     * @param string $column 
     * @param array $values
     * @param boolean $notIn
     * 
     * @return self
     */
    public static function inOrNotIn(string $column, array $value, bool $notIn = false): self
    {
        $query = " WHERE %s %s IN (%s) ";
        self::$inOrNotIn = sprintf($query, $column, '', implode(",", $value));
        if ($notIn) {
            self::$inOrNotIn = sprintf($query, $column, 'NOT', implode(",", $value));
        }
        return new QueryBuilder;
    }

    /**
     * Run the query
     *
     * @return array
     */
    public static function run(): array
    {
        $connection = App::getInstance()->get('connection');

        $statement = $connection->prepare(self::getQuery());
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }


    /**
     * Clear static variables
     *
     * @return void
     */
    private static function clearVariables(): void
    {
        self::$join = self::$where = self::$and = self::$or = self::$orderBy = self::$groupBy = self::$betweenOrNotBetween = self::$inOrNotIn = self::$limit = self::$max = self::$min = self::$count = '';
    }


    static function __callStatic($name, $arguments): static
    {
        return (new static)->$name(...$arguments);
    }
}
