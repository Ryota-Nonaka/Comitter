<?php

require_once(__DIR__ . '/config.php');



if (isset($_SESSION['login'])) {


  $db = new Db();
  $pdo = $db->dbConnect();
  $id = $_SESSION['id'];
  $sql = "SELECT * FROM userdata WHERE id='$id'";
  $stmt = $pdo->query($sql);
  foreach ($stmt as $row) {
    $profile_img = $row['img_path'];
    // var_dump($profile_img);
  }
}

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
  // var_dump($images);
  // if (isset($_SESSION['id'])) {
  try {
    $pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    $stmt = $pdo->prepare("UPDATE userdata SET img_path =? WHERE userdata. id=?");
    $stmt->bindParam(1, $images, PDO::PARAM_STR);
    $stmt->bindParam(2, $_SESSION['id'], PDO::PARAM_INT);
    $stmt->execute();
    $stmt->debugDumpParams();
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

        <!-- 切り替えボタンの設定 -->
        <?php


        if (isset($_SESSION['login'])) : ?>
          <div class=text-light> ようこそ、<span class="text-primary"> <?= $_SESSION['login'] ?> </span>さん！</div>
          <a href='mypage.php'>マイページへ</a>
        <?php elseif (isset($_SESSION['me'])) : ?>
          <div class=text-light> ようこそ、<span class="text-primary"> <?= $userInfo->name ?> </span>さん！</div>
          <a href='mypage.php'>マイページへ</a>
        <?php else : ?>
          <a href='signin_user.php'>ユーザーログインはこちら</a>
          <a href='signin_shop.php'>店舗会員ログインはこちら</a>
        <?php endif; ?>




      </div>
    </nav>

  </header>

  <!-- モーダルの設定 -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>ログイン</p>
        </div>
        <div class="modal-footer">
          <a class="btn btn-lg btn-primary nav-link" href="signin.php" role="button">ログイン画面</a>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる
            </button>
            <!-- <button type="button" class="btn btn-primary">変更を保存</button> -->
          </div><!-- /.modal-footer -->
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
  </div>
  </br>
  <h1 class="contact-title">プロフィール画像編集画面</h1>
  <div class="container-fluid col-md-3">
    <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo h(MAX_FILE_SIZE); ?>">
      <?php if (isset($_POST['update_image'])) : ?>
        <img src="<?= $images; ?>">
      <?php else : ?>
        <img src="<?= h($profile_img); ?>">
      <?php endif; ?>

      <?php if (isset($success)) : ?>
        <div class="msg success">
          <h1><?php echo h($success); ?></h1>
        <?php endif; ?>
        <?php if (isset($error)) : ?>
          <div class="msg error"><?php echo h($error); ?>
          <?php endif; ?>



          </br>
          <div class="input-group row">
            <div class="custom-file col-mb-3">
              <input type="file" class="custom-file-input" name="image">
              <label class="custom-file-label" for="inputGroupFile01">ファイルを選択</label>
              <!-- <label class="custom-file-label" for="inputGroupFile04">Choose file</label> -->
            </div>
            <!-- <div class="input-group-append">
              </div> -->
          </div>
          </br>

          <button class="btn btn-primary" type="submit" value="upload" name="update_image">画像を変更する</button>

          </div>
    </form>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
      $(function() {
        $('.msg').fadeOut(3000);
        $('#my_file').on('change', function() {
          $('#my_form').submit();
        });
      });
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>