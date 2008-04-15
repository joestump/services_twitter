--TEST--
Services_Twitter::favorites()
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass);
$res = $twitter->favorites();
var_dump(isset($res->status)); 
var_dump((count($res->status) > 0));

?>
--EXPECT--
bool(true)
bool(true)
