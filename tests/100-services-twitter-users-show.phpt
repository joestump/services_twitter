--TEST--
Services_Twitter_Users::show()
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

try {
    $twitter = new Services_Twitter($user, $pass);
    $res = $twitter->users->show('kastner');
    echo intval((string)$res->id) . "\n";

    $res = $twitter->users->show('joe@joestump.net');
    echo intval((string)$res->id) . "\n";
} catch (Services_Twitter_Exception $e) {
    echo $e->getMessage();
}

?>
--EXPECT--
627303
4234581
