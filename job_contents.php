<?php

require_once(__DIR__ . '/config.php');


$id = $_GET['id'];
echo $id;

$db = new Db();
$pdo = $db->dbConnect();
$sql = "SELECT * FROM job WHERE job_id='$id'";
echo $sql;
$stmt = $pdo->query($sql);
foreach ($stmt as $row) {
  $job_id = $row['job_id'];
  $shop_id = $row['shop_id'];
  $data_job_started = $row['date_job_started'];
  $job_title = $row['job_title'];
  $job_img = $row['job_img_path'];
  $job_body = $row['job_body'];
  $job_status = $row['job_status'];
}
$pdo = null;


if (isset($_SESSION['login'])) {
  $contacted_user = $_SESSION['id'];
}

// $_SESSIONを使って保存できるようにする配列Array


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $db = new Db();
    $pdo = $db->dbConnect();
    $sql = $pdo->prepare("UPDATE job SET contacted_user_id='$contacted_user'  WHERE job_id='$job_id'");

    $stmt->execute();
    $stmt->debugDumpParams();
  } catch (PDOException $e) {
    $errorMessage = 'データベースエラー';
    echo $e->getMessage();
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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-jJ2L/Ujk8jWEwtIXPFEk3X+f20QKnj4IIscn+JZzxqkbAUC79idDdiAhAi2E7czT" crossorigin="anonymous">
</head>

<body>

  <h1>
    タイトル(<?= $job_title ?>)
  </h1>



  <img src="<?= h($job_img); ?>">
  <p>job_id(<?= $job_id ?>)</p>
  <p>shop_id(<?= $shop_id ?>)</p>
  <p>ジョブが作られた日(<?= $data_job_started ?>)</p>
  <p>
    本文(<?= $job_body ?>)
  </p>


  <form action="job_contact_form.php" method="post">
    <?php if (isset($SESSION['login'])) : ?>
      <input type="hidden" name="contacted_user" value="<?php echo $contacted_user; ?>">
      <input type="hidden" name="job_id" value="<?php echo $job_id; ?>">
      <button class="btn btn-primary" type="submit">申し込む</button>
    <?php endif; ?>
  </form>























  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-K09cMhJkkwNoZK1BRIJX6fQk06LqHSs8LdWAE24M/18F4NlePaltFx1cnB9wKwQX" crossorigin="anonymous"></script>
</body>

</html>