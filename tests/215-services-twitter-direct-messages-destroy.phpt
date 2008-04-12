--TEST--
Services_Twitter_DirectMessages::destroy()
--SKIPIF--
<?php

require_once 'tests-config.php';
if (!isset($directMessageToDelete) || !is_numeric($directMessageToDelete)) {
    echo 'skip $directMessageToDelete is not set properly';
}

?>
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass);
$res = $twitter->direct_messages->destroy($directMessageToDelete);
var_dump((intval((string)$res->id) == $directMessageToDelete));

?>
--EXPECT--
bool(true)
