<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->confirm_select();

$channel->exchange_declare('logs', 'fanout', false, false, false);

$data = implode(' ', array_slice($argv, 1));
if (empty($data)) {
    $data = "info: START!";
}
$msg = new AMQPMessage($data);

$channel->basic_publish($msg, 'logs');

for ($i = 0; $i < 10; $i++) {
    $data = rand(5,1000);
    $msg = new AMQPMessage($data);
    $channel->basic_publish($msg, 'logs');
    $channel->wait_for_pending_acks(5.000);
}


echo ' [x] Sent ', $i, "\n";

$channel->close();
$connection->close();
