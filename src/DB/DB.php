<?php

namespace App\DB;

use mysqli;

class DB
{
    private static $connection;

    public static function init(array $configs)
    {
        $connection = new mysqli($configs['hostName'], $configs['userName'], $configs['password'], $configs['dataBase']);
        if ($connection->connect_errno){
            die("Failed to connect to MySql " . '(' . $connection->connect_errno . $connection->connect_error . ')');
        }

        self::$connection = $connection;
    }

    private static function runQuery(string $query)
    {
        return self::$connection->query($query);
    }

    public static function select(string $query): array
    {
        $arr = [];
        $result = self::$connection->query($query);
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            $arr[] = $row;
        }
        return $arr;
    }

    public static function selectOne(string $query)
    {
        return self::runQuery($query . " LIMIT 1")->fetch_object();
    }

    public static function affectingStatement(string $query)
    {
        return self::runQuery($query)->num_rows;
    }
}