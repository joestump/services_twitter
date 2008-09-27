--TEST--
Services_Twitter validation
--FILE--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass, array('test' => true));

try {
    $twitter->statuses->update(); 
} catch (Exception $exc) {
    echo $exc->getMessage() . "\n";
}
try {
    $nonstring = true;
    $twitter->statuses->update($nonstring); 
} catch (Exception $exc) {
    echo $exc->getMessage() . "\n";
}
try {
    $longstr = 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb'
             . 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb'
             . 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb';
    $twitter->statuses->update($longstr); 
} catch (Exception $exc) {
    echo $exc->getMessage() . "\n";
}
try {
    $twitter->friendships->create("foo", array('follow'=>'non_bool'));
} catch (Exception $exc) {
    echo $exc->getMessage() . "\n";
}
try {
    $twitter->statuses->friends_timeline(array('since_id' => 'non_integer'));
} catch (Exception $exc) {
    echo $exc->getMessage() . "\n";
}
try {
    $twitter->statuses->friends_timeline(array('since' => 'non_date'));
} catch (Exception $exc) {
    echo $exc->getMessage() . "\n";
}
try {
    $twitter->friendships->create("~~~~non user id~~~~");
} catch (Exception $exc) {
    echo $exc->getMessage() . "\n";
}
try {
    $twitter->account->update_delivery_device("non_device");
} catch (Exception $exc) {
    echo $exc->getMessage() . "\n";
}

?>
--EXPECT--
/statuses/update: status is required
/statuses/update: status must be a string
/statuses/update: status must not exceed 140 chars
/friendships/create/foo: follow must be a boolean
/statuses/friends_timeline: since_id must be an integer
/statuses/friends_timeline: since must be an HTTP-formatted date (ex: Tue, 27 Mar 2007 22:55:48 GMT)
/friendships/create: id must be a valid id or screen name
/account/update_delivery_device: device must be one of the following: none, sms, im
