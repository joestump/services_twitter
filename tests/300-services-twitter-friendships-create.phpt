--TEST--
Services_Twitter_Friendships::create()
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass);
$res = $twitter->friendships->create('joestump');

var_dump(((string)$res->screen_name == 'joestump'));

?>
--EXPECT--
bool(true)
