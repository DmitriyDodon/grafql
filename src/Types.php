<?php

namespace App;

use App\Type\QueryType;
use App\Type\UserType;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Type\Definition\Type;

class Types
{
    private static $query;
    private static $user;

    public static function query(): QueryType
    {
        return self::$query ?: (self::$query = new QueryType());
    }

    public static function string(): ScalarType
    {
        return Type::string();
    }

    public static function int(): ScalarType
    {
        return Type::int();
    }

    public static function user(): UserType
    {
        return self::$user ?: (self::$user = new UserType());
    }

    public static function listOf(Type $type): ListOfType
    {
        return Type::listOf($type);
    }
}