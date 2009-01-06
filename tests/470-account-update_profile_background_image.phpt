--TEST--
account-update-profile-background-image
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter = Services_Twitter_factory('account/update_profile_background_image');
    $imgpath = dirname(__FILE__) . '/data/background.jpg';
    $profile = $twitter->account->update_profile_background_image($imgpath);
    var_dump(
        $profile instanceof stdclass 
     && preg_match('/.*background.*jpg.*/', $profile->profile_background_image_url)
    );
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
