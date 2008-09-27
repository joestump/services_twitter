--TEST--
direct_messages-new
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
echo $twitter->direct_messages->new('foo', 'some message');

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    $text    = 'Testing PEAR Services_Twitter';
    $res     = $twitter->direct_messages->new($aFriendOfMine, $text);
    var_dump((string)$res->text == $text);
} else {
    var_dump(true);
}
    

?>
--EXPECT--
POST	http://twitter.com/direct_messages/new.xml	user=foo&text=some+message
bool(true)
