<?php

namespace MyApp;

class Facebook
{
  private $_fb;

  public function __construct($accessToken)
  {
    $this->_fb = new \Facebook\Facebook([
      'app_id' => FB_APP_ID,
      'app_secret' => FB_APP_SECRET,
      'default_graph_version' => DEFAULT_GRAPH_VERSION,
    ]);
    $this->_fb->setDefaultAccessToken($accessToken);
  }

  public function getUserNode()
  {
    $process = function () {
      $res = $this->_fb->get('/me?fields=id,name,email,link');
      $userNode = $res->getGraphUser();
      return $userNode;
    };
    return $this->_request($process);
  }

  private function _request($process)
  {
    try {
      $res = $process();
    } catch (\Facebook\Exception\FacebookResponseException $e) {
      echo 'Response Error: ' . $e->getMessage();
      exit;
    } catch (\Facebook\Exception\FacebookSDKException $e) {
      echo 'SDK Error: ' . $e->getMessage();
      exit;
    }
    return $res;
  }

  public function getPosts()
  {
    $process = function () {
      $res = $this->_fb->get('/me/posts?limit=3');
      $body = $res->getDecodedBody();
      if (empty($body['data'])) {
        return [];
      } else {
        return $body['data'];
      }
    };
    return $this->_request($process);
  }
}
