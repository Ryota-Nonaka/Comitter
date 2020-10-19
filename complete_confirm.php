<?php

require_once(__DIR__ . '/config.php');

$id = $_GET['id'];
$results = array();
$result = array();
$db = new Db();
$pdo = $db->dbConnect();
$count = $pdo->query("SELECT COUNT(*) FROM job_management WHERE shop_id='$id' AND status=3")
  ->fetchColumn();
if ($count > 0) {
  $db = new Db();
  $pdo = $db->dbConnect();
  $sql = $pdo->prepare("SELECT job_management.shop_id,job_id,job_title,job_body,job_img_path,area,user_id,username,email,pref,introduction,user_img_path,sex,age,followers_count,friends_count,tweet_link,needs_like,reward,created,shop_userdata.shop_name,business_hour_open,business_hour_close,regular_holiday,shop_img from job_management JOIN shop_userdata ON job_management.shop_id=shop_userdata.id WHERE shop_id='$id' AND status=3");
  $sql->execute();
  foreach ($sql as $row) {
    $shop_id = $row['shop_id'];
    $job_id = $row['job_id'];
    $job_title = $row['job_title'];
    $job_body = $row['job_body'];
    $job_img = $row['job_img_path'];
    $area = $row['area'];
    $like = $row['needs_like'];
    $reward = $row['reward'];
    $user_id = $row['user_id'];
    $username = $row['username'];
    $email = $row['email'];
    $pref = $row['pref'];
    $introduction = $row['introduction'];
    $user_img = $row['user_img_path'];
    $sex = $row['sex'];
    $age = $row['age'];
    $followers = $row['followers_count'];
    $friends = $row['friends_count'];
    $url = $row['tweet_link'];
    $created = date('Y年m月d日', strtotime($row['created']));
    array_push($results, $row);
  }

  try {
    $db = new Db();
    $pdo = $db->dbConnect();
    $sql = $pdo->prepare("SELECT * FROM userdata WHERE id='$user_id'");
    $sql->execute();
    foreach ($sql as $row) {
      $accessToken = $row['tw_access_token'];
      $accessTokenSecret = ['tw_access_token_secret'];
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

  $twitter = new MyApp\Twitter(CONSUMER_KEY, CONSUMER_SECRET, $accessToken, $accessTokenSecret);
  $oembed = $twitter->getOembed($url);

  if (isset($_POST['complete'])) {
    try {

      $db = new Db();
      $pdo = $db->dbConnect();
      $stmt = $pdo->prepare("INSERT INTO archive(shop_id,job_id,job_title,job_body,job_img_path,area,needs_like,reward,user_id,username,email,pref,introduction,user_img_path,sex,age,followers_count,friends_count,tweet_link,created,modified) VALUES(:shop_id,:job_id,:job_title,:job_body,:job_img_path,:area,:needs_like,:reward,:user_id,:username,:email,:pref,:introduction,:user_img_path,:sex,:age,:followers_count,:friends_count,:tweet_link,:created,now())");
      $stmt->bindParam(':shop_id', $shop_id, PDO::PARAM_INT);
      $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
      $stmt->bindParam(':job_title', $job_title, PDO::PARAM_STR);
      $stmt->bindParam(':job_body', $job_body, PDO::PARAM_STR);
      $stmt->bindParam(':job_img_path', $job_img, PDO::PARAM_STR);
      $stmt->bindParam(':area', $area, PDO::PARAM_STR);
      $stmt->bindParam(':needs_like', $like, PDO::PARAM_STR);
      $stmt->bindParam(':reward', $reward, PDO::PARAM_STR);
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->bindParam(':username', $username, PDO::PARAM_STR);
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':pref', $pref, PDO::PARAM_STR);
      $stmt->bindParam(':introduction', $introduction, PDO::PARAM_STR);
      $stmt->bindParam(':user_img_path', $user_img, PDO::PARAM_STR);
      $stmt->bindParam(':sex', $sex, PDO::PARAM_STR);
      $stmt->bindParam(':age', $age, PDO::PARAM_STR);
      $stmt->bindParam(':followers_count', $followers, PDO::PARAM_STR);
      $stmt->bindParam(':friends_count', $friends, PDO::PARAM_STR);
      $stmt->bindParam(':tweet_link', $url, PDO::PARAM_STR);
      $stmt->bindParam(':created', $created, PDO::PARAM_STR);
      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }

    try {
      $db = new Db();
      $pdo = $db->dbConnect();
      $stmt = $pdo->prepare("DELETE FROM job_management WHERE job_id='$job_id' AND user_id='$user_id'");
      $stmt->execute();
      // header('Location:job_complete_shop.php?id=' . $id);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

</head>

<body>
  <header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-t op bg-dark">
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
        </form>

      </div>
    </nav>

  </header>
  <?php if ($count > 0) : ?>
    <div class="container">
      <div class="row justify-content-md-center mt-3">
        <h1>完了ツイート一覧</h1>
      </div>
      <div class="row justify-content-md-center mt-3">
        <ul>
          <?php foreach ($results as $result) : ?>

            <li>
              <?php
              $oembed = $twitter->getoembed($url);
              ?>
              <p><?= $result['job_title'] ?>についてのツイート</p>
              <p>必要いいね数:<?= $result['needs_like'] ?></p>
              <p>特典:
                <?= $result['reward'] ?>
              </p>
              <p>ユーザーのマイページ:<a href="mypage_user.php?id=<?= $result['user_id'] ?>"><?= $result['username'] ?></a></p>
              <form method="post" action="complete_confirm.php?id=<?= $id; ?>">

                <?= $oembed->html; ?>
                <button type="submit" class="btn btn-primary" name="complete">承認する</button>
              </form>
            </li>

          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  <?php elseif ($count == 0) : ?>
    <div class="container">
      <div class="row justify-content-md-center mt-3">
        <h1>報告ツイートがありません。</h1>
      </div>
      <div class="row mt-3 justify-content-start">
        <div class="text-right">
          <a class="btn btn-primary" href="job_input.php" role="button">投稿画面へ</a>
        </div>
      </div>
      <form>
        <div class="row mt-3 justify-content-start">
          <input class="btn btn-secondary" type="button" value="マイページへ戻る" onclick="history.back(-1)">
        </div>
      </form>
    </div>
  <?php endif; ?>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>