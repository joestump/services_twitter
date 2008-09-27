--TEST--
account-update_location
--FILE--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass, array('test' => true));
echo $twitter->account->update_location('Toulouse');

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter  = new Services_Twitter($user, $pass);
    $location = 'Somewhere on the moon';
    $res      = $twitter->account->update_location($location);
    var_dump((string)$res->location == $location);
} else {
    var_dump(true);
}
    

?>
--EXPECT--
POST	http://twitter.com/account/update_location.xml	location=Toulouse
bool(true)
