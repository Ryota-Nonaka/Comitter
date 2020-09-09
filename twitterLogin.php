<?php

namespace MyApp;

use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterLogin
{
  public function login()
  {
    if ($this->isLoggedIn()) {
      goHome();
    }
    if (!isset($_GET['oauth_token']) || !isset($_GET['oauth_verifier'])) {
      $this->_redirectFlow();
    } else {
      $this->_callbackFlow();
    }
  }
  public function isLoggedIn()
  {
    return isset($_SESSION['me']) && !empty($_SESSION['me']);
  }

  private function _callbackFlow()
  {
    if ($_GET['oauth_token'] !== $_SESSION['oauth_token']) {
      throw new \Exception('invalid oauth_token');
    }
    $conn = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
    $tokens = $conn->oauth('oauth/access_token', ['oauth_verifier' => $_GET['oauth_verifier']]);

    // var_dump($tokens);

    $user = new User();
    $user->saveTokens($tokens);
    $profile= new Twitter();
    // echo "token saved";
    // exit;
    session_regenerate_id(true); //session hijack
    $_SESSION['me'] = $user->getUser($tokens['user_id']);
    unset($_SESSION['oauth_token']);
    unset($_SESSION['oauth_token_secret']);
    $_SESSION['me_followers'] = $profile->getProfile($token['followers']);

    goHome();
  }


  private function _redirectFlow()
  {
    $conn = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

    //request token
    $tokens = $conn->oauth('oauth/request_token', ['oauth_callback' => CALLBACK_URL]);

    //save token
    $_SESSION['oauth_token'] = $tokens['oauth_token'];
    $_SESSION['oauth_token_secret'] = $tokens['oauth_token_secret'];
    //redirect

    $authorizeUrl = $conn->url('oauth/authorize', ['oauth_token' => $tokens['oauth_token']]);
    header('Location: ' . $authorizeUrl);
    exit;
  }
}
