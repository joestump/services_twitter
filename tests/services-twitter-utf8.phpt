--TEST--
Services_Twitter utf8
--FILE--
<?php

require_once dirname(__FILE__) . '/tests.inc.php';
require_once 'Services/Twitter.php';

$twitter  = new Services_Twitter($user, $pass, array('test' => true));
$utf8str1 = 'Stop war: Peace Paix Pace سلام שלום Hasîtî Barış 和平 Мир';
$utf8str2 = 'cette chaîne est transformée en iso-8859-1';
$isoStr   = utf8_decode($utf8str2);
echo $twitter->statuses->update($utf8str1);
echo $twitter->statuses->update($utf8str2);

// this allows for testing live against the service, or locally
if (isset($live) && $live == true) {
    // live test that must evaluate to bool(true)
    $twitter = new Services_Twitter($user, $pass);
    $res1    = $twitter->statuses->update($utf8str1);
    $res2    = $twitter->statuses->update($utf8str2);
    var_dump((string)$res1->text === $utf8str1 && 
             (string)$res2->text === $utf8str2);
} else {
    var_dump(true);
}

?>
--EXPECT--
POST	http://twitter.com/statuses/update.xml	status=Stop+war%3A+Peace+Paix+Pace+%D8%B3%D9%84%D8%A7%D9%85+%D7%A9%D7%9C%D7%95%D7%9D+Has%C3%AEt%C3%AE+Bar%C4%B1%C5%9F+%E5%92%8C%E5%B9%B3+%D0%9C%D0%B8%D1%80
POST	http://twitter.com/statuses/update.xml	status=cette+cha%C3%AEne+est+transform%C3%A9e+en+iso-8859-1
bool(true)
