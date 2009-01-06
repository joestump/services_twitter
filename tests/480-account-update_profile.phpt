--TEST--
account-update-profile
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter = Services_Twitter_factory('account/update_profile');
    $profile = $twitter->account->update_profile(array(
        'location' => 'somewhere in france...',
        'url'      => 'http://www.example.com',
    ));
    var_dump(
        $profile instanceof stdclass 
     && $profile->location == 'somewhere in france...'
     && $profile->url == 'http://www.example.com'
    );
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
