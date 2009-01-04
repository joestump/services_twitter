--TEST--
validation
--FILE--
<?php

require_once 'Services/Twitter.php';

$twitter = new Services_Twitter();

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
try {
    $twitter->search('foo', array('lang'=>'bar'));
} catch (Exception $exc) {
    echo $exc->getMessage() . "\n";
}
try {
    $twitter->search('foo', array('geocode'=>'bar'));
} catch (Exception $exc) {
    echo $exc->getMessage() . "\n";
}
try {
    $twitter->account->update_profile_colors(
        array('profile_text_color' => 'bar')
    );
} catch (Exception $exc) {
    echo $exc->getMessage() . "\n";
}
try {
    $twitter->account->update_profile_image(
        array('image' => '/some/path/to/image.gif')
    );
} catch (Exception $exc) {
    echo $exc->getMessage() . "\n";
}

?>
--EXPECT--
Not enough arguments for /statuses/update
/statuses/update: status must be a string
/statuses/update: status must not exceed 140 chars
/friendships/create/foo: follow must be a boolean
/statuses/friends_timeline: since_id must be an integer
/statuses/friends_timeline: since must be an HTTP-formatted date (ex: Tue, 27 Mar 2007 22:55:48 GMT)
/friendships/create: id must be a valid id or screen name
/account/update_delivery_device: device must be one of the following: none, sms, im
/search: lang must be a valid iso-639-1 language code
/search: geocode must be "latitide,longitude,radius(km or mi)"
/account/update_profile_colors: profile_text_color must be an hexadecimal color code (eg. fff)
/account/update_profile_image: image must be a valid image path
