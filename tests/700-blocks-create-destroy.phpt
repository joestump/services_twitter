--TEST--
blocks-create-destroy
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter = Services_Twitter_factory('blocks/create_destroy');
    $result  = $twitter->blocks->create($config['friend']);
    var_dump($result instanceof stdclass && isset($result->id));

    $twitter = Services_Twitter_factory('blocks/create_destroy');
    $result  = $twitter->blocks->destroy($config['friend']);
    var_dump($result instanceof stdclass && isset($result->id));
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
bool(true)
