--TEST--
favorites-create
--SKIPIF--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';

if (!isset($statusID) || !$statusID) {
    echo '$statusID is not set properly';
}

?>
--FILE--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass, array('test' => true));
echo $twitter->favorites->create(100000);

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    $res     = $twitter->favorites->create($statusID);
    var_dump((int)$res->id == $statusID);
} else {
    var_dump(true);
}
    

?>
--EXPECT--
POST	http://twitter.com/favorites/create/100000.xml	
bool(true)
