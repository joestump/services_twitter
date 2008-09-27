--TEST--
friendships-create
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
echo $twitter->friendships->create('foo');

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    $res1    = $twitter->friendships->destroy($aFriendOfMine);
    $res2    = $twitter->friendships->create($aFriendOfMine);
    var_dump(((int)   $res1->id          == $aFriendOfMine || 
              (string)$res1->screen_name == $aFriendOfMine) &&
             ((int)   $res2->id          == $aFriendOfMine || 
              (string)$res2->screen_name == $aFriendOfMine));
} else {
    var_dump(true);
}
    

?>
--EXPECT--
POST	http://twitter.com/friendships/create/foo.xml	
bool(true)
