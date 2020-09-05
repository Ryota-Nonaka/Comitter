<?php

namespace MyApp;

class FacebookLogin
{
  private $_fb;

  public function __construct()
  {
    $this->_fb = new \Facebook\Facebook([
      'app_id' => FB_APP_ID,
      'app_secret' => FB_APP_SECRET,
      'default_graph_version' => DEFAULT_GRAPH_VERSION,
    ]);
  }

  public function isLoggedIn()
  {
    return isset($_SESSION['fb']) && !empty($_SESSION['fb']);
  }

  public function login()
  {
    if ($this->isLoggedIn()) {
      goHome();
    }

    $helper = $this->_fb->getRedirectLoginHelper();

    // get access token
    try {
      $accessToken = $helper->getAccessToken();
    } catch (\Facebook\Exception\FacebookResponseException $e) {
      echo 'Response Error: ' . $e->getMessage();
      exit;
    } catch (\Facebook\Exception\FacebookSDKException $e) {
      echo 'SDK Error: ' . $e->getMessage();
      exit;
    }

    if (isset($accessToken)) {
      // save user
      var_dump($accessToken);

      if (!$accessToken->isLongLived()) {
        try {
          $accessToken = $this->_fb->getOAuth2Client()->getLongLivedAccessToken($accessToken);
        } catch (\Facebook\Exception\FacebookSDKException $e) {
          echo 'LongLived Access Token Error: ' . $e->getMessage();
          exit;
        }
      }

      // var_dump($accessToken->isLongLived());
      // exit;

      $this->_save($accessToken);
      goHome();
    } elseif ($helper->getError()) {
      goHome();
    } else {
      $permissions = ['email', 'public_profile', 'user_posts'];
      $loginUrl = $helper->getLoginUrl(CALLBACK_URL, $permissions);
      header('Location: ' . $loginUrl);
    }
    exit;
  }

  private function _save($accessToken)
  {
    // get user info
    $fb = new Facebook($accessToken);
    $userNode = $fb->getUserNode();
    // var_dump($userNode); exit;

    // save user
    $user = new User();
    $me = $user->save($accessToken, $userNode);
    // var_dump($me);
    // exit;

    // login
    session_regenerate_id(true); // session hijack
    $_SESSION['me'] = $me;
  }
}
