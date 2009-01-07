--TEST--
statuses-public_timeline
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter  = Services_Twitter_factory('statuses/public_timeline');
    $timeline = $twitter->statuses->public_timeline();
    var_dump(is_array($timeline) && count($timeline) == 20);
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
