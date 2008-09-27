--TEST--
account-rate_limit_status
--FILE--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass, array('test' => true));
echo $twitter->account->rate_limit_status();

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    $res     = $twitter->account->rate_limit_status();
    var_dump((int)$res->{'hourly-limit'} > 0);
} else {
    var_dump(true);
}
    

?>
--EXPECT--
GET	http://twitter.com/account/rate_limit_status.xml	
bool(true)
