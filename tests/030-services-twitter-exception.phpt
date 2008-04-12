--TEST--
Services_Twitter_Statuses::destroy()
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

try {
    $twitter = new Services_Twitter($user, $pass);
    $res = $twitter->statuses->destroy(778371313);
    var_dump($res);
} catch (Services_Twitter_Exception $e) {
    echo $e->getMessage();
}

?>
--EXPECT--
No status found with that ID.
