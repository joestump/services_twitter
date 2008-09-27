--TEST--
help-downtime_schedule
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
echo $twitter->help->downtime_schedule();

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    $res     = $twitter->help->downtime_schedule();
    var_dump($res instanceof SimpleXMLElement);
} else {
    var_dump(true);
}
    

?>
--EXPECT--
GET	http://twitter.com/help/downtime_schedule.xml	
bool(true)
