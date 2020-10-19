<?php

require_once(__DIR__ . '/config.php');


$id = $_GET['id'];
$userInfo = array();
if (isset($_SESSION['me']) && isset($_SESSION['login'])) {
  $twitterLogin = new MyApp\TwitterLogin();
  $me = $_SESSION['me'];
  $twitter = new MyApp\Twitter($me->tw_access_token, $me->tw_access_token_secret);
  MyApp\Token::create();
  $userInfo = $twitter->getProfile();
  $followers = $userInfo->followers_count;
  $friends = $userInfo->friends_count;
  try {
    $db = new Db();
    $pdo = $db->dbConnect();
    $stmt = $pdo->prepare(
      "UPDATE userdata SET 
       followers_count=:followers_count,
        friends_count=:friends_count
        WHERE id='$id'"
    );
    $stmt->bindParam(':followers_count', $followers, \PDO::PARAM_STR);
    $stmt->bindParam(':friends_count', $friends, \PDO::PARAM_STR);
    $stmt->execute();
  } catch (Exception $e) {
    echo 'エラーが発生しました。:' . $e->getMessage();
  }
} else if (isset($_SESSION['me'])) {
  $twitterLogin = new MyApp\TwitterLogin();
  $me = $_SESSION['me'];

  $twitter = new MyApp\Twitter($me->tw_access_token, $me->tw_access_token_secret);
  MyApp\Token::create();
  $userInfo = $twitter->getProfile();
  $tw_username = $userInfo->name;
  $location = $userInfo->location;
  $followers = $userInfo->followers_count;
  $friends = $userInfo->friends_count;
  $images =
    $userInfo->profile_image_url;

  try {
    $db = new Db();
    $pdo = $db->dbConnect();
    $stmt = $pdo->prepare(
      "UPDATE userdata SET username=:username,
        pref=:pref,
        img_path=:img_path,
        followers_count=:followers_count,
        friends_count=:friends_count
        WHERE username IS NULL AND id='$id'"
    );
    $stmt->bindParam(':username', $tw_username, \PDO::PARAM_STR);
    $stmt->bindParam(':pref', $location, \PDO::PARAM_STR);
    $stmt->bindParam(':img_path', $images, \PDO::PARAM_STR);
    $stmt->bindParam(':followers_count', $followers, \PDO::PARAM_STR);
    $stmt->bindParam(':friends_count', $friends, \PDO::PARAM_STR);
    $stmt->execute();
  } catch (Exception $e) {
    echo 'エラーが発生しました。:' . $e->getMessage();
  }
}


$db = new Db();
$pdo = $db->dbConnect();
$sql = $pdo->prepare("SELECT * FROM userdata WHERE id='$id'");
$sql->execute();
foreach ($sql as $row) {
  $username = $row['username'];
  $location = $row['pref'];
  $introduction = $row['introduction'];
  $profile_img = $row['img_path'];
  $followers = $row['followers_count'];
  $friends = $row['friends_count'];
}















try {
  $db = new Db();
  $pdo = $db->dbConnect();
  $sql = "SELECT * from job_management where user_id='$id' and status=1";

  $jobs_info = array();
  $stmt = $pdo->query($sql);

  foreach ($stmt as $row) {
    array_push($jobs_info, $row);
  }
} catch (PDOException $e) {
  $errorMessage = 'データベースエラー';
  echo $e->getMessage();
}


try {
  $db = new Db();
  $pdo = $db->dbConnect();
  $sql = "SELECT * from job_management where user_id='$id' AND status=2";

  $received_jobs = array();
  $stmt = $pdo->query($sql);

  foreach ($stmt as $row) {
    array_push($received_jobs, $row);
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



  </br>
  </br>

  <div class="container-fluid m-0 text-center about-contents" id="about-contents">
    </br>
    <?php if (isset($_SESSION['login']) or isset($_SESSION['me'])) : ?>
      <div class="row justify-content-start">
        <a class="btn btn-primary" href="profile_edit_image_user.php" role="button">プロフィール画像を変更する</a>
      </div>
      </br>
      <div class="row justify-content-start">
        <a class="btn btn-primary" href="profile_edit_user.php" role="button">プロフィール編集画面へ</a>
      </div>
    <?php endif; ?>
    </br>
    <?php if (!isset($_SESSION['me']) && (isset($_SESSION['login']))) : ?>
      <div class="row justify-content-start">
        <a class="btn btn-primary" href="login.php" role="button">twitterアカウントと連携させる</a>
      </div>
      </br>
    <?php endif; ?>
    <?php
    if (isset($_SESSION['login'])) : ?>
      <div class="row justify-content-start mt-3">
        <a class="btn btn-primary" href="job_management.php?id=<?php echo ($_SESSION['id']); ?>">申請中の依頼を確認</a>
      </div>
      <div class="row justify-content-start mt-3">
        <a class="btn btn-primary" href="job_receiving.php?id=<?= $_SESSION['id'] ?>">受注中の依頼を確認</a>
      </div>
    <?php elseif (isset($_SESSION['me'])) : ?>
      <div class="row justify-content-start mt-3">
        <a class="btn btn-primary" href="job_management.php?id=<?= $_SESSION['me_id'] ?>">申請中の依頼を確認</a>
      </div>
      <div class="row justify-content-start mt-3">
        <a class="btn btn-primary" href="job_receiving.php?id=<?= $_SESSION['me_id'] ?>">受注中の依頼を確認</a>
      </div>
    <?php endif; ?>
    <h1>proflile</h1>
    <img class="img-thumbnail mt-5 mb-5 rounded-circle" width="1200" height="600" src="<?= h($profile_img); ?>" width="100px">
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
          <p><?= $location; ?></p>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="about-text">
          <h3>フォロワー数</h3>
          <p><?= $followers; ?></p>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="about-text">
          <h3>フォロー数</h3>
          <p><?= $friends; ?></p>
        </div>
      </div>
    </div>
    </br>
    <div class="align-items-center">
      <h1>自己紹介</h1>
      <textarea class="form-control col  align-items-center" id="Textarea" name="text" rows="3" placeholder="自分のキャラクターやPRポイントなどを詳細に書いてください" readonly><?php if (isset($_SESSION['login'])) {
                                                                                                                                                        echo $introduction;
                                                                                                                                                      }
                                                                                                                                                      ?></textarea>
    </div>
    <?php if (isset($_SESSION['me'])) : ?>
      <form action="logout2.php" method="post" id="logout">
        <button type="submit" class="btn btn-danger" value="logout">ログアウトする</button>
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
      </form>
    <?php else : ?>
      <a class="btn btn-danger" href="logout.php" value="logout">ログアウトする</a>
    <?php endif; ?>
  </div>




  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>

</html>