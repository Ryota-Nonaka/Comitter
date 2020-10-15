<?php

require_once(__DIR__ . '/config.php');

$id = $_GET['id'];
$results = array();
$result = array();
try {
  $db = new Db();
  $pdo = $db->dbConnect();
  $sql = "SELECT job.job_id,shop_id,shop_userdata.shop_name,shop_tell,shop_email,shop_zip,shop_pref,shop_addr,business_hour_open,business_hour_close,regular_holiday,shop_url,job.date_job_started,job_title,job_body,job_img_path,area,age,needs_like,reward FROM job JOIN shop_userdata ON job.shop_id=shop_userdata.id WHERE job.shop_id='$id'";

  $stmt = $pdo->query($sql);
  foreach ($stmt as $row) {
    array_push($results, $row);
  }
  $count = $pdo->query("SELECT COUNT(*) FROM job WHERE shop_id='$id'")
    ->fetchColumn();
} catch (PDOException $e) {
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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

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


          if (isset($_SESSION['login_shop'])) : ?>
            <div class=text-light> ようこそ、<span class="text-primary"><?php echo $_SESSION['login_shop']; ?> </span>さん！</div>
            <a href='mypage_shop.php?shop_name=<?php echo ($_SESSION['login_shop']); ?>'>マイページへ</a>
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
          </div>
        </div>
      </div>
    </div>
  </div>
  </br>
  </br>

  <div class="container">
    <?php if ($count > 0) : ?>
      <div class="row justify-content-md-center mt-3">
        <h1>投稿中の依頼</h1>
      </div>
      <?php foreach ($results as $result) : ?>
        <ul>
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
                  <p>特典:<?= $result['reward'] ?></p>
                </ul>
              </div>
          </li>
        </ul>
      <?php endforeach; ?>


    <?php elseif ($count == 0) : ?>
      <div class="row justify-content-md-center mt-3">
        <h1>投稿された依頼はまだありません。</h1>
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
</div>




<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>

</html>