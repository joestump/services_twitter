--TEST--
Services_Twitter options
--FILE--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';
require_once 'Services/Twitter.php';

$twitter = new Services_Twitter($user, $pass, array('test' => true));
$twitter->setOption('timeout', 20);
$twitter->setOption('source', 'MyRegisteredTwitterSource');
$twitter->setOptions(array(
    'timeout'   => 30,
    'userAgent' => 'Foo'
));
var_dump($twitter->options);
echo $twitter->statuses->update('foo');

class MyTwitter extends Services_Twitter {
    public function _setFooBar($value) {
        echo 'FooBar says: ' . $value;
    }
}
$twitter = new MyTwitter($user, $pass, array('test' => true));
$twitter->setOption('fooBar', 'hey !');

?>
--EXPECT--
array(4) {
  ["timeout"]=>
  int(30)
  ["userAgent"]=>
  string(3) "Foo"
  ["test"]=>
  bool(true)
  ["source"]=>
  string(25) "MyRegisteredTwitterSource"
}
POST	http://twitter.com/statuses/update.xml	source=MyRegisteredTwitterSource&status=foo
FooBar says: hey !
