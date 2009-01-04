--TEST--
statuses-followers
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter = Services_Twitter_factory('statuses/followers');
    $followers = $twitter->statuses->followers(array('page' => 1));
    var_dump(is_array($followers));
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
