--TEST--
statuses-user_timeline
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
echo $twitter->statuses->user_timeline();
echo $twitter->statuses->user_timeline(array(
    'id'    => 'foo',
    'count' => 10
));

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    $res1    = $twitter->statuses->user_timeline(array('id' => $aFriendOfMine));
    $res2    = $twitter->statuses->user_timeline(array('count' => 1));
    var_dump(count($res1->status) > 0 && count($res2->status) == 1);
} else {
    var_dump(true);
}
    

?>
--EXPECT--
GET	http://twitter.com/statuses/user_timeline.xml	
GET	http://twitter.com/statuses/user_timeline/foo.xml	count=10
bool(true)
