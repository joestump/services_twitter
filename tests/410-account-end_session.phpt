--TEST--
account-end_session
--FILE--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass, array('test' => true));
echo $twitter->account->end_session();

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    $res     = $twitter->account->end_session();
    var_dump((string)$res->error == 'Logged out.');
} else {
    var_dump(true);
}
    

?>
--EXPECT--
POST	http://twitter.com/account/end_session.xml	
bool(true)
