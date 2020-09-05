<?php

namespace MyApp;

class User {
  private $_db;

  public function __construct() {
    $this->_connectDB();
  }

  private function _connectDB() {
    try {
      $this->_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
      $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
      throw new \Exception('Failed to connect DB');
    }
  }

  public function save($accessToken, $userNode) {
    if ($this->_exists($userNode->getId())) {
      $user = $this->_update($accessToken, $userNode);
    } else {
      $user = $this->_insert($accessToken, $userNode);
    }
    return $user;
  }

  private function _exists($fbUserId) {
    $sql = sprintf("select count(*) from users where fb_user_id=%d", $fbUserId);
    $res = $this->_db->query($sql);
    return $res->fetchColumn() === '1';
  }

  private function _insert($accessToken, $userNode) {
    $sql = "insert into users (
            fb_user_id,
            fb_name,
            fb_link,
            fb_access_token,
            created,
            modified) values (
            :fb_user_id,
            :fb_name,
            :fb_link,
            :fb_access_token,
            now(),
            now())";
    $stmt = $this->_db->prepare($sql);
    $stmt->bindValue(':fb_user_id', (int)$userNode->getId(), \PDO::PARAM_INT);
    $stmt->bindValue(':fb_name', $userNode->getName(), \PDO::PARAM_STR);
    $stmt->bindValue(':fb_link', $userNode->getLink(), \PDO::PARAM_STR);
    $stmt->bindValue(':fb_access_token', $accessToken, \PDO::PARAM_STR);

    try {
      $stmt->execute();
    } catch (\PDOException $e) {
      throw new \Exception('Failed to insert user!');
    }

    return $this->_get($userNode->getId());
  }

  private function _update($accessToken, $userNode) {
    $sql = "update users set
            fb_name = :fb_name,
            fb_link = :fb_link,
            fb_access_token = :fb_access_token,
            modified = now()
            where fb_user_id = :fb_user_id";
    $stmt = $this->_db->prepare($sql);
    $stmt->bindValue(':fb_name', $userNode->getName(), \PDO::PARAM_STR);
    $stmt->bindValue(':fb_link', $userNode->getLink(), \PDO::PARAM_STR);
    $stmt->bindValue(':fb_access_token', $accessToken, \PDO::PARAM_STR);
    $stmt->bindValue(':fb_user_id', (int)$userNode->getId(), \PDO::PARAM_INT);

    try {
      $stmt->execute();
    } catch (\PDOException $e) {
      throw new \Exception('Failed to update user!');
    }

    return $this->_get($userNode->getId());
  }

  private function _get($fbUserId) {
    $sql = sprintf("select * from users where fb_user_id=%d", $fbUserId);
    $stmt = $this->_db->query($sql);
    $res = $stmt->fetch(\PDO::FETCH_OBJ);
    return $res;
  }
}