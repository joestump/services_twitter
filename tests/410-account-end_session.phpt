--TEST--
account-end_session
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter = Services_Twitter_factory('account/end_session');
    $resp    = $twitter->account->end_session();
    var_dump($resp->error == "Logged out.");
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
