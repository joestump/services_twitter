--TEST--
users-show
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter = Services_Twitter_factory('users/show');
    $user    = $twitter->users->show(array('id' => $config['friend']));
    var_dump($user instanceof stdclass && is_int($user->id));
    $twitter = Services_Twitter_factory('users/show');
    $user    = $twitter->users->show(array('id' => $config['email']));
    var_dump($user instanceof stdclass && is_int($user->id));
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
bool(true)
