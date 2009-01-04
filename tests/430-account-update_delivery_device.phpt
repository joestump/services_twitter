--TEST--
account-update-delivery-device
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter = Services_Twitter_factory('account/update_delivery_device');
    $user    = $twitter->account->update_delivery_device('none');
    var_dump($user instanceof stdclass && isset($user->id));
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
