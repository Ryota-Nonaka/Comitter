<?php

namespace MyApp;

use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;


class Twitter
{
  private $_conn;

  public function __construct($accessToken, $accessTokenSecret)
  {
    $this->_conn = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $accessToken, $accessTokenSecret);
  }
  public function getTweets()
  {
    try {
      $tweets = $this->_conn->get('statuses/home_timeline');
    } catch (TwitterOAuthException $e) {
      echo 'Failed to load timeline';
      exit;
    }
    return $tweets;
  }

  public function getProfile()
  {
    try {
      $userInfo = $this->_conn->get('account/verify_credentials');
    } catch (TwitterOAuthException $e) {
      echo 'Failed to load profile';
      exit;
    }
    return $userInfo;
  }
}
