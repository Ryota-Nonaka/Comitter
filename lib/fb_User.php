<?php

namespace MyApp;

require_once('config.php');
class FBUser
{
  private $_db;

  public function __construct()
  {
    $this->_connectDB();
  }

  private function _connectDB()
  {
    try {
      $this->_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
      $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
      throw new \Exception('Failed to connect DB');
    }
  }

  public function save($accessToken, $userNode)
  {
    if ($this->_exists($userNode->getId())) {
      $user = $this->_update($accessToken, $userNode);
    } else {
      $user = $this->_insert($accessToken, $userNode);
    }
    return $user;
  }

  private function _exists($fbUserId)
  {
    $sql = sprintf("select count(*) from userdata where id=%d", $fbUserId);
    $res = $this->_db->query($sql);
    return $res->fetchColumn() === '1';
  }
  private function _insert($accessToken, $userNode)
  {
    var_dump($userNode);
    $sql = "insert into userdata (
      fb_name,
      fb_access_token,
      created,
            modified) values (
            :fb_name,
            :fb_access_token,
            now(),
            now())";
    $stmt = $this->_db->prepare($sql);
    $stmt->bindValue(':fb_name', $userNode->getName(), \PDO::PARAM_STR);
    $stmt->bindValue(':fb_access_token', $accessToken->getValue(), \PDO::PARAM_STR);

    try {
      $stmt->execute();
    } catch (\PDOException $e) {
      throw new \Exception('Failed to insert user!');
    }

    return $this->_get($userNode->getId());
  }

  private function _update($accessToken, $userNode)
  {
    $sql = "update userdata set
            fb_name = :fb_name,
    
            fb_access_token = :fb_access_token,
            modified = now()
            where id = :id";
    $stmt = $this->_db->prepare($sql);
    $stmt->bindValue(':fb_name', $userNode->getName(), \PDO::PARAM_STR);
    $stmt->bindValue(':fb_access_token', $accessToken, \PDO::PARAM_STR);

    try {
      $stmt->execute();
    } catch (\PDOException $e) {
      throw new \Exception('Failed to update user!');
    }

    return $this->_get($userNode->getId());
  }

  private function _get($fbUserId)
  {
    $sql = sprintf("select * from userdata where id=%d", $fbUserId);
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetch(\PDO::FETCH_OBJ);
    return $res;
  }
}
