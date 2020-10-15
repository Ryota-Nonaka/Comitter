<?php

require_once(__DIR__ . '/config.php');

$images = '';
$id = '';
if (isset($_SESSION['login'])) {
  $db = new Db();
  $pdo = $db->dbConnect();
  $id = $_SESSION['id'];
  $sql = "SELECT * FROM userdata WHERE id='$id'";
  $stmt = $pdo->query($sql);
  foreach ($stmt as $row) {
    $username = $row['username'];
    $images = $row['img_path'];
  }
}
if (isset($_SESSION['me'])) {
  $db = new Db();
  $pdo = $db->dbConnect();
  $id = $_SESSION['me_id'];
  $sql = "SELECT * FROM userdata WHERE id='$id'";
  $stmt = $pdo->query($sql);
  foreach ($stmt as $row) {
    $username = $row['username'];
    $images = $row['img_path'];
  }
}


if (!function_exists('imagecreatetruecolor')) {
  echo 'GD not installed';
  exit;
}

require 'Imageuploader.php';

$uploader = new \MyApp\ImageUploader();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $images = $uploader->upload();
  list($success, $error) = $uploader->getResults();
  $images = 'uploaded_userprofile' . '/'  .  $images;


  try {
    $pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    $stmt = $pdo->prepare("UPDATE userdata SET img_path =? WHERE id='$id'");
    $stmt->bindParam(1, $images, PDO::PARAM_STR);
    $stmt->execute();
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}



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
  <header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <a class="navbar-brand" href="index.php">食バズ(仮)</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="confirm_input.php">お問い合わせ</a>
          </li>
        </ul>


        <?php
        if (isset($_SESSION['login'])) : ?>
          <div class=text-light> ようこそ、<span class="text-primary"> <?= $username ?> </span>さん！</div>
          <a href="mypage_user.php?id=<?php $id; ?>">マイページへ</a>
        <?php elseif (isset($_SESSION['me'])) : ?>
          <div class=text-light> ようこそ、<span class="text-primary"> <?= $username ?> </span>さん！</div>
          <a href="mypage_user.php?id=<?= $id ?>">マイページへ</a>
        <?php else : ?>
          <a href="signin_user.php">ユーザーログインはこちら</a>
          <a href="signin_shop.php">店舗会員ログインはこちら</a>
        <?php endif; ?>







      </div>
    </nav>

  </header>
  </br>
  </br>
  </br>

  <div class="container col-md-6">

    <form action="" method="post" enctype="multipart/form-data">
      <div class="form-group mt-3">
        <label>プロフィール画像</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo h(MAX_FILE_SIZE); ?>">
        <div class="input-group row p-0 m-0">
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="inputGroupFile" aria-describedby="inputGroupFileAddon" name="image" required>
            <label class="custom-file-label" for="inputGroupFile03"></label>
          </div>
          <div class="input-group-append">
            <button type="button" class="btn btn-outline-secondary input-group-text" id="inputFileReset">取消</button>
          </div>
        </div>
      </div>
      <div class="row justify-content-md-center">
        <img class="img-thumbnail mt-5 mb-5 rounded-circle" width="1200" height="600" src="<?= h($images); ?>" width="100px">
      </div>
      <?php if (isset($success)) : ?>
        <h5><?= h($success); ?></h5>
      <?php endif; ?>
      <?php if (isset($error)) : ?>
        <h5><?= h($error); ?></h5>
      <?php endif; ?>
      </br>
      </br>
      <div class="row">
        <button class="btn btn-primary mt-3" type="submit">変更を適用する</button>
    </form>
  </div>
  <div class="row mt-3">
    <a class="btn btn-secondary" role="button" href="mypage_user.php?id=<?= $id; ?>">マイページへ戻る</a>
  </div>
  </div>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->



  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
  <script>
    bsCustomFileInput.init();

    document.getElementById('inputFileReset').addEventListener('click', function() {

      bsCustomFileInput.destroy();

      var elem = document.getElementById('inputFile');
      elem.value = '';
      var clone = elem.cloneNode(false);
      elem.parentNode.replaceChild(clone, elem);

      bsCustomFileInput.init();

    });
  </script>
</body>

</html>