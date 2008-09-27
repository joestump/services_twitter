--TEST--
account-update_delivery_device
--FILE--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass, array('test' => true));
echo $twitter->account->update_delivery_device('sms');

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    $res     = $twitter->account->update_delivery_device('im');
    var_dump($res instanceof SimpleXMLElement);
} else {
    var_dump(true);
}
    

?>
--EXPECT--
POST	http://twitter.com/account/update_delivery_device.xml	device=sms
bool(true)
