<?php

require_once('config.php');

$fbLogin = new MyApp\FacebookLogin();

try {
  $fbLogin->login();
} catch (Exception $e) {
  echo $e->getMessage();
  exit;
}
