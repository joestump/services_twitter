--TEST--
Services_Twitter::direct_messages()
--SKIPIF--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass);
$res = $twitter->direct_messages();

if (!count($res->direct_message)) {
    echo "skip $user has no direct messages";
    exit;
}

?>
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass);
$res = $twitter->direct_messages();

if (!count($res->direct_message)) {
    echo "No direct messages!\n";
    exit;
}

foreach ($res->direct_message as $dm) {
    if (!is_numeric((int)$dm->id)) {
        print_r($dm);
    }
}

?>
--EXPECT--
