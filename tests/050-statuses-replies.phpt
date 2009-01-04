--TEST--
statuses-replies
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter = Services_Twitter_factory('statuses/replies');
    $replies = $twitter->statuses->replies();
    var_dump(is_array($replies));
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
