<?php



require_once(__DIR__ . '/config.php');


class Db
{
  public function dbConnect()
  {
    try {
      return new \PDO(DSN, DB_USERNAME, DB_PASSWORD, [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
      ]);
    } catch (\Exception $e) {
      echo $e->getMessage() . PHP_EOL;
    }
  }
}
