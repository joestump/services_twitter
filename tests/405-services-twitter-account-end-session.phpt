--TEST--
Services_Twitter_Account::end_session()
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass);
$res = $twitter->account->end_session();
var_dump($res);

?>
--EXPECT--
bool(true)
