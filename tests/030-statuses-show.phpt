--TEST--
statuses-show
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter = Services_Twitter_factory('statuses/show');
    $status  = $twitter->statuses->show($config['status_id']);
    var_dump($status instanceof stdclass && isset($status->id));
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
