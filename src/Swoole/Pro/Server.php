<?php
/**********************************************************\
|                                                          |
|                    Swoole Promisify                      |
|                                                          |
\**********************************************************/
/**********************************************************\
 *                                                        *
 * Swoole/Pro/Server.php                                  *
 *                                                        *
 * LastModified: Aug 27, 2016                             *
 * Author: Ma Bingyao <andot@hprose.com>                  *
 *                                                        *
\**********************************************************/

namespace Swoole\Pro;

use Exception;
use Hprose\Promise;

class Server {
    public $server;
    public function __construct($host, $port, $mode = SWOOLE_PROCESS,
            $socket_type = SWOOLE_SOCK_TCP) {
        $this->server = new \Swoole\Server($host, $port, $mode, $socket_type);
    }
    public function __call($name, $arguments) {
        return call_user_func_array(array($this, $name), $$arguments);
    }
    public function __set($name, $value) {
        $this->server->$name = $value;
    }
    public function __get($name) {
        return $this->server->$name;
    }
    public function __unset($name) {
        unset($this->server->$name);
    }
    public function task($data, $dst_worker_id = -1) {
        $promise = new Promise();
        $task_id = $this->server->task($data, $dst_worker_id, function($serv, $task_id, $data) use ($promise) {
            $promise->resolve($data);
        });
        if ($task_id === false) {
            $promise->reject(new Exception('task failed.'));
        }
        return $promise;
    }
}