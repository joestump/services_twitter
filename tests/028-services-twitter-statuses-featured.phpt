--TEST--
Services_Twitter_Statuses::featured()
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

try {
    $twitter = new Services_Twitter($user, $pass);
    $res = $twitter->statuses->featured();

    if (!count($res->user)) {
        echo "No featured users!\n";
        print_r($res);
        exit;
    }

    foreach ($res->user as $user) {
        if (!is_numeric((int)$user->id)) {
            print_r($user);
        }
    }

} catch (Services_Twitter_Exception $e) {
    echo $e . "\n";
}

?>
--EXPECT--
