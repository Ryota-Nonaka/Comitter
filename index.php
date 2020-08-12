<!doctype html>
<html lang="ja">
<!-- 独自ロジックの開発
twitterからはフォロワー数
youtubeからは登録者数
各SNSから人気の指標になる数字を織り込めるようにする
(アカウントと紐づける、API)
アカウント数に応じた募集を表示できるようにする。 -->

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
          session_start();

          if (isset($_SESSION['loginuser'])) :?>
            <div class=text-light> ようこそ、<span class="text-primary"> <?= $_SESSION['loginuser'] ?> </span>さん！</div>
            <a href='logout.php'>ログアウトはこちら。</a>
            <?php
            elseif (isset($_SESSION['loginshop'])) : ?>
            <div class=text-light> ようこそ、<span class="text-primary"> <?= $_SESSION['loginshop'] ?> </span>さん！</div>
            <a href='logout.php'>ログアウトはこちら。</a>
          <?php else : ?>
            <button type="button" class="btn btn-primary text-right" data-toggle="modal" data-target="#exampleModal">ログイン</button>
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


    <!-- Marketing messaging and featurettes
      ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing"></div>
    <form>
      <class class="form-row">
        <p class="text-left text-secondary">エリア・店名・期間で検索</ｐ>
          <div class="col-sm-auto">
            <input type="text" class="form-control" placeholder="地域">
          </div>
          <div class="col-sm-XX">
            <input type="text" class="form-control" placeholder="店名">
          </div>
          <div class="col-sm-XX">
            <input type="text" id="datepicker" class="form-control" placeholder="期間">
          </div>
          <a class="btn btn-lg btn-primary nav-link" href="info.php" role="button">検索</a>
      </class>
    </form>
    <!-- Three columns of text below the carousel -->
    </br>
    <h1 class="text-secondary">投稿ジャンルから探す</h1>
    <div class="row">
      <div class="col-lg-4">
        <img class="rounded-circle" src="src\images\oban.gif" alt="Generic placeholder image" width="140" height="140">
        <h2 class="text-secondary">YOUTUBE</h2>
        <p class="text-secondary">おばんっすおばんっすおばんっすおばんっすおばんっすおばんっすおばんっすおばんっすおばんっすおばんっすおばんっすおばんっす</p>
        <p><a class="btn btn-primary" href="info.php" role="button">検索画面へ</a></p>
      </div><!-- /.col-lg-4 -->
      <div class="col-lg-4">
        <img class="rounded-circle" src="src\images\oban.gif" alt="Generic placeholder image" width="140" height="140">
        <h2 class="text-secondary">SNS</h2>
        <p class="text-secondary">おばんっすおばんっすおばんっすおばんっすおばんっすおばんっすおばんっすおばんっすおばんっすおばんっすおばんっすおばんっす</p>
        <p><a class="btn btn-primary" href="info.php" role="button">検索画面へ</a></p>
      </div><!-- /.col-lg-4 -->
      <div class="col-lg-4">
        <img class="rounded-circle" src="src\images\oban.gif" alt="Generic placeholder image" width="140" height="140">
        <h2 class="text-secondary">コラム・記事など</h2>
        <p class="text-secondary">おばんっすおばんっすおばんっすおばんっすおばんっすおばんっすおばんっすおばんっすおばんっすおばんっすおばんっすおばんっすおばんっすおばんっすおばんっす</p>
        <p><a class="btn btn-primary" href="info.php" alt="Generic placeholder image" role="button">検索画面へ</a></p>
      </div><!-- /.col-lg-4 -->
      </h1><!-- /.row -->


    </div><!-- /.container -->


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