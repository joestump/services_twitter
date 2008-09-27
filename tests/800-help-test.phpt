--TEST--
help-test
--FILE--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass, array('test' => true));
echo $twitter->help->test();

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    var_dump((string)$twitter->help->test() === 'true');
} else {
    var_dump(true);
}
    

?>
--EXPECT--
GET	http://twitter.com/help/test.xml	
bool(true)
