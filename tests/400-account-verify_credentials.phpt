--TEST--
account-verify_credentials
--FILE--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass, array('test' => true));
echo $twitter->account->verify_credentials();

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    $res     = $twitter->account->verify_credentials();
    var_dump((string)$res === 'true');
} else {
    var_dump(true);
}
    

?>
--EXPECT--
GET	http://twitter.com/account/verify_credentials.xml	
bool(true)
