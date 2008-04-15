--TEST--
Services_Twitter_Notifications::leave()
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass);
$res = $twitter->notifications->leave($aFriendOfMine);
var_dump(((intval((string)$res->id) == $aFriendOfMine) || 
          ((string)$res->screen_name == $aFriendOfMine)));

?>
--EXPECT--
bool(true)
