<?php
// PayFast will call this URL (server-to-server) if it uses CHECKOUT_URL.
// For now we just log everything.

$root = realpath(__DIR__ . '/..');
$log  = $root ? ($root.'/storage/logs/payfast_notify.log') : (sys_get_temp_dir().'/payfast_notify.log');

$payload = [
  'time' => date('Y-m-d H:i:s'),
  'method' => $_SERVER['REQUEST_METHOD'] ?? '',
  'get' => $_GET,
  'post' => $_POST,
  'raw' => file_get_contents('php://input'),
  'headers' => function_exists('getallheaders') ? getallheaders() : [],
];

@file_put_contents($log, json_encode($payload, JSON_PRETTY_PRINT).PHP_EOL."-----".PHP_EOL, FILE_APPEND);

header('Content-Type: text/plain');
echo "OK";
