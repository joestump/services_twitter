--TEST--
Services_Twitter_Statuses::update()
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Twitter.php';

$update = '@joestump ' . $user . ' is playing with Services_Twitter.';

$twitter = new Services_Twitter($user, $pass);
$res = $twitter->statuses->update($update);

var_dump(((string)$res->text == $update));

$id = (string)$res->id;
$fp = fopen('status.destroy', 'w');
fwrite($fp, $id, strlen($id));
fclose($fp);

?>
--EXPECT--
bool(true)
