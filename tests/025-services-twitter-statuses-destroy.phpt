--TEST--
Services_Twitter_Statuses::destroy()
--SKIPIF--
<?php

if (!file_exists('status.destroy')) {
    echo "skip no status id found to destroy";
}

?>
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass);

$id = intval(file_get_contents('status.destroy'));
$res = $twitter->statuses->destroy($id);

var_dump((intval((string)$res->id) == $id));

unlink('status.destroy');

?>
--EXPECT--
bool(true)
