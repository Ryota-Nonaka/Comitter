<?php

require_once(__DIR__ . '/config.php');


$id = $_GET['id'];
$twitterLogin = new MyApp\TwitterLogin();
$db = new Db();
$pdo = $db->dbConnect();
$sql = "SELECT job.job_id,shop_id,shop_userdata.shop_name,
shop_tell,shop_email,shop_zip,shop_pref,shop_addr,business_hour_open,business_hour_close,regular_holiday,shop_url,job.date_job_started,job_title,job_body,job_img_path,area,age,needs_like,reward FROM job JOIN shop_userdata ON job.shop_id=shop_userdata.id WHERE job.job_id='$id'";

$stmt = $pdo->query($sql);
foreach ($stmt as $row) {
  $job_id = $row['job_id'];
  $shop_id = $row['shop_id'];
  $shop_name = $row['shop_name'];
  $tell = $row['shop_tell'];
  $email = $row['shop_email'];
  $zip = $row['shop_zip'];
  $pref = $row['shop_pref'];
  $addr = $row['shop_addr'];
  $open = $row['business_hour_open'];
  $close = $row['business_hour_close'];
  $regular_holiday = $row['regular_holiday'];
  $url = $row['shop_url'];
  $job_started = $row['date_job_started'];
  $job_title = $row['job_title'];
  $job_img = $row['job_img_path'];
  $job_body = $row['job_body'];
  $area = $row['area'];
  $age = $row['age'];
  $like = $row['needs_like'];
  $reward = $row['reward'];
}





if (isset($_SESSION['login'])) {
  $contacted_user = "";
  $applying_user = "";
  try {
    $db = new Db();
    $pdo = $db->dbConnect();
    $stmt = $pdo->prepare("select * from job_management where user_id=? and status=2 and job_id='$job_id'");
    $stmt->execute(array($_SESSION['id']));

    $row = $stmt->fetch((PDO::FETCH_ASSOC));
  } catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
  }
  if (!isset($row['user_id'])) {
    $contacted_user = $_SESSION['id'];
  } elseif (isset($row['user_id'])) {
    $applying_user = $_SESSION['id'];
  }
}
if (isset($_SESSION['me'])) {
  $contacted_user = "";
  $applying_user = "";
  try {
    $db = new Db();
    $pdo = $db->dbConnect();
    $stmt = $pdo->prepare("select * from job_management where user_id=? and status=2 and job_id='$job_id'");
    $stmt->execute(array($_SESSION['me_id']));
    $row = $stmt->fetch((PDO::FETCH_ASSOC));
  } catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
  }
  if (!isset($row['user_id'])) {
    $contacted_user = $_SESSION['me_id'];
  } elseif (isset($row['user_id'])) {
    $applying_user = $_SESSION['me_id'];
  }
}




