<?php
/**********************************************************\
|                                                          |
|                    Swoole Promisify                      |
|                                                          |
\**********************************************************/
/**********************************************************\
 *                                                        *
 * Swoole/Pro/Async.php                                   *
 *                                                        *
 * LastModified: Aug 26, 2016                             *
 * Author: Ma Bingyao <andot@hprose.com>                  *
 *                                                        *
\**********************************************************/

namespace Swoole\Pro;

use Exception;
use Hprose\Promise;

class MySQL {
    private $db;
    private $link;
    public function __construct() {
        $this->link = new Promise();
    }
    public function connect(array $serverConfig) {
        if ($this->link->state !== Promise::PENDING) {
            $this->db->close();
            $this->link = new Promise();
        }
        $this->db = new \Swoole\MySQL();
        $this->db->connect($serverConfig, function($db, $ok) {
            if ($ok) {
                $this->link->resolve(true);
            }
            else {
                $this->link->reject(new Exception(
                    $db->connect_error,
                    $db->connect_errno
                ));
            }
        });
        return $this->link;
    }
    public function query($sql) {
        return $this->link->then(function() use ($sql) {
            $result = new Promise();
            $this->db->query($sql, function($link, $data) use ($result) {
                if ($data === false) {
                    $result->reject(new Exception(
                        $link->error,
                        $link->errno
                    ));
                }
                else {
                    if ($data === true) {
                        $data = array();
                        if (isset($link->affected_rows)) {
                            $data['affected_rows'] = $link->affected_rows;
                        }
                        if (isset($link->insert_id)) {
                            $data['insert_id'] = $link->insert_id;
                        }
                    }
                    $result->resolve($data);
                }
            });
            return $result;
        });
    }
    public function close() {
        $this->link->complete(function() {
            $this->db->close();
            $this->link = new Promise();
        });
    }
}