--TEST--
statuses-update
--FILE--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass, array('test' => true));
echo $twitter->statuses->update('foo');
echo $twitter->statuses->update('foo', array(
    'in_reply_to_status_id' => 100000
));

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    $text    = 'Testing PEAR Services_Twitter';
    $res     = $twitter->statuses->update($text);
    var_dump((string)$res->text == $text);
    try {
        $twitter->statuses->destroy((int)$res->id);
    } catch (Exception $exc) {
        echo "failed to destroy direct_message {$res->id}\n";
    }
} else {
    var_dump(true);
}
    

?>
--EXPECT--
POST	http://twitter.com/statuses/update.xml	status=foo
POST	http://twitter.com/statuses/update.xml	status=foo&in_reply_to_status_id=100000
bool(true)
