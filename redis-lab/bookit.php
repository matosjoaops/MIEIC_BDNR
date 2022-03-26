<?php

$url = $_GET["url"];

$tags = $_GET["tags"];

require __DIR__ . '/vendor/autoload.php';

Predis\Autoloader::register();

try {

	$redis = new Predis\Client();

    $bookmark_id = $redis->incr("next_bookmark_id");
    $redis->zadd("bookmarks", [$bookmark_id => $bookmark_id]);

    $bookmark_key = "bookmark:" . $bookmark_id;

    $redis->hset($bookmark_key, "url", $url);

    $actual_tags = explode(",", $tags);

    foreach ($actual_tags as $actual_tag)
    {
      $redis->sadd($bookmark_key . ":tags", [$actual_tag]);
      $redis->sadd("tag:" . $actual_tag, [$bookmark_id]);
    }

    print_r($redis->zrange("bookmarks", -15, -1));
	
} catch(Exception $e){
	print $e->getMessage();
}


header('Location: /');

?>