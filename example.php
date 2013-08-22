<?php

require_once __DIR__ . '/Consistency.php';
require_once __DIR__ . '/vendor/autoload.php';

$server = new \Hoa\Websocket\Server(new \Hoa\Socket\Server('tcp://127.0.0.1:8888'));
$server->run();