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

class Async {
    static function lookup($host) {
        $result = new Promise();
        swoole_async_dns_lookup($host, function($host, $ip) use ($result) {
            if ($ip) {
                $result->resolve($ip);
            }
            else {
                $result->reject(new Exception("Can't reslove host: $host"));
            }
        });
        return $result;
    }
}