if (isset($_SESSION['login_shop']) && $_SESSION['login_shop_id'] == $shop_id) {
  $applying_users = array();
  $db = new Db();
  $pdo = $db->dbConnect();
  $sql = $pdo->prepare("SELECT * FROM job_management WHERE job_id='$job_id' AND status=1");
  $sql->execute();
  foreach ($sql as $row) {
    array_push($applying_users, $row);
  }
}
if (isset($_POST['delete'])) {
  try {
    $db = new Db();
    $pdo = $db->dbConnect();
    $stmt = $pdo->prepare("DELETE FROM job WHERE job_id='$job_id'");
    $stmt->execute();
    header('Location:delete_job.php');
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

if (isset($_POST['apply'])) {
  $user_id = $_POST['user_id'];
  try {
    $db = new Db();
    $pdo = $db->dbConnect();
    $sql = $pdo->prepare("UPDATE job_management SET status=2
    WHERE job_id='$job_id' AND user_id='$user_id'");
    $sql->execute();
  } catch (PDOException $e) {
    $errorMessage = 'データベースエラー';
    echo $e->getMessage();
  }
}

if (isset($_POST['reject'])) {
  $user_id = $_POST['user_id'];
  try {
    $db = new Db();
    $pdo = $db->dbConnect();
    $sql = $pdo->prepare("DELETE FROM job_management WHERE job_id='$job_id' AND user_id='$user_id'");
    $sql->execute();
  } catch (PDOException $e) {
    $errorMessage = 'データベースエラー';
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
  </br>
  <div id="contents" class="container">

    <div class="card">
      <div class="card-header alert alert-success m-0" role="alert">
        <h1 class="m-md-3 font-weight-bold">
          <?= $job_title ?>
        </h1>
      </div>
    </div>


    <div class="row justify-content-md-center">
      <img class="img-fluid" src="<?= h($job_img); ?>">
    </div>
    <div class="card">
      <div class="card-header alert alert-secondary m-0" role="alert">依頼内容</div>
      <table class=" table table-bordered m-0">
        <tbody>
          <tr>
            <th style="width:25%" scope="row">ジョブNo.</th>
            <td style="width:75%"><?= $job_id ?></td>
          </tr>
          <tr>
            <th scope="row">必要いいね数</th>
            <td><?= $like ?> </td>
          </tr>
          <tr>
            <th scope="row">募集内容</th>
            <td><?= $job_body ?></td>
          </tr>
          <tr>
            <th scope="row">エリア</th>
            <td><?= $area ?></td>
          </tr>
          <tr>
            <th scope="row">特典</th>
            <td><?= $reward ?>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    </br>
    </br>
    <div class="card">
      <div class="card-header alert alert-primary m-0" role="alert">店舗情報</div>
      <table class="table table-bordered m-0">
        <tbody>
          <tr>
            <th style="width:25%" scope="row">店舗名</th>
            <td style="width:75%"><?= $shop_name ?></td>
          </tr>
          <tr>
            <th scope="row">連絡先</th>
            <td>

              <p>tel:<?= $tell ?></p>
              <br>
              <p>Eメール:<?= $email ?></p>
            </td>
          </tr>
          <tr>
            <th scope="row">住所</th>
            <td>〒<?= $zip ?>
              <br>
              <?= $pref ?><?= $addr ?>
            </td>
          </tr>
          <tr>
            <th scope="row">営業時間</th>
            <td><?= $open ?>～<?= $close ?>
            </td>
          </tr>
          <tr>
            <th scope="row">定休日</th>
            <td><?= $regular_holiday ?>
            </td>
          </tr>
          <tr>
            <th scope="row">店舗URL</th>
            <td><a href="<?= $url ?>"><?= $url ?></a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>


  <?php if (!empty($contacted_user)) : ?>
    <div class="container mt-5 p-lg-5 bg-light">
      <form action="job_contact_form.php" method="post">
        <input type="hidden" name="contacted_user" value="<?= $contacted_user; ?>">
        <input type="hidden" name="job_id" value="<?= $job_id; ?>">
        <input type="hidden" name="job_shop_id" value="<?= $shop_id; ?>">

        <button type="submit" class="btn btn-primary btn-block col" name="apply">申し込む</button>

      </form>
    </div>
  <?php elseif (!empty($applying_user)) : ?>
    <div class="container mt-5 p-lg-5 bg-light">
      <form method="post" action="job_complete.php">
        <input type="hidden" name="user_id" value="<?= $applying_user; ?>">
        <input type="hidden" name="job_id" value="<?= $job_id; ?>">
        <button class="btn btn-primary" name="complete" type="submit">完了報告する</button>
      </form>
    </div>
  <?php endif; ?>


  <?php if (isset($_SESSION['login_shop'])) : ?>
    <form method="post">
      <div class="container">
        <div class="text-right my-sm-3">
          <button type="submit" class="btn btn-danger" name="delete">削除する</button>
        </div>
    </form>
    <div class="row">
      <div class="ml-3">
        <h1>申請中のユーザー</h1>
      </div>
    </div>
    <?php if (isset($applying_users)) : ?>
      <?php foreach ($applying_users as $applying_user) : ?>
        <form method="post" action="job_contents.php?id=<?= $job_id; ?>">
          <input type="hidden" name="user_id" value="<?= $applying_user['user_id'] ?>">
          <div class="card" style="width: 18rem;">
            <img src="<?= $applying_user['user_img_path']; ?>" class="bd-placeholder-img card-img-top" width="100%" height="180" role="img" aria-label="Placeholder: Image cap">
            <h5 class="card-title"> <a class="mt-0 mb-1 font-weight-bold" href="mypage_user.php?id=<?= $applying_user['user_id'] ?>"><?= htmlspecialchars($applying_user['username'], ENT_QUOTES, 'UTF-8'); ?></a></h5>
            <rect width="100%" height="100%" fill="#868e96" />
            <div class="row">

              <div class="card-body">
                <p>フォロワー数:<?= $applying_user['followers_count']; ?></p>
                <p>
                  フォローしている数:<?= $applying_user['friends_count']; ?></p>
              </div>
            </div>
            <div class="row">
              <div class="card-footer">
                <button class="btn btn-primary" type="submit" name="apply">承認する</button>
                <button class="btn btn-danger" type="submit" name="reject">申請を否決する

                </button>
              </div>
            </div>
          </div>
        </form>
        </div>
        </div>




      <?php endforeach; ?>
    <?php endif; ?>
  <?php endif; ?>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>