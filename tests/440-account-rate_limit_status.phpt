--TEST--
account-rate-limit-status
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter = Services_Twitter_factory('account/rate_limit_status');
    $rate    = $twitter->account->rate_limit_status();
    var_dump($rate instanceof stdclass && isset($rate->remaining_hits));
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
