<?php

/**
 * Fetch the number of followers from twitter api
 *
 * @author Peter Ivanov <peter@ooyes.net>
 * @copyright    http://www.ooyes.net
 * @version    0.2
 * @link http://www.ooyes.net
 * @param string $username
 * @return string
 */
function twitter_followers_counter($username)
{
  $cache_file = CACHEDIR . 'twitter_followers_counter_' . md5($username);
  if (is_file($cache_file) == false) {
    $cache_file_time = strtotime('1984-01-11 07:15');
  } else {
    $cache_file_time = filemtime($cache_file);
  }
  $now = strtotime(date('Y-m-d H:i:s'));
  $api_call = $cache_file_time;
  $difference = $now - $api_call;
  $api_time_seconds = 1800;

  if ($difference >= $api_time_seconds) {
    $api_page = 'http://twitter.com/users/show/' . $username;
    $xml = file_get_contents($api_page);

    $profile = new SimpleXMLElement($xml);
    $count = $profile->followers_count;
    if (is_file($cache_file) == true) {
      unlink($cache_file);
    }
    touch($cache_file);
    file_put_contents($cache_file, strval($count));
    return strval($count);
  } else {
    $count = file_get_contents($cache_file);
    return strval($count);
  }
}
?>
<span style="font-weight:bold;padding:2px 5px; background:#000; color:#fff;">
  <? print twitter_followers_counter('cocoism') ?></span> followers