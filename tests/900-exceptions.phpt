--TEST--
exceptions
--FILE--
<?php

require_once 'Services/Twitter.php';
$twitter = new Services_Twitter(null, null, array('validate' => true));

try {
    $twitter->noncategory->foo(); 
} catch (Services_Twitter_Exception $exc) {
    echo $exc->getMessage() . "\n";
}
try {
    $twitter->nonendpoint(); 
} catch (Services_Twitter_Exception $exc) {
    echo $exc->getMessage() . "\n";
}
try {
    $twitter->statuses->foo();
} catch (Services_Twitter_Exception $exc) {
    echo $exc->getMessage() . "\n";
}
try {
    $twitter->statuses->statuses->foo(); 
} catch (Services_Twitter_Exception $exc) {
    echo $exc->getMessage() . "\n";
}

try {
    $twitter->statuses->friends_timeline('foo');
} catch (Services_Twitter_Exception $exc) {
    echo $exc->getMessage() . "\n";
}

try {
    $twitter->statuses->update();
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
    echo $exc->getMessage() . "\n";
    echo $exc->getCall() . "\n";
}

$twitter = new Services_Twitter(null, null, array('format' => 'foo'));
try {
    $twitter->statuses->public_timeline();
} catch (Services_Twitter_Exception $exc) {
    echo $exc->getMessage() . "\n";
}

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter = Services_Twitter_factory('exception1', false);
    $twitter->statuses->friends_timeline();
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
    var_dump($exc->getResponse() instanceof HTTP_Request2_Response);
}

try {
    Services_Twitter::$uri = 'http://example.com';
    $twitter = Services_Twitter_factory('exception2');
    print_r($twitter->statuses->show(1234));
    Services_Twitter::$uri = 'http://twitter.com';
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
    var_dump($exc->getResponse() instanceof HTTP_Request2_Response);
}

Services_Twitter::$uri = 'this is a bad url indeed...';
$twitter = new Services_Twitter();
try {
    $twitter->statuses->public_timeline();
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
    var_dump($exc->getCause() instanceof HTTP_Request2_Exception);
}

?>
--EXPECT--
Unsupported endpoint noncategory
Unsupported endpoint nonendpoint
Unsupported endpoint statuses/foo
Unsupported endpoint statuses
/statuses/friends_timeline expects an array as unique parameter
Not enough arguments for /statuses/update (code: 3, call: /statuses/update)
Not enough arguments for /statuses/update
/statuses/update
Endpoint public_timeline does not support foo format
Could not authenticate you. (code: 401, call: http://twitter.com/statuses/friends_timeline.json)
bool(true)
Not Found (code: 404, call: http://example.com/statuses/show/1234.json)
bool(true)
Absolute URL required (code: 0, call: this is a bad url indeed.../statuses/public_timeline.json)
bool(true)
