<?php
require_once(__DIR__ . '/config.php');
define('COMMENTS_PER_PAGE', 5);

if (isset($_GET['page']) && preg_match('/^[1-9][0-9]*/', $_GET['page'])) {
  $page = (int)$_GET['page'];
} else {
  $page = 1;
}



error_reporting(E_ALL & ~E_NOTICE);
$offset = COMMENTS_PER_PAGE * ($page - 1);

$db = new Db();
$pdo = $db->dbConnect();
$results = array();
$result = array();
if (isset($_GET['keyword']) && isset($_GET['area'])) {
  $keyword = htmlspecialchars($_GET['keyword']);
  $keyword_value = $keyword_search;
  $area = htmlspecialchars($_GET['area']);
  $area_value = $area;

  $sql = "SELECT job.job_id,shop_id,shop_userdata.shop_name,business_hour_open,business_hour_close,regular_holiday,shop_img,job.date_job_started,job_title,job_body,job_img_path,area,age,needs_like,reward FROM job JOIN shop_userdata ON job.shop_id=shop_userdata.id WHERE job_title LIKE '%$keyword%' AND area LIKE '%$area%' LIMIT " . $offset . "," . COMMENTS_PER_PAGE;

  $stmt = $pdo->query($sql);
  foreach ($stmt as $row) {
    array_push($results, $row);
  }

  $total = $pdo->query("select count(*) from job where job_title LIKE '%$keyword%' AND area LIKE '%$area%'")->fetchColumn();
  $totalPages = ceil($total / COMMENTS_PER_PAGE);
} else if (!isset($_GET['keyword']) && isset($_GET['area'])) {
  $keyword = '';
  $keyword_value = $keyword;
  $area = htmlspecialchars($_GET['area']);
  $area_value = $area;

  $sql = "SELECT job.job_id,shop_id,shop_userdata.shop_name,job.date_job_started,business_hour_open,business_hour_close,regular_holiday,shop_img,job_title,job_body,job_img_path,area,age,needs_like,reward FROM job JOIN shop_userdata ON job.shop_id=shop_userdata.id  where area  LIKE '%$area%' LIMIT " . $offset . "," . COMMENTS_PER_PAGE;

  $stmt = $pdo->query($sql);
  foreach ($stmt as $row) {
    array_push($results, $row);
  }
  $total = $pdo->query("select count(*) from job where job_title LIKE '%$keyword%' AND location LIKE '%$area%'")->fetchColumn();
  $totalPages = ceil($total / COMMENTS_PER_PAGE);
} else if (isset($_GET['keyword']) && !isset($_GET['area'])) {
  $keyword = htmlspecialchars($_GET['keyword']);
  $keyword_value = $keyword;
  $area = '';
  $area_value = $area;
  $sql = "SELECT job.job_id,shop_id,shop_userdata.shop_name,business_hour_open,business_hour_close,regular_holiday,shop_img,job.date_job_started,job_title,job_body,job_img_path,area,age,needs_like,reward FROM job JOIN shop_userdata ON job.shop_id=shop_userdata.id where job_title LIKE '%$keyword%' LIMIT " . $offset . "," . COMMENTS_PER_PAGE;
  $stmt = $pdo->query($sql);
  foreach ($stmt as $row) {
    array_push($results, $row);
  }

  $total = $pdo->query("select count(*) from job where job_title LIKE '%$keyword%' AND area LIKE '%$area%'")->fetchColumn();
  $totalPages = ceil($total / COMMENTS_PER_PAGE);
} else {
  $keyword = '';
  $keyword_value = $keyword;
  $area = '';
  $area_value = $area;

  $sql = "SELECT job.job_id,shop_id,shop_userdata.shop_name,business_hour_open,business_hour_close,regular_holiday,shop_img,job.date_job_started,job_title,job_body,job_img_path,area,age,needs_like,reward FROM job JOIN shop_userdata ON job.shop_id=shop_userdata.id  LIMIT " . $offset . "," . COMMENTS_PER_PAGE;

  $stmt = $pdo->query($sql);
  foreach ($stmt as $row) {
    array_push($results, $row);
  }
  $total = $pdo->query("select count(*) from job where job_title LIKE '%$keyword%' AND area LIKE '%$area%'")->fetchColumn();
  $totalPages = ceil($total / COMMENTS_PER_PAGE);
}







$from = $offset + 1;
$to = $offset + COMMENTS_PER_PAGE < $total ? ($offset + COMMENTS_PER_PAGE)
  : $total;




?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <title>依頼一覧</title>
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

横幅をcol2:mg-8位の比率で作る
  </br>
  </br>
  </br>
  <div class="container-fluid">
    <form method="get" action="result.php">
      <div class="form-group row justify-content-md-center" class="col-form-label">
        <label for="keyword" class="text-left text-secondary mr-3">キーワード・エリアで検索</label>
        <div class="col-sm-XX">
          <input type="text" class="form-control" placeholder="キーワード" name="keyword" id="keyword" value="<?= $name_search_value ?>">
        </div>
        <div class="col-sm-XX">
          <input type="text" class="form-control" placeholder="エリア" name="area" id="area" value="<?= $location_search_value ?>">
        </div>
        <input type="hidden" name="page" value="<?= $page ?>">
        <input class="btn btn-secondary" type="submit" id="page" value="検索">
      </div>
    </form>
    <div class="row justify-content-md-center">
      <h1 class="m-md-3 col-md-3 offset-md-3 font-weight-bold">フォロ割一覧</h1>
    </div>
    <div class="row justify-content-md-center">
      <p class="m-md-3 col-md-3 offset-md-3">全<?php echo $total; ?>件中、<?php echo $from; ?>件〜<?php echo $to; ?>件を表示しています。</p>
    </div>

    <ul>

      <?php foreach ($results as $result) : ?>
        <li class="media justify-content-md-center">
          <span class="border border-right-0 border-left-0">
            <div class="row">
              <img class="pull-left img-responsive m-md-3" width="300" height="300" src="<?= $result['job_img_path']; ?>">
              <ul>
                <a class="mt-0 mb-1 font-weight-bold" href="job_contents.php?id=<?= $result['job_id']; ?>">
                  <h3><?= htmlspecialchars($result['job_title'], ENT_QUOTES, 'UTF-8'); ?>
                </a></h3>
                <p>店名:<?= $result['shop_name']; ?></p>
                <p>営業時間:<?= $result['business_hour_open']; ?>～<?= $result['business_hour_close']; ?></p>
                <p>エリア:<?= $result['area']; ?></p>
                <p>ターゲット年齢層:<?= $result['age']; ?>代</p>
                <p>必要いいね数:<?= $result['needs_like'] ?></p>
                <p class="d-inline-block text-truncate" style="max-width: 150px;">募集要項:<?= $result['job_body']; ?></p>
                </br>
                <p class="d-inline-block text-truncate" style="max-width: 150px;">特典:<?= $result['reward'] ?></p>
              </ul>
            </div>

          </span>
        </li>
        </br>
      <?php endforeach; ?>
    </ul>
    <div class="row justify-content-md-center">
      <nav aria-label="">
        <ul class="pagination">
          <?php if ($page > 1) : ?>
            <li class="page-item"><a class="page-link" href="?page=<?= $page - 1; ?>">前へ</a>
            </li>
          <?php endif; ?>
          <?php for ($i = 1; $i <= $totalPages; $i++) : ?>

            <li class="page-item"><a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a></li>
          <?php endfor; ?>
          <?php if ($page < $totalPages) : ?>

            <li class="page-item"><a class="page-link" href="?page=<?= $page + 1; ?>">次へ</a>
            </li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </div>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>