<?php

require_once(__DIR__ . '/config.php');

if (isset($_SESSION['login'])) {
  try {
    $db = new Db();
    $pdo = $db->dbConnect();
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM userdata WHERE id='$id'";
    $stmt = $pdo->query($sql);
    foreach ($stmt as $row) {
      $username = $row['username'];
      $Location = $row['pref01'];
      $introduction = $row['introduction'];
      $profile_img = $row['img_path'];
    }
  } catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
  }
}




$twitterLogin = new MyApp\TwitterLogin();

if ($twitterLogin->isLoggedIn()) {
  $me = $_SESSION['me'];
  $token = $_SESSION['token'];
  $twitter = new MyApp\Twitter($me->tw_access_token, $me->tw_access_token_secret);

  $tweets = $twitter->getTweets();
  $userInfo = $twitter->getProfile();


  MyApp\Token::create();
}





try {
  $db = new Db();
  $pdo = $db->dbConnect();
  $sql = "SELECT * from job where contacted_user_id='$id'";

  $job_info = array();
  $stmt = $pdo->query($sql);

  foreach ($stmt as $row) {
    array_push($job_info, $row);
    var_dump($job_info);
    // $job_id = $row['job_id'];
    // $job_started = $row['date_job_started'];
    // $job_title = $row['job_title'];
    // $job_body = $row['job_body'];
    // $job_img = $row['job_img_path'];
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
  <title>MyPage</title>
</head>

<body>
  <!-- <header>
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
        <form class="form-inline mt-2 mt-md-0"> -->

  <!-- 切り替えボタンの設定 -->
  <?php


  if (isset($_SESSION['login'])) : ?>
    <div class=text-light> ようこそ、<span class="text-primary"> <?= $_SESSION['login'] ?> </span>さん！</div>
    <a href='mypage.php'>マイページへ</a>
  <?php elseif (isset($_SESSION['me'])) : ?>
    <div class=text-light> ようこそ、<span class="text-primary"> <?= $userInfo->name ?> </span>さん！</div>
    <a href='mypage.php'>マイページへ</a>
  <?php endif; ?>



  </form>

  </div>
  </nav>

  </header> -->

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

          </div>
        </div>
      </div>
    </div>
  </div>
  </br>
  </br>

  <div class="container-fluid mx-auto text-center about-contents" id="about-contents">
    </br>
    <?php if (isset($_SESSION['login']) or isset($_SESSION['me'])) : ?>
      <div class="row justify-content-start">
        <a class="btn btn-primary" href="profile_edit_img.php" role="button">プロフィール画像を変更する</a>
      </div>
    <?php endif; ?>
    </br>
    <?php if (isset($_SESSION['login']) or isset($_SESSION['me'])) : ?>
      <div class="row justify-content-start">
        <a class="btn btn-primary" href="profile_edit.php" role="button">プロフィール編集画面へ</a>
      </div>
    <?php endif; ?>
    </br>
    <?php if (!isset($_SESSION['me'])) : ?>
      <div class="row justify-content-start">
        <a class="btn btn-primary" href="login.php" role="button">twitterアカウントと連携させる</a>
      </div>
    <?php endif; ?>

    <h1>proflile</h1>
    <img class="img-thumbnail mt-5 mb-5 rounded-circle" src="<?php if (isset($_SESSION['login'])) {
                                                                echo h($profile_img);
                                                              } ?>" width="100px">
    <div class="row">
      <div class="col-lg-3 col-sm-6">
        <div class="about-text">
          <h3>Username</h3>
          <p> <?php if (isset($_SESSION['login'])) {
                echo  $username;
              }  ?></p>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="about-text">
          <h3>Location</h3>
          <p><?php if (isset($_SESSION['me'])) {
                echo $userInfo->location;
              } else if (isset($_SESSION['login'])) {
                echo $Location;
              } ?></p>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="about-text">
          <h3>フォロワー数</h3>
          <p><?php if (isset($_SESSION['me'])) {
                echo $userInfo->followers_count;
              } else echo '0'; ?></p>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="about-text">
          <h3>フォロー数</h3>
          <p><?php if (isset($_SESSION['me'])) {
                echo $userInfo->friends_count;
              } else echo '0'; ?></p>
        </div>
      </div>
    </div>
    </br>
    <div class="align-items-center">
      <h1>自己紹介</h1>
      <textarea class="form-control col  align-items-center" id="Textarea" name="text" rows="3" placeholder="自分のキャラクターやPRポイントなどを詳細に書いてください"><?php if (isset($_SESSION['login'])) {
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
  <div class="container-fluid mx-auto" id="applying-order">
    <h1>申請中の案件</h1>
  </div>

  <div class="container-fluid mx-auto" id="receiving-order">
    <h1>受注中の案件</h1>
  </div>
  </div>



  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>

</html>