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

require_once 'Services/Twitter/Exception.php';

/**
 * Services_Twitter.
 *
 * <code>
 * require_once 'Services/Twitter.php';
 *
 * $username = 'Your_Username';
 * $password = 'Your_Password';
 *
 * try {
 *     $twitter = new Services_Twitter($username, $password);
 *     $msg = $twitter->statuses->update("I'm coding with PEAR right now!");
 *     print_r($msg); // Should be a SimpleXMLElement structure
 * } catch (Services_Twitter_Exception $e) {
 *     echo $e->getMessage(); 
 * }
 * </code>
 *
 * @category Services
 * @package  Services_Twitter
 * @author   Joe Stump <joe@joestump.net> 
 * @author   David Jean Louis <izimobil@gmail.com> 
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://twitter.com
 * @link     http://apiwiki.twitter.com
 */
class Services_Twitter
{
    // constants {{{

    /**#@+
     * Exception codes constants defined by this package.
     *
     * @global integer ERROR_UNKNOWN  An unknown error occurred
     * @global integer ERROR_ENDPOINT Bad endpoint
     * @global integer ERROR_PARAMS   Bad endpoint parameters
     */
    const ERROR_UNKNOWN  = 1;
    const ERROR_ENDPOINT = 2;
    const ERROR_PARAMS   = 3;
    /**#@-*/

    /**#@+
     * Twitter API error codes from
     * {@link http://apiwiki.twitter.com/REST+API+Documentation#HTTPStatusCodes}
     *
     * @global integer ERROR_REQUEST     Bad request sent
     * @global integer ERROR_AUTH        Not authorized to do action
     * @global integer ERROR_FORBIDDEN   Forbidden from doing action
     * @global integer ERROR_NOT_FOUND   Item requested not found
     * @global integer ERROR_INTERNAL    Internal Twitter error
     * @global integer ERROR_DOWN        Twitter is down
     * @global integer ERROR_UNAVAILABLE API is overloaded
     */
    const ERROR_REQUEST     = 400;
    const ERROR_AUTH        = 401;
    const ERROR_FORBIDDEN   = 403;
    const ERROR_NOT_FOUND   = 404;
    const ERROR_INTERNAL    = 500;
    const ERROR_DOWN        = 502;
    const ERROR_UNAVAILABLE = 503;
    /**#@-*/

    // }}}
    // properties {{{

    /**
     * Public URI of Twitter's API
     *
     * @var string $uri URI of Twitter API
     */
    public static $uri = 'http://twitter.com';

    /**
     * Username of Twitter user
     *
     * @var string $user Twitter username
     * @see Services_Twitter::__construct()
     */
    protected $user = '';

    /**
     * Password of Twitter user
     *
     * @var string $pass User's password for Twitter
     * @see Services_Twitter::__construct()
     */
    protected $pass = '';

    /**
     * Options for HTTP requests and misc.
     *
     * Available options are:
     * - timeout: the http request timeout in seconds;
     * - userAgent: the user agent name to pass with the request;
     * - test: whether to use the test mode, in test mode requests are not sent 
     *   to the server, they are only printed out to stdout;
     * - source: you can set this if you have registered a twitter source 
     *   {@see http://twitter.com/help/request_source}, your source will be 
     *   passed with each POST request.
     *
     * These options can be set either by passing them directly to the 
     * constructor as an array (3rd parameter), or by using the setOption() or 
     * setOptions() methods.
     *
     * @var array $options
     * @see Services_Twitter::__construct()
     * @see Services_Twitter::setOption()
     * @see Services_Twitter::setOptions()
     */
    protected $options = array(
        'timeout'   => 30,
        'userAgent' => 'Services_Twitter @package_version@',
        'test'      => false,
        'source'    => null
    );

    /**
     * The Twitter API mapping array, used internally to retrieve infos about 
     * the API categories, endpoints, parameters, etc...
     * The mapping is constructed with the api.xml file present in the 
     * Services_Twitter data directory.
     *
     * @var array $api Twitter api array
     * @see Services_Twitter::__construct()
     * @see Services_Twitter::prepareRequest()
     */
    protected $api = array();

