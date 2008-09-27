<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * An interface for Twitter's HTTP API
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
 * @link      http://twitter.com
 * @link      http://apiwiki.twitter.com
 * @filesource
 */

require_once 'PEAR/Exception.php';

/**
 * Services_Twitter_Exception
 *
 * @category Services
 * @package  Services_Twitter
 * @author   Joe Stump <joe@joestump.net> 
 * @author   David Jean Louis <izimobil@gmail.com> 
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://twitter.com
 */
class Services_Twitter_Exception extends PEAR_Exception
{
    // properties {{{

    /**
     * Call to the API that created the error
     *
     * @var string $call 
     */
    protected $call = '';

    /**
     * The raw response returned by the API
     *
     * @var string $response
     */
    protected $response = '';

    // }}}
    // __construct() {{{

    /**
     * Constructor
     *
     * @param string  $message  Error message
     * @param integer $code     Error code
     * @param string  $call     API call that generated error
     * @param string  $response The raw response that produced the erorr
     *
     * @see Services_Twitter_Exception::$call
     * @link http://php.net/exceptions
     */
    public function __construct($message = null, 
                                $code = 0, 
                                $call = '',
                                $response = '') 
    {
        parent::__construct($message, $code);
        $this->call     = $call;
        $this->response = $response;
    }

    // }}}
    // getCall() {{{

    /**
     * Return API call
     *
     * @return string
     * @see Services_Twitter_Exception::$call
     */
    public function getCall()
    {
        return $this->call;
    }

    // }}}
    // getResponse() {{{

    /**
     * Get the raw API response that died   
     *
     * @return string
     * @see Services_Twitter_Exception::$response
     */
    public function getResponse()
    {
        return $this->response;
    }

    // }}}
    // __toString() {{{

    /**
     * __toString
     *
     * Overload PEAR_Exception's horrible __toString implementation.
     *
     * @return      string
     */
    public function __toString()
    {
        return $this->message . ' (Code: ' . $this->code . ', Call: ' . 
               $this->call . ')';
    }

    // }}}
}
