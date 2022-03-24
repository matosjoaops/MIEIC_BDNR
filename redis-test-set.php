<?php

require __DIR__ . '/vendor/autoload.php';

Predis\Autoloader::register();

try {

	$redis = new Predis\Client();

	$redis->set("hello", "redis");

	$redis->set("foo","bar!");
	$redis->expire("foo", 5);
} catch(Exception $e){
	print $e->getMessage();
}


?>