    /**
     * Used internally by the __get() and __call() methods to identify the
     * current call.
     *
     * @var string $currentCategory 
     * @see Services_Twitter::__get()
     * @see Services_Twitter::__call()
     */
    protected $currentCategory = null;

    // }}}
    // __construct() {{{

    /**
     * Constructor.
     *
     * @param string $user    Twitter username
     * @param string $pass    Twitter password
     * @param array  $options An array of options
     *
     * @return void
     */
    public function __construct($user = null, $pass = null, $options = array())
    {
        // set properties and options
        $this->user = $user;
        $this->pass = $pass;
        foreach ($options as $option => $value) {
            if (array_key_exists($option, $this->options)) {
                $this->options[$option] = $value;
            }
        }

        // initialize xml mapping
        if (is_dir('@data_dir@')) {
            $d = implode(DIRECTORY_SEPARATOR, 
                array('@data_dir@', 'Services_Twitter', 'data'));
        } else {
            $d = implode(DIRECTORY_SEPARATOR,
                array(dirname(__FILE__), '..', 'data'));
        }
        $d .= DIRECTORY_SEPARATOR;
        if (isset($options['test']) && class_exists('DomDocument')) {
            // this should be done only when testing
            $doc = new DomDocument();
            $doc->load($d . 'api.xml');
            $doc->relaxNGValidate($d . 'api.rng');
        }
        $xmlApi = simplexml_load_file($d . 'api.xml');
        foreach ($xmlApi->category as $category) {
            $catName             = (string)$category['name'];
            $this->api[$catName] = array();
            foreach ($category->endpoint as $endpoint) {
                $this->api[$catName][(string)$endpoint['name']] = $endpoint;
            }
        }
    }

    // }}}
    // __get() {{{

    /**
     * Get interceptor, if the requested property is "options", it just return 
     * the options array, otherwise, if the property matches a valid API 
     * category it return an instance of this class.
     *
     * @param string $property The property of the call
     *
     * @return mixed 
     */
    public function __get($property)
    {
        if ($this->currentCategory === null) {
            if ($property == 'options') {
                return $this->options;
            }
            if (isset($this->api[$property])) {
                $this->currentCategory = $property;
                return $this;
            }
        } else {
            $this->currentCategory = null;
        }
        throw new Services_Twitter_Exception(
            'Unsupported endpoint ' . $property,
            self::ERROR_ENDPOINT
        );
    }

    // }}}
    // __call() {{{

    /**
     * Overloaded call for API passthrough.
     * 
     * @param string $endpoint API endpoint being called
     * @param array  $args     $args[0] is an array of GET/POST arguments
     * 
     * @return object Instance of SimpleXMLElement
     */
    public function __call($endpoint, array $args = array())
    {
        if ($this->currentCategory !== null) {
            if (!isset($this->api[$this->currentCategory][$endpoint])) {
                throw new Services_Twitter_Exception(
                    'Unsupported endpoint ' 
                    . $this->currentCategory . '/' . $endpoint,
                    self::ERROR_ENDPOINT
                );
            }
            // case of a classic "category->endpoint()" call
            $ep = $this->api[$this->currentCategory][$endpoint]; 
        } else if (isset($this->api[$endpoint][$endpoint])) {
            // case of a "root" endpoint call, the method is the name of the 
            // category (ex: $twitter->direct_messages())
            $ep = $this->api[$endpoint][$endpoint];
        } else {
            throw new Services_Twitter_Exception(
                'Unsupported endpoint ' . $endpoint,
                self::ERROR_ENDPOINT
            );
        }
        // we must reset the current category to null for future calls.
        $cat                   = $this->currentCategory;
        $this->currentCategory = null;

        list($url, $params, $method) = $this->prepareRequest($ep, $args, $cat);
        return $this->sendRequest($url, $params, $method);
    }

