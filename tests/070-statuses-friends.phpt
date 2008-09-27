--TEST--
statuses-friends
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
echo $twitter->statuses->friends();
echo $twitter->statuses->friends(array(
    'page' => 10
));

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    $res     = $twitter->statuses->friends(array('id' => $aFriendOfMine));
    var_dump(count($res->user) > 0);
} else {
    var_dump(true);
}
    

?>
--EXPECT--
GET	http://twitter.com/statuses/friends.xml	
GET	http://twitter.com/statuses/friends.xml	page=10
bool(true)
