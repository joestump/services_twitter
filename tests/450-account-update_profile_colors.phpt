--TEST--
account-update-profile-colors
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

try {
    $twitter = Services_Twitter_factory('account/update_profile_colors');
    $profile = $twitter->account->update_profile_colors(array(
        'profile_background_color' => 'eee',
        'profile_text_color'       => '333333',
    ));
    var_dump(
        $profile instanceof stdclass 
     && $profile->profile_background_color == 'eee'
     && $profile->profile_text_color == '333333'
    );
} catch (Services_Twitter_Exception $exc) {
    echo $exc . "\n";
}

?>
--EXPECT--
bool(true)
