--TEST--
Services_Twitter_Statuses::friends_timeline()
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass);
$res = $twitter->statuses->friends_timeline();

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
