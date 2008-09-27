--TEST--
friendships-exists
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
echo $twitter->friendships->exists('foo', 'bar');

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    $res     = $twitter->friendships->exists($user, $aFriendOfMine);
    var_dump((string)$res === 'true');
} else {
    var_dump(true);
}
    

?>
--EXPECT--
GET	http://twitter.com/friendships/exists.xml	user_a=foo&user_b=bar
bool(true)
