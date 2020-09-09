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
    $contacted_user_id = $row['contacted_user_id'];
  }
} catch (PDOException $e) {
  $errorMessage = 'データベースエラー';
  echo $e->getMessage();
}



// try {
//   $db = new Db();
//   $pdo = $db->dbConnect();
//   $sql = "SELECT * from userdata where id='$contacted_user_id'";

//   if ($contacted_user_id != 0) {

//     $users_info = array();
//     $stmt = $pdo->query($sql);

//     foreach ($stmt as $row) {
//       array_push($users_info, $row);
//     }
//   } elseif ($contacted_user_id = 0) {
//     exit();
//   }
// } catch (PDOException $e) {
//   $errorMessage = 'データベースエラー';
//   echo $e->getMessage();
// }






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
        <form class="form-inline mt-2 mt-md-0">

          <!-- 切り替えボタンの設定 -->
          <?php


          if (isset($_SESSION['login_shop'])) : ?>
            <div class=text-light> ようこそ、<span class="text-primary"><?php echo $_SESSION['login_shop']; ?> </span>さん！</div>
            <a href='mypage_shop.php?shop_name=<?php echo ($_SESSION['login_shop']); ?>'>マイページへ</a>
          <?php endif; ?>


        </form>

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
          </div>
        </div>
      </div>
    </div>
  </div>
  </br>
  </br>

  <div class="container-fluid mx-auto text-center about-contents" id="about-contents">
    </br>

    <div class="row justify-content-start">
      <a class="btn btn-primary" href="job_input.php" role="button">依頼を投稿する</a>
    </div>
    <h1>proflile</h1>
    <img class="img-thumbnail mt-5 mb-5 rounded-circle" src="<?php
                                                              echo h($shop_img);
                                                              ?>" width="100px">
    <div class="row">
      <div class="col-lg-3 col-sm-6">
        <div class="about-text">
          <h3>Username</h3>
          <p> <?php
              echo  $username;
              ?></p>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="about-text">
          <h3>Location</h3>
          <p><?php
              echo $location;
              ?></p>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="about-text">
          <h3>営業時間</h3>
          <p><?php
              echo $open . '~' . $close;
              ?></p>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="about-text">
          <h3>定休日</h3>
          <p><?php
              echo $regular_holiday;
              ?></p>
        </div>
      </div>
    </div>
    </br>

    <div class="col-lg-3 col-sm-6">
      <div class="about-text">
        <h3>お店のurl</h3>
        <p>
          <?php
          echo $shop_url;
          ?></p>
      </div>
    </div>
    <?php if (isset($_SESSION['login_shop'])) : ?>
      <a class="btn btn-danger" href="logout.php" value="logout">ログアウトする</a>
    <?php endif; ?>
  </div>
  <div class="container-fluid mx-auto row" id="applying-order">
    <?php if (isset($_SESSION['login_shop'])) : ?>
      <h1>掲載中の案件</h1>
      <?php foreach ($jobs_info as $job_info) : ?>
        <li class="media">
          <img width="64" height="64" src="<?php echo $job_info['job_img_path']; ?>">

          <div class="media-body mt-3">
            <a class="mt-0 mb-1 font-weight-bold" href="job_contents.php?id=<?php echo $job_info['job_id']; ?>"><?php echo htmlspecialchars($job_info['job_title'], ENT_QUOTES, 'UTF-8'); ?></a>
            <p>広告依頼内容簡単に記述、クリックで詳細画面へ</p>
          </div>
        </li>
      <?php endforeach; ?>
      </ul>
  </div>
<?php endif; ?>



</div>




<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>

</html>