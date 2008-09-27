--TEST--
notifications-follow
--SKIPIF--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';

if (!isset($aFriendOfMine) || !strlen($aFriendOfMine)) {
    echo '$aFriendOfMine is not set properly';
}

?>
--FILE--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass, array('test' => true));
echo $twitter->notifications->follow('foo');

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    try {
        $twitter->notifications->leave($aFriendOfMine);
    } catch (Exception $exc) {
    }
    $res = $twitter->notifications->follow($aFriendOfMine);
    var_dump((int)$res->id == $aFriendOfMine || 
             (string)$res->screen_name == $aFriendOfMine);
} else {
    var_dump(true);
}
    

?>
--EXPECT--
POST	http://twitter.com/notifications/follow/foo.xml	
bool(true)
