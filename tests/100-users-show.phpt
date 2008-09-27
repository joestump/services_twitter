--TEST--
users-show
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
echo $twitter->users->show('foo');
echo $twitter->users->show('foo@example.com');

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    $res     = $twitter->users->show($aFriendOfMine);
    var_dump((string)$res->id == $aFriendOfMine || 
             (string)$res->screen_name == $aFriendOfMine);
} else {
    var_dump(true);
}
    

?>
--EXPECT--
GET	http://twitter.com/users/show/foo.xml	
GET	http://twitter.com/users/show.xml	email=foo%40example.com
bool(true)
