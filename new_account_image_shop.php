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
    $stmt = $pdo->prepare("UPDATE shop_userdata SET shop_img =? WHERE id=?");
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

        <div class="row mr-5">
          <a href="signin_user.php">ユーザーログインはこちら</a>
        </div>
        <div class="row mr-3">
          <a href="signin_shop.php">店舗会員ログインはこちら</a>
        </div>






      </div>
    </nav>

  </header>
  <div class="container col-md-6">

    <form action="" method="post" enctype="multipart/form-data">
      <div class="form-group mt-4">
        <div class="row mt-5">
          <h1 class="mt-3">プロフィール画像を選択してください。</h1>
        </div>
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
        <button class="btn btn-primary mt-3" type="submit">プロフィール画像をアップロードする</button>
    </form>
  </div>

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