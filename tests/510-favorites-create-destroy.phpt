--TEST--
favorites-create-destroy
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter = Services_Twitter_factory('favorites/create');
    $fav     = $twitter->favorites->create($config['status_id']);
    var_dump($fav instanceof stdclass && $fav->favorited);

    $twitter = Services_Twitter_factory('favorites/destroy');
    $fav     = $twitter->favorites->destroy($config['status_id']);
    var_dump($fav instanceof stdclass && !$fav->favorited);
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
bool(true)
