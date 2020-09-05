<?php

require_once(__DIR__ . '/config.php');

$images = '';


if (!function_exists('imagecreatetruecolor')) {
  echo 'GD not installed';
  exit;
}

require 'Imageuploader.php';

$uploader = new \MyApp\ImageUploader();
$images = $uploader->upload();
$images = 'uploaded_userprofile' . '/'  .  $images;

$job_title = $_POST['job_title'];
$job_body = $_POST['job_body'];
$pref = $_POST['pref'];
$age = $_POST['age'];

if (isset($_SESSION["login_shop"])) {
  $shop_id = $_SESSION['login_shop_id'];
  $job_status = 1;
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
      $db = new Db();
      $pdo = $db->dbConnect();
      $stmt = $pdo->prepare("INSERT INTO job(job_title, job_body,job_img_path,date_job_started,shop_id, job_status, location, age) VALUES(:job_title, :job_body, :job_img_path, now(),:shop_id,:job_status,:location, :age )");

      $stmt->bindParam(':job_title', $job_title, PDO::PARAM_STR);
      $stmt->bindParam(':job_body', $job_body, PDO::PARAM_STR);
      $stmt->bindParam(':job_img_path', $images, PDO::PARAM_STR);
      $stmt->bindParam(':shop_id', $shop_id, PDO::PARAM_INT);
      $stmt->bindParam(':job_status', $job_status, PDO::PARAM_STR);
      $stmt->bindParam(':location', $pref, PDO::PARAM_STR);
      $stmt->bindParam(':age', $age, PDO::PARAM_STR);
      $stmt->execute();
      $stmt->debugDumpParams();
    } catch (PDOException $e) {
      $errorMessage = 'データベースエラー';
      echo $e->getMessage();
    }
  }
}

var_dump($shop_id);
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


  <form action="job.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="job_title" value="<?php echo $job_title; ?>">
    <input type="hidden" name="job_body" value="<?php echo $job_body; ?>">
    <input type="hidden" name="image" value="<?php echo h($images); ?>">
    <input type="hidden" name="pref" value="<?php echo $pref; ?>">
    <input type="hidden" name="age" value="<?php echo $age; ?>">
    <h1 class="contact-title center">依頼内容確認</h1>
    <p class="center">この内容で依頼投稿しますか？<br>よろしければ「投稿する」ボタンを押して下さい。</p>

    <table class="table">
      <tbody>
        <tr>
          <th scope="row">title</th>
          <td><?php echo $job_title; ?></td>
        </tr>
      </tbody>

      <tbody>
        <tr>
          <th scope="row">内容</th>
          <td><?php echo $job_body; ?></td>
        </tr>

      </tbody>
      <tbody>
        <tr>
          <th scope="row">画像</th>
          <td><img src="<?php echo h($images); ?>"></td>
        </tr>
      </tbody>
      <tbody>
        <tr>
          <th scope="row">エリア</th>
          <td><?php echo $pref; ?></td>
        </tr>
      </tbody>
      <tbody>
        <tr>
          <th scope="row">年齢</th>
          <td>"<?php echo $age; ?></td>
        </tr>
      </tbody>

    </table>
    <input class="btn btn-primary" type="button" value="内容を修正する" onclick="history.back(-1)">
    <a href="job_posted.php" class="btn btn-primary" type="submit" name="submit">投稿する</a>
  </form>



  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>