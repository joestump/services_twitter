--TEST--
Services_Twitter_DirectMessages::new()
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass);
$res = $twitter->direct_messages->new($aFriendOfMine, 'Hey! I have (' . $user . ') been playing with Services_Twitter');

var_dump((intval((string)$res->id) > 0));

?>
--EXPECT--
bool(true)
