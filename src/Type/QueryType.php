<?php

namespace App\Type;

use App\DB\DB;
use App\Types;
use GraphQL\Type\Definition\ObjectType;

class QueryType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => function () {
                return [
                    'user' => [
                        'type' => Types::user(),
                        'description' => 'Возвразает пользователя по Id.',
                        'args' => [
                            'id' => [
                                    'type' => Types::int(),
                                    'description' => 'Id искомого пользователя.',
                                ]
                        ],
                        'resolve' => function ($root, $args) {
                            return DB::selectOne("SELECT * from users WHERE id = {$args['id']}");
                        }
                    ],
                    'allUsers' => [
                        'type' => Types::listOf(Types::user()),
                        'description' => 'Список пользователей',
                        'resolve' => function () {
                            return DB::select('SELECT * from users');
                        }
                    ]
                ];
            }

        ];
        parent::__construct($config);
    }
}