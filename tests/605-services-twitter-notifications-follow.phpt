--TEST--
Services_Twitter_Notifications::follow()
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass);
$res = $twitter->notifications->follow($aFriendOfMine);
var_dump(((intval((string)$res->id) == $aFriendOfMine) || 
          ((string)$res->screen_name == $aFriendOfMine)));


?>
--EXPECT--
bool(true)
