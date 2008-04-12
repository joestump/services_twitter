--TEST--
Services_Twitter_Statuses::public_timeline()
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass);
$res = $twitter->statuses->user_timeline();

if (!count($res->status)) {
    echo "No statuses in the public timeline!\n";
    exit;
}

foreach ($res->status as $status) {
    if (!is_numeric((int)$status->id)) {
        print_r($status);
    }
}

?>
--EXPECT--
