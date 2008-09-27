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

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Services_Twitter_AllTests::main');
}

require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/Extensions/PhptTestSuite.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

/**
 * Services_Twitter phpt test suite.
 *
 * Run all tests from the package root directory:
 * $ phpunit Services_Twitter_AllTests tests/AllTests.php
 * or
 * $ php tests/AllTests.php
 *
 * @category  Services
 * @package   Services_Twitter
 * @author    Joe Stump <joe@joestump.net> 
 * @author    David Jean Louis <izimobil@gmail.com> 
 * @copyright 1997-2008 Joe Stump <joe@joestump.net> 
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/Services_Twitter
 */
class Services_Twitter_AllTests
{
    /**
     * Runs the test suite
     *
     * @return void
     * @static
     */
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    /**
     * Return the phpt test suite
     *
     * @return object the PHPUnit_Framework_TestSuite object
     * @static
     */
    public static function suite()
    {
        return new PHPUnit_Extensions_PhptTestSuite(dirname(__FILE__));
    }
}

if (PHPUnit_MAIN_METHOD == 'Services_Twitter_AllTests::main') {
    Services_GeoNames_AllTests::main();
}

?>
