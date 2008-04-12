--TEST--
Services_Twitter_DirectMessages::sent()
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass);
$res = $twitter->direct_messages->sent();

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
