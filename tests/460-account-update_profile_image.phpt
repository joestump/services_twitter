--TEST--
account-update-profile-image
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter = Services_Twitter_factory('account/update_profile_image');
    $imgpath = dirname(__FILE__) . '/data/profile.png';
    $profile = $twitter->account->update_profile_image($imgpath);
    var_dump(
        $profile instanceof stdclass 
     && preg_match('/.*profile.*png.*/', $profile->profile_image_url)
    );
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
