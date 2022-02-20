<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\DB\DB;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use App\Types;

DB::init(['hostName' => 'db', 'userName' => 'root', 'password' => 'password', 'dataBase' => 'db']);

$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput, true);
$query = $input['query'];

$schema = new Schema([
    'query' => Types::query()
]);

$result = GraphQL::executeQuery($schema, $query);


header('Content-Type: application/json; charset=UTF-8');
echo json_encode($result);