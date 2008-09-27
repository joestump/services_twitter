--TEST--
statuses-replies
--FILE--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass, array('test' => true));
echo $twitter->statuses->replies();
echo $twitter->statuses->replies(array(
    'since' => 'Fri, 26 Sep 2008 20:52:28 +0200'
));

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    $res     = $twitter->statuses->replies();
    var_dump($res['type'] == 'array');
} else {
    var_dump(true);
}
    

?>
--EXPECT--
GET	http://twitter.com/statuses/replies.xml	
GET	http://twitter.com/statuses/replies.xml	since=Fri%2C+26+Sep+2008+20%3A52%3A28+%2B0200
bool(true)
