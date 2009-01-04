--TEST--
help-downtime-schedule
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter = Services_Twitter_factory('help/downtime_schedule');
    $result  = $twitter->help->downtime_schedule();
    var_dump($result instanceof stdclass);
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