    // }}}
    // setOption() {{{

    /**
     * Set an option in {@link Services_Twitter::$options}
     *
     * If a function exists named _set$option (e.g. _setUserAgent()) then that
     * method will be used instead. Otherwise, the value is set directly into
     * the options array.
     *
     * @param string $option Name of option
     * @param mixed  $value  Value of option
     *
     * @return void
     * @see Services_Twitter::$options
     */
    public function setOption($option, $value)
    {
        $func = '_set' . ucfirst($option);
        if (method_exists($this, $func)) {
            $this->$func($value);
        } else {
            $this->options[$option] = $value;
        } 
    }

    // }}}
    // setOptions() {{{

    /**
     * Set a number of options at once in {@link Services_Twitter::$options}
     *
     * @param array $options Associative array of options name/value
     *
     * @return void
     * @see Services_Twitter::$options
     * @see Services_Twitter::setOption()
     */
    public function setOptions(array $options)
    {
        foreach ($options as $option => $value) {
            $this->setOption($option, $value);
        }
    }

    // }}}
    // prepareRequest() {{{

    /**
     * Prepare the request before it is sent.
     *
     * @param SimpleXMLElement $endpoint API endpoint xml node
     * @param array            $args     API endpoint arguments
     * @param string           $cat      The current category
     *
     * @throws Services_Twitter_Exception
     * @return array The array of arguments to pass to in the request
     */
    protected function prepareRequest($endpoint, array $args = array(), $cat = null)
    {
        $params = array();
        $path   = '/';
        if ($cat !== null) {
            $path .= $cat . '/';
        }
        $path  .= (string)$endpoint['name'];
        $method = (string)$endpoint['method'];
        if ($method == 'POST' && $this->options['source'] !== null) {
            // we have a POST method and a registered source to pass
            $params['source'] = $this->options['source'];
        }
        $xpath           = 'param[@required="true" or @required="1"]';
        $hasRequiredArgs = count($endpoint->xpath($xpath));
        if (!$hasRequiredArgs && (isset($args[0]) && !is_array($args[0]))) {
            throw new Services_Twitter_Exception(
                $path . ' expects an array as unique parameter',
                self::ERROR_PARAMS
            );
        }
        foreach ($endpoint->param as $param) {
            $pName      = (string)$param['name'];
            $pType      = (string)$param['type'];
            $pMaxLength = (int)$param['max_length'];
            $pMaxLength = $pMaxLength > 0 ? $pMaxLength : null;
            $pReq       = (string)$param['required'] == 'true';
            if ($pReq) {
                $arg = array_shift($args);
            } else if (isset($args[0][$pName])) {
                $arg = $args[0][$pName];
            } else {
                continue;
            }
            if ($path == '/users/show' && strpos($arg, '@') !== false) {
                // XXX fixes Twitter API inconsistency in /users/show endpoint
                $params['email'] = $arg;
                continue;
            }
            try {
                $this->validateArg($pName, $arg, $pReq, $pType, $pMaxLength);
            } catch (Exception $exc) {
                throw new Services_Twitter_Exception(
                    $path . ': ' . $exc->getMessage(),
                    self::ERROR_PARAMS
                );
            }
            if ($pName == 'id') {
                $path .= '/' . $arg;
            } else {
                $params[$pName] = $arg;
            }
        }

        $uri = self::$uri . $path . '.xml';
        return array($uri, $params, $method);
    }

    // }}}
    // validateArg() {{{

