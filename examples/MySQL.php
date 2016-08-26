<?php

include __DIR__ . '/../vendor/autoload.php';

use Swoole\Pro\MySQL;
use Hprose\Promise;

function main() {
    $mysql = new MySQL();
    $mysql->connect(array(
        'host' => '127.0.0.1',
        'user' => 'test',
        'password' => 'test',
        'database' => 'test',
    ));
    try {
        var_dump((yield $mysql->query("select * from test")));
        var_dump((yield $mysql->query("select * from test")));
        var_dump((yield $mysql->query("select * from test")));
    }
    catch (Exception $e) {
        var_dump($e->getMessage());
    }
    $mysql->close();
}

Promise\co('main');
