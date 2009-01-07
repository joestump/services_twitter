--TEST--
options
--FILE--
<?php

require_once 'Services/Twitter.php';
$twitter = new Services_Twitter(null, null, array('validate' => true));

$twitter->setOption('source', 'MyRegisteredTwitterSource');
$twitter->setOptions(array(
    'format'     => 'xml',
    'raw_format' => true
));
var_dump($twitter->getOption('source'));
var_dump($twitter->getOption('foo'));
var_dump($twitter->getOptions());

class MyTwitter extends Services_Twitter {
    public function _setFooBar($value) {
        echo 'FooBar says: ' . $value . "\n";
    }
}
$twitter = new MyTwitter();
$twitter->setOption('fooBar', 'hey !');


require_once 'HTTP/Request2/Response.php';
require_once 'HTTP/Request2/Adapter/Mock.php';
$twitter = new Services_Twitter();
$resp = new HTTP_Request2_Response('HTTP/1.1 200 Success', false);
$resp->appendBody("Foo");
$mock = new HTTP_Request2_Adapter_Mock();
$mock->addResponse($resp);
$request = new HTTP_Request2();
$request->setAdapter($mock);
$twitter->setRequest($request);
echo $twitter->statuses->public_timeline() . "\n";

require_once dirname(__FILE__) . '/setup.php';
$twitter = Services_Twitter_factory('options', true, array(
    'format'     => 'xml',
    'raw_format' => 'true',
));
$status = $twitter->statuses->update('foo');
echo $status;

?>
--EXPECTF--
string(25) "MyRegisteredTwitterSource"
NULL
array(4) {
  ["format"]=>
  string(3) "xml"
  ["raw_format"]=>
  bool(true)
  ["source"]=>
  string(25) "MyRegisteredTwitterSource"
  ["validate"]=>
  bool(true)
}
FooBar says: hey !
Foo
<?xml version="1.0" encoding="UTF-8"?>
<status>
  %s
  <source>&lt;a href=&quot;http://pear.php.net/package/Services_Twitter&quot;&gt;PEAR Services_Twitter&lt;/a&gt;</source>
  %s
</status>
