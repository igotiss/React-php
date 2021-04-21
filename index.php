<?php

require 'vendor/autoload.php';

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;
use React\Http\Server;

$loop = React\EventLoop\Factory::create();
$router = new Router();

$router->load(__DIR__ . '/routes.php');

$server = new Server(
  $loop,
  function (ServerRequestInterface $request) use ($router){
    return $router($request);
  }
);


$socket = new React\Socket\Server(8080, $loop);
$server->listen($socket);
echo 'Работает на '
  . str_replace('tcp:', 'http:', $socket->getAddress())
  . PHP_EOL;
$loop->run();
