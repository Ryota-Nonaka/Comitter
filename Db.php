<?php
require 'config.php';
class Db
{
  // private const DSN = 'mysql:dbname=loginmanagement;host=localhost';
  // private const USER = 'user';
  // private const PASSWORD = "baramo0814";
  function __construct()
  {
    
  }

  public function dbConnect()
  {
    try {
      return new PDO(DSN, USER, PASSWORD);
    } catch (\Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }
  }
}
