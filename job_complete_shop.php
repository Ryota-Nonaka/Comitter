<?php
require_once(__DIR__ . '/config.php');
$id = $_GET['id'];
$results = array();
$result = array();
$db = new Db();
$pdo = $db->dbConnect();
$count = $pdo->query("SELECT COUNT(*) FROM archive WHERE shop_id='$id'")->fetchColumn();
if ($count > 0) {
  $db = new Db();
  $pdo = $db->dbConnect();
  $sql = $pdo->prepare("SELECT archive.shop_id,job_id,job_title,job_body,job_img_path,area,user_id,username,email,pref,introduction,user_img_path,sex,age,followers_count,friends_count,tweet_link,needs_like,reward,created,shop_userdata.shop_name,business_hour_open,business_hour_close,regular_holiday,shop_img from archive JOIN shop_userdata ON archive.shop_id=shop_userdata.id WHERE shop_id='$id'");
  $sql->execute();
  foreach ($sql as $row) {
    $url = $row['tweet_link'];

    array_push($results, $row);
  }
  try {
    $db = new Db();
    $pdo = $db->dbConnect();
    $sql = $pdo->prepare("SELECT * FROM userdata WHERE id=?");
    $sql->bindParam(1, $row['user_id'], PDO::PARAM_STR);
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

  <?php if ($count > 0) : ?>
    <div class="container">
      <div class="row justify-content-md-center mt-3">
        <h1>承認済ツイート一覧</h1>
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

              <?= $oembed->html; ?>

              </form>
            </li>

          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  <?php elseif ($count == 0) : ?>
    <div class="container">
      <div class="row justify-content-md-center mt-3">
        <h1>承認済ツイートがありません。</h1>
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
  <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>