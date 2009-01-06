--TEST--
notifications-follow-leave
--SKIPIF--
<?php

require_once dirname(__FILE__) . '/setup.php';
$twitter = Services_Twitter_factory('direct_messages/destroy_new');
if ($config['live_test']) {
    echo "skip test not supported when testing live against the server";
}

?>
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter = Services_Twitter_factory('notifications/follow_leave');
    $result  = $twitter->notifications->follow($config['friend']);
    var_dump($result instanceof stdclass && isset($result->id));
    $twitter = Services_Twitter_factory('notifications/follow_leave');
    $result  = $twitter->notifications->leave($config['friend']);
    var_dump($result instanceof stdclass && isset($result->id));
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
bool(true)
