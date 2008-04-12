--TEST--
Services_Twitter_Statuses::replies()
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass);
$res = $twitter->statuses->replies(777808453);

foreach ($res->status as $status) {
    if (!preg_match('/@' . $user . '/i', (string)$status->text)) {
        echo 'Does not contain @' . $user . ':' . "\n";
        echo (string)$status->text . "\n";
    }
}

?>
--EXPECT--
