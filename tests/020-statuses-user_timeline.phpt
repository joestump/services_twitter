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
    //fwrite(fopen('tests/data/statuses/user_timeline.dat', 'w'), $timeline);
    var_dump(count($timeline) == 5);
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}


?>
--EXPECT--
bool(true)
