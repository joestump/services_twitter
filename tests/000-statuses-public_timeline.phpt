--TEST--
statuses-public_timeline
--FILE--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass, array('test' => true));
echo $twitter->statuses->public_timeline();

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    $res     = $twitter->statuses->public_timeline();
    var_dump(count($res->status) == 20);
} else {
    var_dump(true);
}
    

?>
--EXPECT--
GET	http://twitter.com/statuses/public_timeline.xml	
bool(true)
