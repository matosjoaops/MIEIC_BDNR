<html>
<h1>Bookit!</h1>
<h2>Latest Bookmarks</h2>
<?php

require __DIR__ . '/vendor/autoload.php';

Predis\Autoloader::register();

try {

    $redis = new Predis\Client();

    if (!$redis->exists("next_bookmark_id")) {
        $redis->set("next_bookmark_id", "0");
    }

    // $redis->set("hello", "redis");

    // $redis->set("foo","bar!");
    // $redis->expire("foo", 5);
} catch (Exception $e) {
    print $e->getMessage();
}


?>

<a href="index.php">Home</a>
<a href="add.php">Add another bookmark!</a>

</html>