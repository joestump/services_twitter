--TEST--
account-verify_credencials
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter = Services_Twitter_factory('account/verify_credentials');
    $user    = $twitter->account->verify_credentials();
    var_dump($user instanceof stdclass && isset($user->id));
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
