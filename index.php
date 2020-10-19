<?php

require_once(__DIR__ . '/config.php');
date_default_timezone_set('Asia/Tokyo');
ini_set('display_errors', 1);

try {
  $db = new Db();
  $pdo = $db->dbConnect();
  $top3_jobs = array();
  $stmt = $pdo->prepare("SELECT job.job_id,shop_id,shop_userdata.shop_name,business_hour_open,business_hour_close,regular_holiday,shop_img,job.date_job_started,job_title,job_body,job_img_path,area,age,needs_like,reward FROM job JOIN shop_userdata ON job.shop_id=shop_userdata.id ORDER BY date_job_started desc LIMIT 3");
  $stmt->execute();
  foreach ($stmt as $row) {
    array_push($top3_jobs, $row);
  }
  $count = $pdo->query("SELECT COUNT(*) FROM job ORDER BY date_job_started desc")
    ->fetchColumn();
} catch (PDOException $e) {
  $errorMessage = 'データベースエラー';
  echo $e->getMessage();
}


if (isset($_GET['keyword']) && isset($_GET['area'])) {
  $keyword = htmlspecialchars($_GET['keyword']);
  $keyword_value = $keyword_search;
  $area = htmlspecialchars($_GET['area']);
  $area_value = $area;
} else if (!isset($_GET['keyword']) && isset($_GET['area'])) {
  $keyword = '';
  $keyword_value = $keyword;
  $area = htmlspecialchars($_GET['area']);
  $area_value = $area;
} else if (isset($_GET['keyword']) && !isset($_GET['area'])) {
  $keyword = htmlspecialchars($_GET['keyword']);
  $keyword_value = $keyword;
  $area = '';
  $area_value = $area;
} else {
  $keyword = '';
  $keyword_value = $keyword;
  $area = '';
  $area_value = $area;
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

  <main role="main">

    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img class="first-slide" src="src\images\3.jpg" alt="First slide">
          <div class="container">
            <div class="carousel-caption text-left">
            </div>
          </div>
        </div>

      </div>
    </div>


    <div class="container-fluid">
      <form method="get" action="result.php">
        <div class="form-group row justify-content-md-center" class="col-form-label">
          <label for="keyword" class="text-left text-secondary mr-3">キーワード・エリアで検索</label>
          <div class="col-sm-XX pr-3">
            <input type="text" class="form-control" placeholder="キーワード" name="keyword" id="keyword">
          </div>
          <div class="col-sm-XX pr-3">
            <input type="text" class="form-control" placeholder="エリア" name="area" id="area">
          </div>
          <input class="btn btn-secondary" type="submit" id="page" value="検索">
        </div>
      </form>
    </div>
    </br>
カード横並びで表示させる。
    <div class="container">
      <h1 class="text-dark ml-3">最近投稿された依頼</h1>
      <?php if ($count > 0) : ?>
        <ul class="list-group list-group-horizontal">
          <div class="row">
            <li class="media  justify-content-md-center mx-5">
              <span class="border border-right-0 border-left-0"">
              <div class=" row">
                <img class="pull-left img-responsive m-md-3" width="100" height="300" src="<?= $top3_jobs[0]['job_img_path']; ?>">
                <ul class="text-dark">
                  <a class="mt-0 mb-1 font-weight-bold" href="job_contents.php?id=<?= $top3_jobs[0]['job_id']; ?>">
                    <h3><?= htmlspecialchars($top3_jobs[0]['job_title'], ENT_QUOTES, 'UTF-8'); ?>
                  </a></h3>
                  <p>店名:<?= $top3_jobs[0]['shop_name']; ?></p>
                  <p>営業時間:<?= $top3_jobs[0]['business_hour_open']; ?>～<?= $top3_jobs[0]['business_hour_close']; ?></p>
                  <p>エリア:<?= $top3_jobs[0]['area']; ?></p>
                  <p>ターゲット年齢層:<?= $top3_jobs[0]['age']; ?>代</p>
                  <p>必要いいね数:<?= $top3_jobs[0]['needs_like'] ?></p>
                  <p class="d-inline-block text-truncate" style="max-width: 150px;">募集要項:<?= $top3_jobs[0]['job_body']; ?></p>
                  <p class="d-inline-block text-truncate" style="max-width: 150px;">特典:<?= $top3_jobs[0]['reward'] ?></p>
                  <p class="text-secondary"><?= date('Y年m月d日 H', strtotime($top3_jobs[0]['date_job_started'])); ?>時頃投稿されました。</p>
                </ul>
          </div>

          </span>
          </li>
    </div>
  <?php endif; ?>
  <?php if ($count >= 2) : ?>
    <li class="media justify-content-md-center mr-3">
      <span class="border border-right-0 border-left-0"">
            <div class=" row">
        <img class="pull-left img-responsive m-md-3" width="100" height="300" src="<?= $top3_jobs[1]['job_img_path']; ?>">
        <ul class="text-dark">
          <a class="mt-0 mb-1 font-weight-bold" href="job_contents.php?id=<?= $top3_jobs[1]['job_id']; ?>">
            <h3><?= htmlspecialchars($top3_jobs[1]['job_title'], ENT_QUOTES, 'UTF-8'); ?>
          </a></h3>
          <p>店名:<?= $top3_jobs[1]['shop_name']; ?></p>
          <p>営業時間:<?= $top3_jobs[1]['business_hour_open']; ?>～<?= $top3_jobs[1]['business_hour_close']; ?></p>
          <p>エリア:<?= $top3_jobs[1]['area']; ?></p>
          <p>ターゲット年齢層:<?= $top3_jobs[1]['age']; ?>代</p>
          <p>必要いいね数:<?= $top3_jobs[1]['needs_like'] ?></p>
          <p class="d-inline-block text-truncate" style="max-width: 150px;">募集要項:<?= $top3_jobs[1]['job_body']; ?></p>
          <p class="d-inline-block text-truncate" style="max-width: 150px;">特典:<?= $top3_jobs[1]['reward'] ?></p>
          <p class="text-secondary"><?= date('Y年m月d日 H', strtotime($top3_jobs[1]['date_job_started'])); ?>時頃投稿されました。</p>
        </ul>
        </div>

      </span>
    </li>
  <?php endif; ?>
  <?php if ($count >= 3) : ?>
    <li class="media justify-content-md-center mr-3 ">
      <span class="border border-right-0 border-left-0"">

            <div class=" row">
        <img class="pull-left img-responsive m-md-3" width="100" height="300" src="<?= $top3_jobs[2]['job_img_path']; ?>">
        <ul class="text-dark">
          <a class="mt-0 mb-1 font-weight-bold" href="job_contents.php?id=<?= $top3_jobs[2]['job_id']; ?>">
            <h3><?= htmlspecialchars($top3_jobs[2]['job_title'], ENT_QUOTES, 'UTF-8'); ?>
          </a></h3>
          <p>店名:<?= $top3_jobs[2]['shop_name']; ?></p>
          <p>営業時間:<?= $top3_jobs[2]['business_hour_open']; ?>～<?= $top3_jobs[2]['business_hour_close']; ?></p>
          <p>エリア:<?= $top3_jobs[2]['area']; ?></p>
          <p>ターゲット年齢層:<?= $top3_jobs[2]['age']; ?>代</p>
          <p>必要いいね数:<?= $top3_jobs[2]['needs_like'] ?></p>
          <p class="d-inline-block text-truncate" style="max-width: 150px;">募集要項:<?= $top3_jobs[2]['job_body']; ?></p>
          <p class="d-inline-block text-truncate" style="max-width: 150px;">特典:<?= $top3_jobs[2]['reward'] ?></p>
          <p class="text-secondary"><?= date('Y年m月d日 H', strtotime($top3_jobs[2]['date_job_started'])); ?>時頃投稿されました。</p>
        </ul>
        </div>

      </span>
    </li>
  <?php endif; ?>
  </div>
  </br>
  </ul>

  </div>

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