<?php
namespace LazarusPhp\Foundation\Facades;

use Exception;
use LazarusPhp\Database\Store;
use LazarusPhp\QueryBuilder\QueryBuilder;
use PDOStatement;

class DB
{
    private static ?Store $store = null;

    private static function save(string $sql, array $params = [], string $type = "statement")
    {
        if (!self::$store) {
            self::$store = new Store();
        }

        $result = self::$store->parse($sql, $params, $type);

        return match ($type) {
            "insert", "update", "delete" => $result->rowCount(),
            default => $result,
        };
    }

    public static function table(string $table, ?string $model = null)
    {
        $builder = new QueryBuilder($table);
        $builder->setModel($model ?: ucfirst($table));
        return $builder;
    }

    public static function insert(string $sql, array $params = []):int
    {
        return self::save($sql, $params, "insert");
    }

    public static function update(string $sql, array $params = []):int
    {
        return self::save($sql, $params, "update");
    }

    public static function delete(string $sql, array $params = []):int
    {
        return self::save($sql, $params, "delete");
    }

    public static function statement(string $sql, array $params = [], ?string $type = null)
    {
        return self::save($sql, $params, $type ?? "statement");
    }
}