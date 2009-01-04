--TEST--
favorites-favorites
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter = Services_Twitter_factory('favorites/favorites');
    $favs    = $twitter->favorites();
    var_dump(is_array($favs));
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
