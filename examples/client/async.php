<?php
$client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC); //异步非阻塞


$client->on("connect", function(swoole_client $cli) {
    $cli->send("GET / HTTP/1.1\r\n\r\n");
});

$client->on("receive", function(swoole_client $cli, $data){
    echo "Receive: $data";
	usleep(10000);
	$cli->send(str_repeat('A', 100)."\n");
});

$client->on("error", function(swoole_client $cli){
    exit("error\n");
});

$client->on("close", function(swoole_client $cli){
    echo "Connection close";
});


$client->connect('localhost', 9501, 0.5);

echo "connect to 127.0.0.1:9501\n";
//for PHP5.3-
//swoole_event_wait();
