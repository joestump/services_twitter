--TEST--
friendships-exists
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
    $twitter = Services_Twitter_factory('friendships/exists1');
    $exists  = $twitter->friendships->exists($config['user'], $config['friend']);
    var_dump($exists);
    $twitter = Services_Twitter_factory('friendships/exists2');
    $exists  = $twitter->friendships->exists('alice', 'bob');
    var_dump($exists);
    $twitter = Services_Twitter_factory('friendships/exists3', true, array('format' => 'xml'));
    $exists  = $twitter->friendships->exists($config['user'], $config['friend']);
    var_dump($exists);
    $twitter = Services_Twitter_factory('friendships/exists4', true, array('format' => 'xml'));
    $exists  = $twitter->friendships->exists('alice', 'bob');
    var_dump($exists);
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
bool(false)
bool(true)
bool(false)
