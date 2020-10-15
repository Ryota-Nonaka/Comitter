<?php

require_once(__DIR__ . '/config.php');

$name = $_GET['shop_name'];
$db = new Db();
$pdo = $db->dbConnect();
$sql = $pdo->prepare("SELECT * FROM shop_userdata WHERE shop_name='$name'");
$sql->execute();
foreach ($sql as $row) {
  $id = $row['id'];
  $username = $row['shop_name'];
  $location = $row['shop_pref'];
  $open = $row['business_hour_open'];
  $close = $row['business_hour_close'];
  $regular_holiday = $row['regular_holiday'];
  $shop_img = $row['shop_img'];
  $shop_url = $row['shop_url'];
}


$jobs_info = array();
try {
  $db = new Db();
  $pdo = $db->dbConnect();
  $sql = $pdo->prepare("SELECT * FROM job WHERE shop_id='$id'");
  $sql->execute();

  foreach ($sql as $row) {
    array_push($jobs_info, $row);
  }
} catch (PDOException $e) {
  $errorMessage = 'データベースエラー';
  echo $e->getMessage();
}









?>
<!doctype html>
<html lang="ja">


<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="stylesheet" href="src\css\mypage.css">
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
          <div class=text-light> ようこそ、<span class="text-primary"> <?= $_SESSION['login'] ?> </span>さん！</div>
          <a href="mypage_user.php?id=<?php echo ($_SESSION['id']); ?>">マイページへ</a>
        <?php elseif (isset($_SESSION['me'])) : ?>
          <div class=text-light> ようこそ、<span class="text-primary"> <?= $_SESSION['me']->username ?> </span>さん！</div>
          <a href="mypage_user.php?id=<?= $_SESSION['me_id'] ?>">マイページへ</a>
        <?php elseif (isset($_SESSION['login_shop'])) : ?>
          <div class="text-light"> ようこそ、<span class="text-primary"><?= $_SESSION['login_shop'] ?> </span>さん！</div>
          <a href="mypage_shop.php?shop_name=<?php echo ($_SESSION['login_shop']); ?>">マイページへ</a>
        <?php else : ?>
          <div class="row mr-5">
            <a href="signin_user.php">ユーザーログインはこちら</a>
          </div>
          <div class="row mr-3">
            <a href="signin_shop.php">店舗会員ログインはこちら</a>
          </div>
        <?php endif; ?>







      </div>
    </nav>

  </header>



  <div class="container-fluid m-0 text-center about-contents" id="about-contents">
    </br>
    <?php if (isset($_SESSION['login_shop'])) : ?>
      <div class="row justify-content-start">
        <a class="btn btn-primary" href="profile_edit_image_shop.php" role="button">プロフィール画像を変更する</a>
      </div>
      </br>
      <div class="row justify-content-start">
        <a class="btn btn-primary" href="profile_edit_shop.php" role="button">プロフィール編集画面へ</a>
      </div>
      </br>
      <div class="row justify-content-start">
        <a class="btn btn-primary" href="job_input.php" role="button">依頼を投稿する</a>
      </div>
      </br>
      <div class="row justify-content-start">
        <a class="btn btn-primary" href="job_confirm.php?id=<?= $id ?>" role="button">依頼を確認する</a>
      </div>
      </br>
      <div class="row justify-content-start">
        <a class="btn btn-primary" href="complete_confirm.php?id=<?= $id ?>" role="button">報告ツイートを確認する</a>
      </div>
      </br>
      <div class="row justify-content-start">
        <a class="btn btn-primary" href="job_complete_shop.php?id=<?= $id ?>" role="button">アーカイブを確認する</a>
      </div>
    <?php endif; ?>
    <h1>proflile</h1>
    <img class="img-thumbnail mt-5 mb-5 rounded-circle" width="1200" height="600" src="<?= h($shop_img);
                                                                                        ?>" width="100px">
    <div class="row">
      <div class="col-lg-3 col-sm-6">
        <div class="about-text">
          <h3>Username</h3>
          <p> <?= $username;
              ?></p>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="about-text">
          <h3>Location</h3>
          <p><?= $location;
              ?></p>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="about-text">
          <h3>営業時間</h3>
          <p><?= $open . '~' . $close;
              ?></p>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="about-text">
          <h3>定休日</h3>
          <p><?= $regular_holiday;
              ?></p>
        </div>
      </div>
    </div>
    </br>

    <div class="col-lg-3 col-sm-6">
      <div class="about-text">
        <h3>お店のurl</h3>
        <a href="<?= $shop_url ?>">
          <?= $shop_url;
          ?></a>
      </div>
    </div>
    <?php if (isset($_SESSION['login_shop'])) : ?>
      <a class="btn btn-danger" href="logout_shop.php" value="logout">ログアウトする</a>
    <?php endif; ?>
  </div>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>

</html>