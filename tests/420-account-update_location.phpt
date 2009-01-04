--TEST--
account-update-location
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter = Services_Twitter_factory('account/update_location');
    $user    = $twitter->account->update_location('somewhere in the moon...');
    var_dump($user instanceof stdclass && isset($user->id));
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
