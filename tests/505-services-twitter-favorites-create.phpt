--TEST--
Services_Twitter_Favorites::create()
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass);
$res = $twitter->favorites->create($favoriteID);
var_dump((intval((string)$res->id) == $favoriteID));

?>
--EXPECT--
bool(true)
