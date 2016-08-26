<?php

include __DIR__ . '/../vendor/autoload.php';

use Swoole\Pro\Async;
use Hprose\Promise;

function exam1() {
    Async::lookup("baidu.com")->then(function($ip) {
        var_dump($ip);
    });
}

function exam2() {
    Async::lookup("baidu.ooxx")->catchError(function($e) {
        var_dump($e->getMessage());
    });
}

function exam3() {
    var_dump((yield Async::lookup("baidu.com")));
}

function exam4() {
    try {
        yield Async::lookup("baidu.ooxx");
    }
    catch (Exception $e) {
        var_dump($e->getMessage());
    }
}

function main() {
    exam1();
    exam2();
    Promise\co('exam3');
    Promise\co('exam4');
}

main();