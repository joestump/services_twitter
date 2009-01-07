--TEST--
statuses-friends_timeline
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter  = Services_Twitter_factory('statuses/friends_timeline');
    $timeline = $twitter->statuses->friends_timeline(array(
        'since_id' => $config['status_id'],
        'since'    => 1222455148, //Fri, 26 Sep 2008 20:52:28 +0200
        'count'    => 5,
        'page'     => 1
    ));
    var_dump(is_array($timeline));
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
