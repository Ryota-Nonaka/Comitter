<?php
require_once(__DIR__ . '/config.php');
$_SESSION['user_id'] = $_POST['user_id'];
$_SESSION['job_id'] = $_POST['job_id'];


try {
  $db = new Db();
  $pdo = $db->dbConnect();
  $result = array();
  $sql = $pdo->prepare("SELECT job.job_id,shop_id,shop_userdata.shop_name,
  shop_tell,shop_email,shop_zip,shop_pref,shop_addr,business_hour_open,business_hour_close,regular_holiday,shop_url,job.date_job_started,job_title,job_body,job_img_path,area,age,needs_like,reward FROM job JOIN shop_userdata ON job.shop_id=shop_userdata.id WHERE job_id=?");
  $sql->bindValue(1, $_SESSION['job_id'], \PDO::PARAM_STR);
  $sql->execute();
  foreach ($sql as $row) {
    array_push($result, $row);
  }
} catch (PDOException $e) {
  $errorMessage = 'データベースエラー';
  echo $e->getMessage();
}


$twitterLogin = new MyApp\TwitterLogin();
$me = $_SESSION['me'];
$token = $_SESSION['token'];
$twitter = new MyApp\Twitter($me->tw_access_token, $me->tw_access_token_secret);
if (isset($_POST['url'])) {
  $url = $_POST['url'];
  $oembed = $twitter->getOembed($url);
  if (isset($_POST['confirm'])) {
    $url = $_POST['url'];
    $user_id = $_SESSION['user_id'];
    $job_id = $_SESSION['job_id'];
    try {
      $db = new Db();
      $pdo = $db->dbConnect();
      $stmt = $pdo->prepare("UPDATE job_management SET tweet_link='$url',status=3 WHERE job_id='$job_id' AND user_id='$user_id'");


      $stmt->execute();
      $_SESSION['id'] = $user_id;
      header('Location:job_finished_user.php');
    } catch (Exception $e) {
      echo 'エラーが発生しました。:' . $e->getMessage();
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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


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
  <div class="container mt-5">
    <ul>
      <li class="media justify-content-md-center">
        <span class="border border-right-0 border-left-0">
          <div class="row">
            <img class="pull-left img-responsive m-md-3" width="300" height="300" src="<?= $result[0]['job_img_path']; ?>">
            <ul>
              <a class="mt-0 mb-1 font-weight-bold" href="job_contents.php?id=<?= $result[0]['job_id']; ?>">
                <h3><?= htmlspecialchars($result[0]['job_title'], ENT_QUOTES, 'UTF-8'); ?>
              </a></h3>
              <p>店名:<?= $result[0]['shop_name']; ?></p>
              <p>営業時間:<?= $result[0]['business_hour_open']; ?>～<?= $result[0]['business_hour_close']; ?></p>
              <p>エリア:<?= $result[0]['area']; ?></p>
              <p>ターゲット年齢層:<?= $result[0]['age']; ?>代</p>
              <p>必要いいね数:<?= $result[0]['needs_like'] ?></p>
              <p class="d-inline-block text-truncate" style="max-width: 150px;">募集要項:<?= $result[0]['job_body']; ?></p>
              </br>
              <p class="d-inline-block text-truncate" style="max-width: 150px;">特典:<?= $result[0]['reward'] ?></p>
            </ul>
          </div>

        </span>
      </li>
      </br>
    </ul>
    <div class="row justify-content-md-center">
      <h1>上記に対して完了報告を行う</h1>
    </div>
    <?php if (isset($oembed)) :
    ?>
      <div class="row justify-content-md-center">
        <?= $oembed->html; ?>
      </div>
      <form method="post" action="job_complete.php">
        <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>">
        <input type="hidden" name="job_id" value="<?= $_SESSION['job_id']; ?>">
        <input type="hidden" name="url" value="<?= $url; ?>">

        <div class="row justify-content-md-center">
          <button class="btn btn-primary" name="confirm" type="submit">
            このツイートで報告を行う </button>
        </div>

      </form>

    <?php elseif (!isset($oembed)) : ?>
      <form action="select_tweet.php" method="post">
        <div class="row mt-5">
          <button class="btn btn-primary" name="submit" type="submit">tweetを選択する</button>
        </div>
      </form>
  </div>
<?php endif; ?>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>