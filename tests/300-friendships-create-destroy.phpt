--TEST--
friendships-create-destroy
--SKIPIF--
<?php

require_once dirname(__FILE__) . '/setup.php';
$twitter = Services_Twitter_factory('direct_messages/destroy_new');
if ($config['live_test'] && !$twitter->friendships->exists($config['user'], $config['friend'])) {
    echo "skip {$config['friend']} is not a friend !";
}

?>
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter    = Services_Twitter_factory('friendships/create_destroy');
    $friendship = $twitter->friendships->destroy($config['friend']);
    var_dump($friendship instanceof stdclass && isset($friendship->id));

    $twitter    = Services_Twitter_factory('friendships/create_destroy');
    $friendship = $twitter->friendships->create($config['friend']);
    var_dump($friendship instanceof stdclass && isset($friendship->id));
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
bool(true)
