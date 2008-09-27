--TEST--
blocks-create
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
echo $twitter->blocks->create('foo');

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    $res     = $twitter->blocks->create($aFriendOfMine);
    var_dump((int)$res->id == $aFriendOfMine || 
             (string)$res->screen_name == $aFriendOfMine);
} else {
    var_dump(true);
}
    

?>
--EXPECT--
POST	http://twitter.com/blocks/create/foo.xml	
bool(true)
