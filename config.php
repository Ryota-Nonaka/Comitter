<?php
ini_set('display_errors', 1);

require_once(__DIR__ . '\twitteroauth-main\autoload.php');

define('CONSUMER_KEY', 'mliv2TvmcNdH6U7XttmGCQwsW');
define('CONSUMER_SECRET', 'qSXvkclZapRVgR2cz77nwwhpGiQLS5uiA8VtpdsOvOIAmO8k3o');
define('CALLBACK_URL', 'http://localhost/portforio/login.php');

define('MAX_FILE_SIZE', 1 * 1024 * 1024); // 1MB
define('THUMBNAIL_WIDTH', 400);
define('IMAGES_DIR', __DIR__ . '\uploaded_userprofile');
define('THUMBNAIL_DIR', __DIR__ . '\thumbs');

define('DSN', 'mysql:host=localhost;dbname=application_management;charset=utf8mb4');
define('DB_USERNAME', 'user');
define('DB_PASSWORD', 'baramo0814');


session_start();

require_once(__DIR__ . '\autoload.php');
require_once(__DIR__ . '\function.php');
require_once(__DIR__ . '\Db.php');
