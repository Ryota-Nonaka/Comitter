<?php
require_once(__DIR__ . '/config.php');





$twitterLogin = new MyApp\TwitterLogin();
$me = $_SESSION['me'];
$token = $_SESSION['token'];

$twitter = new MyApp\Twitter($me->tw_access_token, $me->tw_access_token_secret);
$tweets = array();
$tweet = array();

$tweets = $twitter->getTweets();
$tweet_array = array();
foreach ($tweets as $tweet) {
  $tweet_array[] = json_decode(json_encode($tweet), true);
  $results = array();
  $result = array();
}



if (isset($_GET['search_tweets'])) {
  $key = $_GET['search_tweets'];



  $pattern = "/" . preg_quote($key, "/") . "/i";
  $results = array_filter(
    $tweet_array,
    function ($tw) use ($pattern) {
      if (preg_match($pattern, $tw['text'])) {
        return true;
      }
    },
    ARRAY_FILTER_USE_BOTH
  );
} else if (!isset($_GET['search_tweets'])) {
  $results = $tweet_array;
}


MyApp\Token::create();





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
    <div class="row justify-content-md-center">
      <h1>@<?= h($me->username); ?>'s Timeline</h1>
    </div>
    <form type="text" name="search_tweets" method="get" action="">
      <div class="form-group row justify-content-md-center">
        <div class="col-sm-XX">
          <input type="text" class="form-control" placeholder="キーワード" name="search_tweets" action="getTweets.php">
        </div>
        <div class="ml-3">
          <input class="btn btn-secondary" type="submit" id="page" value="検索">
        </div>
      </div>
    </form>
    <div class="row justify-content-md-center ml-8">
      <ul>
        <?php foreach ($results as $result) : ?>
          <li>
            <?php
            $oembed = $twitter->oembed($result);
            ?>
            <p><?= date('Y年m月d日', strtotime($result['created_at'])); ?>のツイート</p>
            <form method="post" action="job_complete.php">
              <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>">
              <input type="hidden" name="job_id" value="<?= $_SESSION['job_id']; ?>">
              <input type="hidden" name="url" value="<?= $oembed->url ?>">
              <?= $oembed->html; ?>
              <button class="btn btn-primary" name="select" type="submit">ツイートを選択</button>
            </form>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
  <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>