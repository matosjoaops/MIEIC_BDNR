<?php

$url = $_GET["url"];

$tags = $_GET["tags"];

require __DIR__ . '/vendor/autoload.php';

Predis\Autoloader::register();

try {

	$redis = new Predis\Client();

    $redis->incr("next_bookmark_id");
    $redis->zadd("bookmarks", $url);

    $actual_tags = explode(",", $tags);

    foreach ($actual_tags as $actual_tag)
    {
      
    }

    

	
} catch(Exception $e){
	print $e->getMessage();
}


header('Location: '.'/');

?>