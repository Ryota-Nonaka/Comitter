<?php

require_once(__DIR__ . '/config.php');

$images = '';

$job_title = $_POST['job_title'];
$job_body = $_POST['job_body'];
$reward = $_POST['reward'];
$sex = $_POST['sex'];
$age = $_POST['age'];
$area = $_POST['area'];
$like = $_POST['needs_like'];

if (!function_exists('imagecreatetruecolor')) {
  echo 'GD not installed';
  exit;
}


require 'Imageuploader.php';
$uploader = new \MyApp\ImageUploader();

$images = $uploader->upload();
$images = 'uploaded_userprofile' . '/'  .  $images;


if (isset($_SESSION["login_shop"])) {
  $shop_id = $_SESSION['login_shop_id'];
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
      $db = new Db();
      $pdo = $db->dbConnect();
      $stmt = $pdo->prepare("INSERT INTO job(job_title,job_body,job_img_path,shop_id,area,age,needs_like,reward,date_job_started) VALUES(:job_title,:job_body,:job_img_path,:shop_id,:area,:age,:needs_like,:reward,now())");

      $stmt->bindParam(':job_title', $job_title, PDO::PARAM_STR);
      $stmt->bindParam(':job_body', $job_body, PDO::PARAM_STR);
      $stmt->bindParam(':job_img_path', $images, PDO::PARAM_STR);
      $stmt->bindParam(':shop_id', $shop_id, PDO::PARAM_INT);
      $stmt->bindParam(':area', $area, PDO::PARAM_STR);
      $stmt->bindParam(':age', $age, PDO::PARAM_STR);
      $stmt->bindParam(':needs_like', $like, PDO::PARAM_STR);
      $stmt->bindParam(':reward', $reward, PDO::PARAM_STR);
      $job_id = $pdo->lastInsertId('job_id');
      $stmt->execute();
    } catch (PDOException $e) {
      $errorMessage = 'データベースエラー';
      echo $e->getMessage();
    }
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


</head>

<body>



  <div id="contents" class="container">
    <h1 class="contact-title center">依頼内容確認</h1>
    <p class="center">この内容で依頼投稿しますか？<br>よろしければ「投稿する」ボタンを押して下さい。</p>
    <div class="row justify-content-md-center">
      <h1 class="m-md-3 col-md-3 offset-md-3 font-weight-bold">
        <?= $job_title ?>
      </h1>
    </div>

    <div class="row justify-content-md-center">
      <img class="img-fluid" src="<?= h($images); ?>">
    </div>
    <div class="card">
      <div class="card-header alert alert-secondary m-0" role="alert">依頼内容</div>
      <table class=" table table-bordered m-0">
        <tbody>
          <tr>
            <th style="width:25%" scope="row">タイトル</th>
            <td style="width:75%"><?= $job_title ?></td>
          </tr>
          <tr>
            <th scope="row">必要いいね数</th>
            <td><?= $like ?> </td>
          </tr>
          <tr>
            <th scope="row">募集内容</th>
            <td><?= $job_body ?></td>
          </tr>
          <tr>
            <th scope="row">エリア</th>
            <td><?= $area ?></td>
          </tr>
          <tr>
            <th scope="row">特典</th>
            <td><?= $reward ?>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <form action="job.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="job_title" value="<?= $job_title; ?>">
      <input type="hidden" name="job_body" value="<?= $job_body; ?>">
      <input type="hidden" name="reward" value="<?= $reward; ?>">
      <input type="hidden" name="image" value="<?= h($images); ?>">
      <input type="hidden" name="sex" value="<?= $sex; ?>">
      <input type="hidden" name="age" value="<?= $age; ?>">
      <input type="hidden" name="area" value="<?= $area; ?>">
      <input type="hidden" name="needs_like" value="<?= $like; ?>">

      <div class="row pt-3">
        <div class="mr-3 ml-3">
          <input class="btn btn-secondary" type="button" value="内容を修正する" onclick="history.back(-1)">
        </div>

        <a href="job_posted.php" class="btn btn-primary" type="button">投稿する</a>
      </div>



      </table>
    </form>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>