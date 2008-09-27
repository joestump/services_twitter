--TEST--
direct_messages-destroy
--FILE--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass, array('test' => true));
echo $twitter->direct_messages->destroy(100000);

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    try {
        $text = 'Testing PEAR Services_Twitter';
        $res1 = $twitter->direct_messages->new($user, $text);
    } catch (Exception $exc) {
        $res1 = false;
        echo "failed to create direct_message\n";
    }
    if ($res1) {
        $res2 = $twitter->direct_messages->destroy((int)$res1->id);
        var_dump((int)$res2->id == (int)$res1->id);
    }
} else {
    var_dump(true);
}
    

?>
--EXPECT--
POST	http://twitter.com/direct_messages/destroy/100000.xml	
bool(true)
