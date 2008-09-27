--TEST--
direct_messages-sent
--FILE--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass, array('test' => true));
echo $twitter->direct_messages->sent();

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    $res     = $twitter->direct_messages->sent();
    var_dump(count($res->direct_message) > 0);
} else {
    var_dump(true);
}
    

?>
--EXPECT--
GET	http://twitter.com/direct_messages/sent.xml	
bool(true)
