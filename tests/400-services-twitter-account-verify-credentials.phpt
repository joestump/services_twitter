--TEST--
Services_Twitter_Account::verify_credentials()
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass);
$res = $twitter->account->verify_credentials();
var_dump($res);

?>
--EXPECT--
bool(true)
