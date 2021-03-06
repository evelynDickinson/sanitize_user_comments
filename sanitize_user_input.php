<?php

//  php function to remove phone number and other numeric strings
// like IP addresses, email addresses, URLs, and defined array of characters
// from a string.
//
// generally useful for cleaning up user provided content

$in = "My email is: evelyn@fakedomain.net, oh and check out my website: www.logalt.net/fred/_or_bill/infectya.aspx or test.com call me at 123 554 3242.";

echo 'Calling sanitize_user_comments with: ' . $in . '<br>';
echo 'Cleaned Version: ' . sanitize_user_comments($in) . '<br>';

function sanitize_user_comments($in) {
  $out = $in;

  // Remove Phone Numbers and other number strings like IP addresses
  $phone_regexp = '!(\b\+?[0-9()\[\]./ -]{7,17}\b|\b\+?[0-9()\[\]./ -]{7,17}\s+(extension|x|#|-|code|ext)\s+[0-9]{1,6})!i';
  $out = preg_replace($phone_regexp, '', $out);

  // Remove Email Addresses
  $email_regexp = "/[^@\s]*@[^@\s]*\.[^@\s]*/";
  $out = preg_replace($email_regexp, '', $out);

  // Remove URLs
  $url_regexp = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i";
  $out = preg_replace($url_regexp, '', $out);

  // Remove non-URL link related words starting or ending with specified values
  $badWords = array('http://','https://','ftp://','file://','www.','.com','.net','.org','.de','.icu','.uk','.ru','.info','.top','.xyz','.tk','.cn','.ga','.cf','.nl');
  $outWords = explode(' ', $out);
  foreach($badWords as $badWord) {
    foreach($outWords as $index => $word) {
      if (strpos($word, $badWord) !== FALSE) {
        unset($outWords[$index]); }
    }
  }
  $out = implode(' ', $outWords);
  return $out;
}

?>
