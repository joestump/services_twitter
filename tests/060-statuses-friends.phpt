--TEST--
statuses-friends
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter = Services_Twitter_factory('statuses/friends');
    $friends = $twitter->statuses->friends(array('page' => 1));
    var_dump(is_array($friends));
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
