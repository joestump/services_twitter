--TEST--
utf8
--FILE--
<?php

require_once dirname(__FILE__) . '/setup.php';

$twitter  = Services_Twitter_factory('utf8', true, array(
    'format'     => 'xml',
    'raw_format' => true
));
$utf8str = 'une chaîne unicode qui sera transformée lors du second test';
echo $twitter->statuses->update($utf8str) . "\n";

$twitter  = Services_Twitter_factory('utf8', true, array(
    'format'     => 'xml',
    'raw_format' => true
));
$isoStr = utf8_decode($utf8str);
echo $twitter->statuses->update($isoStr);

?>
--EXPECTF--
<?xml version="1.0" encoding="UTF-8"?>
<status>
  %s
  <text>une cha&#238;ne unicode qui sera transform&#233;e lors du second test</text>
  %s
</status>

<?xml version="1.0" encoding="UTF-8"?>
<status>
  %s
  <text>une cha&#238;ne unicode qui sera transform&#233;e lors du second test</text>
  %s
</status>
