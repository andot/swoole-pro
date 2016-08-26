# SwoolePro

[![Build Status](https://travis-ci.org/andot/swoole-pro.svg?branch=master)](https://travis-ci.org/andot/swoole-pro)
![Supported PHP versions: 5.5 .. 7.1](https://img.shields.io/badge/php-5.5~7.1-blue.svg)
[![Packagist](https://img.shields.io/packagist/v/andot/swoole-pro.svg)](https://packagist.org/packages/andot/swoole-pro)
[![Packagist Download](https://img.shields.io/packagist/dm/andot/swoole-pro.svg)](https://packagist.org/packages/andot/swoole-pro)
[![License](https://img.shields.io/packagist/l/andot/swoole-pro.svg)](https://packagist.org/packages/andot/swoole-pro)

## 简介

*SwoolePro* 是 Swoole Promisify 的缩写，而不是 Swoole Professional 的缩写。

[Swoole](http://www.swoole.com/) 是一个优秀的 PHP 项目高性能网络通信扩展，为 PHP 提供了独立的网络服务器和异步网络客户端。

Swoole 1.x 提供的异步接口是自定义事件和函数回调形式的。

Swoole 2.x 增加了对协程版客户端的支持，开发者可以无感知的用同步的代码编写方式达到异步 IO 的效果和性能，避免了传统异步回调所带来的离散的代码逻辑和陷入多层回调中导致代码无法维护。

但是 Swoole 2.x 的协程是在底层封装的，开发者不需要也无法使用 yield 关键词来标识一个协程 IO 操作，虽然在一定程度上提高了开发效率，但是在灵活性上有所欠缺。

另外，Swoole 2.x 的协程仅仅是针对客户端 IO 的，而不是通用的。所以在很多 Swoole 的其它异步操作上就无法使用了。

SwoolePro 的开发目标是为 Swoole 1.x 提供一层包装，使其异步操作从回调函数和事件方式转换为 Promise 方式，然后再结合协程，实现对异步操作的灵活控制。 

SwoolePro 中的 Promise 和协程都是基于 [hprose-php](https://github.com/hprose/hprose-php) 中所提供的相关 API 实现的。因此可以跟 [hprose-swoole](https://github.com/hprose/hprose-swoole) 无缝结合使用。