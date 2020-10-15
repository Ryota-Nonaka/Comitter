<?php
require_once(__DIR__ . '/config.php');


$id = $_GET['id'];
try {
  $db = new Db();
  $pdo = $db->dbConnect();
  $sql = "SELECT job_management.shop_id,job_id,job_title,job_body,job_img_path,area,user_id,username,email,pref,introduction,user_img_path,sex,age,followers_count,friends_count,needs_like,reward,shop_userdata.shop_name,business_hour_open,business_hour_close,regular_holiday,shop_img from job_management JOIN shop_userdata ON job_management.shop_id=shop_userdata.id WHERE user_id='$id' and status=1";
  $results = array();
  $stmt = $pdo->query($sql);


  foreach ($stmt as $row) {
    array_push($results, $row);
  }
  $count = $pdo->query("SELECT COUNT(*) FROM job_management WHERE user_id='$id' and status=1")
    ->fetchColumn();
} catch (PDOException $e) {
  $errorMessage = 'データベースエラー';
  echo $e->getMessage();
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
        <form class="form-inline mt-2 mt-md-0">
          <?php
          if (isset($_SESSION['login'])) : ?>
            <div class=text-light> ようこそ、<span class="text-primary"> <?= $_SESSION['login'] ?> </span>さん！</div>
            <a href="mypage_user.php?id=<?php echo ($_SESSION['id']); ?>">マイページへ</a>
          <?php elseif (isset($_SESSION['me'])) : ?>
            <div class=text-light> ようこそ、<span class="text-primary"> <?= $_SESSION['me']->username ?> </span>さん！</div>
            <a href="mypage_user.php?id=<?= $_SESSION['me_id'] ?>">マイページへ</a>
          <?php else : ?>
            <div class="row mr-3">
              <a href="signin_user.php">ユーザーログインはこちら</a>
              <a href="signin_shop.php">店舗会員ログインはこちら</a>
            </div>
          <?php endif; ?>



        </form>

      </div>
    </nav>

  </header>

  </br>
  </br>
  </br>
  <div class="container">
    <?php if ($count > 0) : ?>
      <div class="row justify-content-md-center mt-3">
        <h1>申請中の依頼</h1>
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
      </ul>
    <?php endforeach; ?>
  <?php elseif ($count == 0) : ?>
    <div class="row justify-content-md-center mt-3">
      <h1>申請中の依頼はまだありません。</h1>
    </div>
    <div class="row mt-3 justify-content-start">
      <div class="text-right">
        <a class="btn btn-primary" href="result.php" role="button">依頼を探しに行く。</a>
      </div>
    </div>
    <form>
      <div class="row mt-3 justify-content-start">
        <input class="btn btn-secondary" type="button" value="マイページへ戻る" onclick="history.back(-1)">
      </div>
    </form>
  </div>
<?php endif; ?>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>