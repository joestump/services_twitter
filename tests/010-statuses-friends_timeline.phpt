--TEST--
statuses-friends_timeline
--FILE--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass, array('test' => true));

echo $twitter->statuses->friends_timeline(array(
    'since_id' => 100000,
    'since'    => 1222455148, //Fri, 26 Sep 2008 20:52:28 +0200
    'count'    => 100,
    'page'     => 1
));

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    $res     = $twitter->statuses->friends_timeline(array('count' => 1));
    var_dump(count($res->status) == 1);
} else {
    var_dump(true);
}
    

?>
--EXPECT--
GET	http://twitter.com/statuses/friends_timeline.xml	since=Fri%2C+26+Sep+2008+20%3A52%3A28+%2B0200&since_id=100000&count=100&page=1
bool(true)
