--TEST--
direct-messages-new-destroy
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
    $twitter = Services_Twitter_factory('direct_messages/destroy_new');
    $message = $twitter->direct_messages->new(
        $config['friend'],
        'testing services_twitter...'
    );
    var_dump($message instanceof stdclass && isset($message->id));

    $twitter = Services_Twitter_factory('direct_messages/destroy_new');
    $message = $twitter->direct_messages->destroy($message->id);
    var_dump($message instanceof stdclass && isset($message->id));
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
bool(true)
