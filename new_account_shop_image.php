<?php

require_once(__DIR__ . '/config.php');

$images = '';


if (!function_exists('imagecreatetruecolor')) {
  echo 'GD not installed';
  exit;
}

require 'Imageuploader.php';

$uploader = new \MyApp\ImageUploader();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $images = $uploader->upload();
  $images = 'uploaded_userprofile' . '/'  .  $images;
  // if (isset($_SESSION['id'])) {
  try {
    $db = new Db();
    $pdo = $db->dbConnect();
    $stmt = $pdo->prepare("UPDATE shop_userdata SET shop_img =? WHERE shop_userdata. id=?");
    $stmt->bindParam(1, $images, PDO::PARAM_STR);
    $stmt->bindParam(2, $_SESSION['login_shop_id'], PDO::PARAM_INT);
    $stmt->execute();
    $stmt->debugDumpParams();
    header('Location:created_account_shop.php');
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  // }
}

list($success, $error) = $uploader->getResults();

?>
<!doctype html>
<html lang="ja">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>

  <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo h(MAX_FILE_SIZE); ?>">
    <input type="file" name="image">
    <input type="submit" value="upload">
  </form>

  <?php if (isset($success)) : ?>
    <div class="msg success"><?php echo h($success); ?>
    <?php endif; ?>
    <?php if (isset($error)) : ?>
      <div class="msg error"><?php echo h($error); ?>
      <?php endif; ?>
      <ul>
        <li>

          <img src="<?= h($images); ?>">

        </li>

      </ul>

      </ul>

      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <script>
        $(function() {
          $('.msg').fadeOut(3000);
        });
      </script>
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>