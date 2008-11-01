--TEST--
Services_Twitter_Account::archive()
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

try {
    $twitter = new Services_Twitter($user, $pass);
    $res = $twitter->account->archive();
} catch (Exception $e) {
    echo "Error";
}

?>
--EXPECT--
Error