    /**
     * Check the validity of an argument (required, max length, type...).
     *
     * @param array $name      The argument name
     * @param array &$val      The argument value, passed by reference
     * @param bool  $req       Whether the argument is required or not
     * @param array $type      The argument type
     * @param array $maxLength The argument maximum length (optional)
     *
     * @throws Services_Twitter_Exception
     * @return void
     */
    protected function validateArg($name, &$val, $req, $type, $maxLength = null)
    {
        // check if required arg
        if ($req && $val === null) {
            throw new Services_Twitter_Exception(
                $name . ' is required', self::ERROR_PARAMS
            );
        }

        // check length if necessary
        if ($maxLength !== null && strlen($val) > $maxLength) {
            throw new Exception(
                $name . ' must not exceed ' . $maxLength . ' chars',
                self::ERROR_PARAMS
            );
        }

        // type checks
        $msg = null;
        switch ($type) {
        case 'boolean':
            if (!is_bool($val)) {
                $msg = $name . ' must be a boolean';
            }
            // we modify the value by reference
            $val = $val ? 'true' : 'false';
            break;
        case 'integer':
            if (!is_numeric($val)) {
                $msg = $name . ' must be an integer';
            }
            break;
        case 'string':
            if (!is_string($val)) {
                $msg = $name . ' must be a string';
            }
            break;
        case 'date':
            if (is_numeric($val)) {
                // we have a timestamp
                $val = date('r', $val);
            } else {
                $rx = '/^\w+,\s+\d+\s+\w+\s+\d+\s+\d+:\d+:\d+.+$/';
                if (!preg_match($rx, $val)) {
                    $msg = $name . ' must be an HTTP-formatted date '
                         . '(ex: Tue, 27 Mar 2007 22:55:48 GMT)';
                }
            }
            break;
        case 'id_or_screenname':
            if (!preg_match('/^[a-z0-9_]+$/', $val)) {
                $msg = $name . ' must be a valid id or screen name';
            }
            break;
        case 'device':
            $devices = array('none', 'sms', 'im');
            if (!in_array($val, $devices)) {
                $msg = $name . ' must be one of the following: ' 
                     . implode(', ', $devices);
            }
            break;
        }
        if ($msg !== null) {
            throw new Services_Twitter_Exception($msg, self::ERROR_PARAMS);
        }
    }

    // }}}
    // sendRequest() {{{

    /**
     * Send a request to the Twitter API.
     *
     * @param string $uri    The full URI to the API endpoint
     * @param array  $args   The API endpoint arguments to pass
     * @param array  $method The HTTP request method (GET or POST)
     *
     * @throws Services_Twitter_Exception
     * @return object Instance of SimpleXMLElement 
     */
    protected function sendRequest($uri, array $args = array(), $method = 'GET')
    {
        $sets = array();
        foreach ($args as $key => $val) {
            $sets[] = $key . '=' . urlencode(utf8_encode($val));
        }
        if ($this->options['test']) {
            return sprintf("%s\t%s\t%s\n", $method, $uri, implode('&', $sets));
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->options['userAgent']);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_USERPWD, $this->user . ':' . $this->pass);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->options['timeout']);

        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, implode('&', $sets));
        } else {
            if (count($sets)) {
                $uri .= '?' . implode('&', $sets);
            }
        }

        curl_setopt($ch, CURLOPT_URL, $uri);
        $res = trim(curl_exec($ch));

        $err = curl_errno($ch);
        if ($err !== CURLE_OK) {
            throw new Services_Twitter_Exception(curl_error($ch), $err, $uri);
        }

        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (substr($code, 0, 1) != '2') {
            $xml = @simplexml_load_string($res);
            if ($xml instanceof SimpleXMLElement && isset($xml->error)) {
                throw new Services_Twitter_Exception(
                    (string)$xml->error, $code, $uri
                );
            }
            throw new Services_Twitter_Exception(
                'Unexpected HTTP status returned from API',
                Services_Twitter::ERROR_UNKNOWN, $uri
            );
        }

        curl_close($ch);

        if (!strlen($res)) {
            throw new Services_Twitter_Exception(
                'Empty response was received from API', 
                Services_Twitter::ERROR_UNKNOWN, $uri
            );
        }

        $xml = @simplexml_load_string($res);
        if (!$xml instanceof SimpleXMLElement) {
            throw new Services_Twitter_Exception(
                'Could not parse response received from API', 
                Services_Twitter::ERROR_UNKNOWN, $uri, $res
            );
        }

        return $xml;
    }

    // }}}
}
