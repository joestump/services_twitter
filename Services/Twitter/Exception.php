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
 * Exception raised by this package.
 *
 * @category Services
 * @package  Services_Twitter
 * @author   Joe Stump <joe@joestump.net> 
 * @author   David Jean Louis <izimobil@gmail.com> 
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://twitter.com
 * @link     http://apiwiki.twitter.com
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
     * The HTTP response returned by the API
     *
     * @var HTTP_Request2_Response $response
     */
    protected $response = '';

    // }}}
    // __construct() {{{

    /**
     * Constructor.
     *
     * @param string                 $msg  Error message
     * @param mixed                  $code Error code or parent exception
     * @param string                 $call API call that generated error
     * @param HTTP_Request2_Response $resp The HTTP response instance
     *
     * @see Services_Twitter_Exception::$call
     * @see Services_Twitter_Exception::$response
     * @link http://php.net/exceptions
     */
    public function __construct($msg = null, $code = 0, $call = null, $resp = null)
    {
        parent::__construct($msg, $code);
        $this->call     = $call;
        $this->response = $resp;
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
     * Get the API HTTP response.
     *
     * @return HTTP_Request2_Response
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
        $ret = '%s (%s)';
        if ($this->code instanceof Exception) {
            $info = $this->code->getMessage();
        } else {
            $info = 'code: ' . $this->code;
        }
        if ($this->call !== null) {
            $info .= ', call: ' . $this->call;
        }
        return sprintf($ret, $this->message, $info);
    }

    // }}}
}
