--TEST--
statuses-followers
--SKIPIF--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';

if (!isset($aFriendOfMine) || !strlen($aFriendOfMine)) {
    echo 'skip $aFriendOfMine is not set properly';
}

?>
--FILE--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass, array('test' => true));
echo $twitter->statuses->followers();
echo $twitter->statuses->followers(array('id' => 'foo'));

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    $res     = $twitter->statuses->followers(array('id' => $aFriendOfMine));
    var_dump(count($res->user) > 0);
} else {
    var_dump(true);
}
    

?>
--EXPECTF--
GET	http://twitter.com/statuses/followers.xml	
GET	http://twitter.com/statuses/followers/foo.xml	
bool(true)
