--TEST--
statuses-destroy
--FILE--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass, array('test' => true));
echo $twitter->statuses->destroy(100000);

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    try {
        $text = 'Testing PEAR Services_Twitter';
        $res1 = $twitter->statuses->update($text);
    } catch (Exception $exc) {
        $res1 = false;
        echo "failed to update status\n";
    }
    if ($res1) {
        $res2 = $twitter->statuses->destroy((int)$res1->id);
        var_dump((int)$res2->id == (int)$res1->id);
    }
} else {
    var_dump(true);
}
    

?>
--EXPECT--
POST	http://twitter.com/statuses/destroy/100000.xml	
bool(true)
