--TEST--
statuses-user_timeline
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter  = Services_Twitter_factory('statuses/user_timeline');
    $timeline = $twitter->statuses->user_timeline(array(
        'id'     => $config['user'],
        'count'  => 5,
    ));
    var_dump(is_array($timeline));
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}


?>
--EXPECT--
bool(true)
