--TEST--
Services_Twitter_Statuses::show()
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass);
$res = $twitter->statuses->show(777808453);
echo $res->text . "\n";

?>
--EXPECT--
Mental Note: Starbucks is on the way to the bus to work.
