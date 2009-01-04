--TEST--
notifications-follow-leave
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter = Services_Twitter_factory('notifications/follow_leave');
    $result  = $twitter->notifications->leave($config['friend']);
    var_dump($result instanceof stdclass && isset($result->id));

    $twitter = Services_Twitter_factory('notifications/follow_leave');
    $result  = $twitter->notifications->follow($config['friend']);
    var_dump($result instanceof stdclass && isset($result->id));
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
bool(true)
