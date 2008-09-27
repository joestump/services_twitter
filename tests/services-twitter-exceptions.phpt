--TEST--
Services_Twitter exceptions
--FILE--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass, array('test' => true));

try {
    $twitter->noncategory->foo(); 
} catch (Exception $exc) {
    echo $exc->getMessage() . "\n";
}
try {
    $twitter->nonendpoint(); 
} catch (Exception $exc) {
    echo $exc->getMessage() . "\n";
}
try {
    $twitter->statuses->foo();
} catch (Exception $exc) {
    echo $exc->getMessage() . "\n";
}
try {
    $twitter->statuses->statuses->foo(); 
} catch (Exception $exc) {
    echo $exc->getMessage() . "\n";
}
try {
    $twitter->statuses->friends_timeline('foo');
} catch (Exception $exc) {
    echo $exc->getMessage() . "\n";
}
try {
    $twitter->statuses->update();
} catch (Exception $exc) {
    echo $exc . "\n";
    echo $exc->getMessage() . "\n";
    echo $exc->getCall() . "\n";
    echo $exc->getResponse() . "\n";
}

?>
--EXPECT--
Unsupported endpoint noncategory
Unsupported endpoint nonendpoint
Unsupported endpoint statuses/foo
Unsupported endpoint statuses
/statuses/friends_timeline expects an array as unique parameter
/statuses/update: status is required (Code: 3, Call: )
/statuses/update: status is required


