--TEST--
Services_Twitter utf8
--SKIPIF--
<?php

echo 'skip Services_Twitter utf8 not yet implemented';

?>
--FILE--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass, array('test' => true));
// TODO

?>
--EXPECT--
