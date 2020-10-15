<?php
require_once(__DIR__ . '/config.php');
$job_id = $_SESSION['job_id'];
$shop_id = $_SESSION['shop_id'];
$db = new Db();
$pdo = $db->dbConnect();

$sql = "SELECT * FROM job WHERE job_id='$job_id'";
$stmt = $pdo->query($sql);
foreach ($stmt as $row) {
  $id = $row['job_id'];
  $job_title = $row['job_title'];
  $job_body = $row['job_body'];
  $job_img = $row['job_img_path'];
  $like = $row['needs_like'];
  $area = $row['area'];
  $age = $row['age'];
  $reward = $row['reward'];
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
      </div>
    </nav>
  </header>
  </br>
  </br>
  </br>
  <div class="container">
    <h1>申し込みが完了しました。</h1>
    <ul>
      <li class="media justify-content-md-center">
        <span class="border border-right-0 border-left-0">
          <div class="row">
            <img class="pull-left img-responsive m-md-3" width="300" height="300" src="<?= $job_img ?>">
            <ul>
              <a class="mt-0 mb-1 font-weight-bold" href="job_contents.php?id=<?= $id ?>">
                <h3><?= htmlspecialchars($job_title, ENT_QUOTES, 'UTF-8'); ?>
              </a></h3>
              <p>エリア:<?= $area ?></p>
              <p>ターゲット年齢層:<?= $age ?>代</p>
              <p>必要いいね数:<?= $like ?></p>
              <p class="d-inline-block text-truncate" style="max-width: 150px;">募集要項:<?= $job_body; ?></p>
              </br>
              <p class="d-inline-block text-truncate" style="max-width: 150px;">特典:<?= $reward ?></p>
            </ul>
          </div>

        </span>
      </li>

    </ul>

    <div class="row row-cols-1">
      <div class="row col ml-1">
        <h3>早速ツイートする</h3>
        <div class="mt-1">
          <a class="twitter-share-button" href="https://twitter.com/intent/tweet" data-size="large" data-url="　" data-text="#食バズ #<?= $job_title ?>">
          </a>
        </div>
      </div>
    </div>
    <div class="row row-cols-1">
      <div class="col mt-2">
        <?php
        if (isset($_SESSION['login'])) : ?>
          <a href="mypage_user.php?id=<?= ($_SESSION['id']); ?>">
            <h3>マイページへ戻る</h3>
          </a>
        <?php elseif (isset($_SESSION['me'])) : ?>
          <a href="mypage_user.php?id=<?= $_SESSION['me_id']; ?>">
            <h3>マイページへ戻る</h3>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script>
    window.twttr = (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0],
        t = window.twttr || {};
      if (d.getElementById(id)) return t;
      js = d.createElement(s);
      js.id = id;
      js.src = "https://platform.twitter.com/widgets.js";
      fjs.parentNode.insertBefore(js, fjs);

      t._e = [];
      t.ready = function(f) {
        t._e.push(f);
      };

      return t;
    }(document, "script", "twitter-wjs"));
  </script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>