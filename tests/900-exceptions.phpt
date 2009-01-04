--TEST--
exceptions
--FILE--
<?php

require_once 'Services/Twitter.php';
$twitter = new Services_Twitter(null, null, array('validate' => true));

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
    echo get_class($exc->getResponse());
}

$twitter = new Services_Twitter(null, null, array('format' => 'foo'));
try {
    $twitter->statuses->public_timeline();
} catch (Exception $exc) {
    echo $exc->getMessage() . "\n";
}

//require_once dirname(__FILE__) . '/setup.php';
//$twitter = Services_Twitter_factory('exceptions');

?>
--EXPECT--
Unsupported endpoint noncategory
Unsupported endpoint nonendpoint
Unsupported endpoint statuses/foo
Unsupported endpoint statuses
/statuses/friends_timeline expects an array as unique parameter
Not enough arguments for /statuses/update (code: 3, call: http://twitter.com/statuses/update.json)
Not enough arguments for /statuses/update
http://twitter.com/statuses/update.json
Endpoint public_timeline does not support foo format
