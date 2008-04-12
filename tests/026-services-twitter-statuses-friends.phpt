--TEST--
Services_Twitter_Statuses::friends()
--SKIPIF--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass);
$res = $twitter->statuses->friends();

if (!count($res->user)) {
    echo "skip $user has no friends";
    exit;
}

?>
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass);
$res = $twitter->statuses->friends();

if (!count($res->user)) {
    echo "No users!\n";
    exit;
}

foreach ($res->user as $user) {
    if (!is_numeric((int)$user->id)) {
        print_r($user);
    }
}

?>
--EXPECT--
