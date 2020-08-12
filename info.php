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

          if (isset($_SESSION['login'])) {
            echo "ようこそ、" . $_SESSION['login'] . "さん！";
            echo "<a href='logout.php'>ログアウトはこちら。</a>";
          } else {
            echo  '<button type="button" class="btn btn-primary text-right" data-toggle="modal" data-target="#exampleModal">ログイン</button>';
          }
          ?>
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
  </br>
  </br>
  </br>

  <!-- /.modal -->
  <form>
    <class class="form-row">
      <p class="text-left">エリア・店名・期間で検索</ｐ>
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
  <h1>検索結果画面</h1>

  <br class="list-unstyled">
  <li class="media">
    <svg class="bd-placeholder-img mr-3" width="64" height="64" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 64x64">
      <title>Placeholder</title>
      <rect width="100%" height="100%" fill="#868e96" /><text x="50%" y="50%" fill="#dee2e6" dy=".3em">64x64</text>
    </svg>
    <div class="media-body">
      <a class="mt-0 mb-1 font-weight-bold" href="syousai.php">店名</a>
      <p>広告依頼内容簡単に記述、クリックで詳細画面へ</p>
    </div>
  </li>
  </br>
  <li class="media">
    <svg class="bd-placeholder-img mr-3" width="64" height="64" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 64x64">
      <title>Placeholder</title>
      <rect width="100%" height="100%" fill="#868e96" /><text x="50%" y="50%" fill="#dee2e6" dy=".3em">64x64</text>
    </svg>
    <div class="media-body">
      <a class="mt-0 mb-1 font-weight-bold" href="syousai.php">店名</a>
      <p>広告依頼内容簡単に記述、クリックで詳細画面へ</p>
    </div>
  </li>
  </br>
  <li class="media">
    <svg class="bd-placeholder-img mr-3" width="64" height="64" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 64x64">
      <title>Placeholder</title>
      <rect width="100%" height="100%" fill="#868e96" /><text x="50%" y="50%" fill="#dee2e6" dy=".3em">64x64</text>
    </svg>
    <div class="media-body">
      <a class="mt-0 mb-1 font-weight-bold" href="syousai.php">店名</a>
      <p>広告依頼内容簡単に記述、クリックで詳細画面へ</p>
    </div>
  </li>
  </br>
  <li class="media">
    <svg class="bd-placeholder-img mr-3" width="64" height="64" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 64x64">
      <title>Placeholder</title>
      <rect width="100%" height="100%" fill="#868e96" /><text x="50%" y="50%" fill="#dee2e6" dy=".3em">64x64</text>
    </svg>
    <div class="media-body">
      <a class="mt-0 mb-1 font-weight-bold" href="syousai.php">店名</a>
      <p>広告依頼内容簡単に記述、クリックで詳細画面へ</p>
    </div>
  </li>
  </br>
  <li class="media">
    <svg class="bd-placeholder-img mr-3" width="64" height="64" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 64x64">
      <title>Placeholder</title>
      <rect width="100%" height="100%" fill="#868e96" /><text x="50%" y="50%" fill="#dee2e6" dy=".3em">64x64</text>
    </svg>
    <div class="media-body">
      <a class="mt-0 mb-1 font-weight-bold" href="syousai.php">店名</a>
      <p>広告依頼内容簡単に記述、クリックで詳細画面へ</p>
    </div>
  </li>
  </br>
  <li class="media">
    <svg class="bd-placeholder-img mr-3" width="64" height="64" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 64x64">
      <title>Placeholder</title>
      <rect width="100%" height="100%" fill="#868e96" /><text x="50%" y="50%" fill="#dee2e6" dy=".3em">64x64</text>
    </svg>
    <div class="media-body">
      <a class="mt-0 mb-1 font-weight-bold" href="syousai.php">店名</a>
      <p>広告依頼内容簡単に記述、クリックで詳細画面へ</p>
    </div>
  </li>
  </br>
  <li class="media">
    <svg class="bd-placeholder-img mr-3" width="64" height="64" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 64x64">
      <title>Placeholder</title>
      <rect width="100%" height="100%" fill="#868e96" /><text x="50%" y="50%" fill="#dee2e6" dy=".3em">64x64</text>
    </svg>
    <div class="media-body">
      <a class="mt-0 mb-1 font-weight-bold" href="syousai.php">店名</a>
      <p>広告依頼内容簡単に記述、クリックで詳細画面へ</p>
    </div>
  </li>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script>
    $(function() {
      $("#datepicker").datepicker();
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>


<!-- FOOTER -->
<footer class="container">
  <p class="float-right"><a href="#">Back to top</a></p>
  <p>&copy; 2017-2018 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
</footer>
</main>

</html>