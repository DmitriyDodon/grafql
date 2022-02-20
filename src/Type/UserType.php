<?php

namespace App\Type;

use App\DB\DB;
use App\Types;
use GraphQL\Type\Definition\ObjectType;

class UserType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => function () {
                return [
                    'id' => [
                        'type' => ObjectType::string(),
                        'description' => "Возвращает id пользователя."
                    ],
                    'name' => [
                        'type' => ObjectType::string(),
                        'description' => 'Возвращает имя пользователя.',
                    ],
                    'email' => [
                        'type' => ObjectType::string(),
                        'description' => 'Возвразает email пользователя.'
                    ],
                    'friends' => [
                        'type' => Types::listOf(Types::user()),
                        'description' => 'Возвразает список друзей пользователя.',
                        'resolve' => function ($root) {
                            return DB::select(
                                "SELECT u.* from friendships f JOIN users u ON u.id = f.friend_id WHERE f.user_id = {$root->id}"
                            );
                        }
                    ],
                    'countFriends' => [
                        'type' => Types::int(),
                        'description' => 'Возвращает количество друзей пользователя.',
                        'resolve' => function ($root) {
                            return DB::affectingStatement(
                                "SELECT u.* from friendships f JOIN users u ON u.id = f.friend_id WHERE f.user_id = {$root->id}"
                            );
                        }
                    ]
                ];
            }

        ];
        parent::__construct($config);
    }
}