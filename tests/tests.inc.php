<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Tests configuration file.
 *
 * PHP version 5.1.0+
 *
 * @category  Services
 * @package   Services_Twitter
 * @author    Joe Stump <joe@joestump.net> 
 * @author    David Jean Louis <izimobil@gmail.com> 
 * @copyright 1997-2008 Joe Stump <joe@joestump.net> 
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version   SVN: $Id$
 * @link      http://twitter.com/help/api
 * @link      http://twitter.com
 */

$cfgfile = dirname(__FILE__) . '/tests-config.php';
if (file_exists($cfgfile)) {
    include_once $cfgfile;
} else {
    // set dummy values for local testing
    $user          = 'test_user';
    $pass          = 'test_password';
    $aFriendOfMine = 'test_friend';
    $statusID      = 100000;
    // ensure we only test locally
    $live = false;
}
