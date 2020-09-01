<?php

require_once(__DIR__ . '/config.php');

$images = '';


if (!function_exists('imagecreatetruecolor')) {
  echo 'GD not installed';
  exit;
}

require 'Imageuploader.php';

$uploader = new \MyApp\ImageUploader();

$job_title = $_POST['job_title'];
$job_body = $_POST['job_body'];


// if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//   $images = $uploader->upload();
//   $images = 'uploaded_userprofile' . '/'  .  $images;

// if (isset($_SESSION['id'])) {
// try {
//   $db = new Db_jobs();
//   $pdo = $db->dbConnect_jobs();
//   $stmt = $pdo->prepare("UPDATE job SET job_img_path =? WHERE job . shop_id=?");
//   $stmt->bindParam(1, $images, PDO::PARAM_STR);
//   $stmt->bindParam(2, $_SESSION['login_shop_id'], PDO::PARAM_INT);
//   $stmt->execute();
//   $stmt->debugDumpParams();
// } catch (PDOException $e) {
//   echo $e->getMessage();
// }
// }
// }



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
    <input type="hidden" name="job_title" value="<?php echo $job_title ?>">
    <input type="hidden" name="job_body" value=<?php echo $job_body ?>">


    <h1 class="contact-title">紹介画像アップロード</h1>
    <div class="container-fluid col-md-3">
      <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo h(MAX_FILE_SIZE); ?>">
      <div class="input-group row">
        <div class="custom-file col-mb-3">
          <input type="file" class="custom-file-input" name="image">
          <label class="custom-file-label" for="inputGroupFile01">ファイルを選択</label>
          <!-- <label class="custom-file-label" for="inputGroupFile04">Choose file</label> -->
        </div>
      </div>
    </div>

    <button class="btn btn-primary" type="submit" value="upload" name="update_image">画像をアップロードする</button>
  </form>


  <img src="<?= h($images); ?>">


  <?php if (isset($success)) : ?>
    <div class="msg success">
      <h1><?php echo h($success); ?></h1>
    <?php endif; ?>
    <?php if (isset($error)) : ?>
      <div class="msg error"><?php echo h($error); ?>
      <?php endif; ?>



      </br>
      <!-- <div class="input-group-append">
              </div> -->
      </br>

      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <script>
        $(function() {
          $('.msg').fadeOut(3000);
        });
      </script>
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>