<html>
<h1>Bookit!</h1>
<h2>Latest Bookmarks</h2>
<?php

function present_bookmarks($bookmarks, $redis) {
    echo "<ul>";
        foreach ($bookmarks as $bookmark) {
            $url = $redis->hget("bookmark:" . $bookmark, "url");
            $bookmark_tags = $redis->smembers("bookmark:" . $bookmark . ":tags");
            ?>

            <li>
                <h4><?=$url?></h4>
                <ul>
                    <?php
                        foreach($bookmark_tags as $tag) {
                         ?>
                         <li><?=$tag?></li>
                         <?php
                        }
                    ?>
                </ul>
            </li>

            <?php
        }
    echo "</ul>";
}

function prepend_tag($tag) {
    return "tag:".$tag;
}

require __DIR__ . '/vendor/autoload.php';

Predis\Autoloader::register();

try {

    $redis = new Predis\Client();

    if (!$redis->exists("next_bookmark_id")) {
        $redis->set("next_bookmark_id", "0");
    }

    if (isset($_GET["tags"])) {
        $tags = explode(",", $_GET["tags"]);
    
        
        if (sizeof($tags) === 1)
        {
            $bookmarks = $redis->smembers("tag:" . $_GET["tags"]);
            
        } 
        else {
       
            $bookmarks = $redis->sinter(array_map("prepend_tag",$tags));
           
        }

        present_bookmarks($bookmarks, $redis);
    }
    else {
        $last_15_bookmarks = $redis->zrange("bookmarks", -15, -1);
        present_bookmarks($last_15_bookmarks, $redis);
    }

} catch (Exception $e) {
    print $e->getMessage();
}


?>

<a href="index.php">Home</a>
<a href="add.php">Add another bookmark!</a>

</html>