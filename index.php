<?php

require_once(__DIR__ . '/config.php');
ini_set('display_errors', 1);



$twitterLogin = new MyApp\TwitterLogin();

if ($twitterLogin->isLoggedIn()) {
  $me = $_SESSION['me'];

  $twitter = new MyApp\Twitter($me->tw_access_token, $me->tw_access_token_secret);
  $userInfo = $twitter->getProfile();


  MyApp\Token::create();
}
//リンククエリ
$db = new Db();
$pdo = $db->dbConnect();
$result = array();
if (isset($_GET['job_name']) && isset($_GET['job_location'])) {
  $name_search = htmlspecialchars($_GET['job_name']);
  $name_search_value = $name_search;
  $location_search = htmlspecialchars($_GET['job_location']);
  $location_search_value = $location_search;

  $sql = "SELECT * FROM job where job_title LIKE '%$name_search%' AND location  LIKE '%$location_search%' ";

  $stmt = $pdo->query($sql);
  foreach ($stmt as $row) {
    array_push($result, $row);
  }
} else if (!isset($_GET['job_name']) && isset($_GET['job_location'])) {
  $name_search = '';
  $name_search_value = $name_search;
  $location_search = htmlspecialchars($_GET['job_location']);
  $location_search_value = $location_search;

  $sql = "SELECT * FROM job where location  LIKE '%$location_search%' ";

  $stmt = $pdo->query($sql);
  foreach ($stmt as $row) {
    array_push($result, $row);
  }
} else if (isset($_GET['job_name']) && !isset($_GET['job_location'])) {
  $name_search = htmlspecialchars($_GET['job_name']);
  $name_search_value = $name_search;
  $location_search = '';
  $location_search_value = $location_search;
  $sql = "SELECT * FROM job where job_title LIKE '%$name_search%' ";
  $stmt = $pdo->query($sql);
  foreach ($stmt as $row) {
    array_push($result, $row);
  }
} else {
  $name_search = '';
  $name_search_value = $name_search;
  $location_search = '';
  $location_search_value = $location_search;

  $sql = "SELECT * FROM job";
  $result = array();
  $stmt = $pdo->query($sql);
  foreach ($stmt as $row) {
    array_push($result, $row);
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/vader/jquery-ui.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <!-- carousel.CSS -->
  <link rel="stylesheet" href="src\css\carousel.css">

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
        <form class="form-inline mt-2 mt-md-0">

          <!-- 切り替えボタンの設定 -->
  <?php


  if (isset($_SESSION['login'])) : ?>
    <div class=text-light> ようこそ、<span class="text-primary"> <?= $_SESSION['login'] ?> </span>さん！</div>
    <a href="mypage_user.php?username=<?php echo ($_SESSION['login']); ?>">マイページへ</a>
  <?php elseif (isset($_SESSION['me'])) : ?>
    <div class=text-light> ようこそ、<span class="text-primary"> <?= $userInfo->name ?> </span>さん！</div>
    <a href='mypage_user.php'>マイページへ</a>
  <?php elseif (isset($_SESSION['login_shop'])) : ?>
    <div class=text-light> ようこそ、<span class="text-primary"><?= $_SESSION['login_shop'] ?> </span>さん！</div>
    <a href='mypage_shop.php?shop_name=<?php echo ($_SESSION['login_shop']); ?>'>マイページへ</a>
  <?php else : ?>
    <a href='signin_user.php'>ユーザーログインはこちら</a>
    <a href='signin_shop.php'>店舗会員ログインはこちら</a>
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
          </div><!-- /.modal-footer -->
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
  </div>
  <main role="main">

    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img class="first-slide" src="src\images\EPansWNVUAA--oi.jpg" alt="First slide">
          <div class="container">
            <div class="carousel-caption text-left">
              <h1 class="text-success">注目案件のスライド表示</h1>
              <p class="text-primary font-weight-bold">記事へのリンク</p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">早速見に行く</a></p>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <img class="second-slide" src="src\images\maxresdefault (1).jpg" alt="Second slide">
          <div class="container">
            <div class="carousel-caption">
              <h1 class="font-weight-bold text-primary">えっ!!新鮮な魚介だからカロリー0 ???</h1>
              <p></p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">動画を見に行く</a></p>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <img class="third-slide" src="src\images\maxresdefault (2).jpg" alt="Third slide">
          <div class="container">
            <div class="carousel-caption text-right">
              <h1 class="text-danger font-weight">
                <div class="text-left">宮城が生んだ二代目彦摩呂！！</div>
              </h1>
              <p2><a class="btn btn-lg btn-primary" href="#" role="button">ンーワァオ!!!!!!</a></p2>
            </div>
          </div>
        </div>
      </div>
      <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>




    <div class="container marketing"></div>
    <form method="get" action="result.php">
      <div class="form-row">
        <p class="text-left text-secondary">　
          商品名・エリアで検索</ｐ>


          <div class="col-sm-XX">
            <input type="text" class="form-control" placeholder="商品名" name="job_name" id="job_name" value="<?php echo $name_search_value ?>">
          </div>
          <div class="col-sm-XX">
            <input type="text" class="form-control" placeholder="エリア" name="job_location" id="job_location" value="<?php echo $location_search_value ?>">
          </div>
          <!-- <div class=" col-sm-XX">
            <input type="text" id="datepicker" class="form-control" placeholder="期間" name="search3">
          </div> -->
          <input type="submit" name="" value="検索">
      </div>
    </form>
    <!-- Three columns of text below the carousel -->
    </br>



    <!-- FOOTER -->
    <footer class="container">
      <p class="float-right text-secondary"><a href="#">Back to top</a></p>
      <p>&copy; 2017-2018 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
    </footer>
  </main>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script>
    $(function() {
      $("#datepicker").datepicker();
    });
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>