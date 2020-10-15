<?php

require_once(__DIR__ . '/config.php');


if (isset($_SESSION['login'])) {
  $db = new Db();
  $pdo = $db->dbConnect();
  $id = $_SESSION['id'];
  $sql = "SELECT * FROM userdata WHERE id='$id'";
  $stmt = $pdo->query($sql);
  foreach ($stmt as $row) {
    $username = $row['username'];
    $location = $row['pref'];
    $introduction = $row['introduction'];
  }
}
if (isset($_SESSION['me'])) {
  $db = new Db();
  $pdo = $db->dbConnect();
  $id = $_SESSION['me_id'];
  $sql = "SELECT * FROM userdata WHERE id='$id'";
  $stmt = $pdo->query($sql);
  foreach ($stmt as $row) {
    $username = $row['username'];
    $location = $row['pref'];
    $introduction = $row['introduction'];
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $success = null;
  $error = null;
  $username_edit = $_POST['username'];
  $location_edit = $_POST['location'];
  $introduction_edit = $_POST['introduction'];
  try {
    $db = new Db();
    $pdo = $db->dbConnect();
    $stmt = $pdo->prepare("UPDATE userdata SET username=?, pref=?, introduction=? WHERE id='$id'");

    $stmt->bindParam(1, $username_edit, PDO::PARAM_STR);
    $stmt->bindParam(2, $location_edit, PDO::PARAM_STR);
    $stmt->bindParam(3,  $introduction_edit, PDO::PARAM_STR);
    $_SESSION['login'] = $username;
    $stmt->execute();
    // $stmt->debugDumpParams();

    $result = $stmt->rowCount(PDO::FETCH_ASSOC);
    $_SESSION['success'] = '更新しました';
  } catch (Exception $e) {
    $errorMessage = 'エラーが発生しました。';
    $_SESSION['error'] = $e->getMessage();
  }
  if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['error']);
  } elseif ($_SESSION['error']) {
    $error = $_SESSION['error'];
    unset($_SESSION['success']);
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
            <a class="nav-link" href="confirm\confirm_input.php">お問い合わせ</a>
          </li>
        </ul>
  </header>
  </br>
  </br>
  </br>
  <h1 class="contact-title">プロフィール編集画面</h1>


  <form action="<?php print($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data" method="post" name="edit" onsubmit="return validate()">

    <div class="container-fluid col-md-6">

      <!-- <div class="row center-block"> -->
      <div class="form-group">
        <label>Username</label>
        <input class="form-control" type="text" name="username" value="<?php if (isset($_SESSION['login']) or (isset($_SESSION['me']))) {
                                                                          echo $username;
                                                                        } ?>">
      </div>
      <div class="form-group">
        <label>Location</label>
        <input class="form-control" type="text" name="location" value="<?php if (isset($_SESSION['login']) or (isset($_SESSION['me']))) {
                                                                          echo $location;
                                                                        } ?>">
      </div>
      <div class="form-group">
        <label>自己紹介</label>
        <textarea class="form-control" name="introduction" rows="10"><?php if (isset($_SESSION['login']) or (isset($_SESSION['me']))) {
                                                                        echo  $introduction;
                                                                      } ?></textarea>
      </div>
      </br>

      <a class="btn btn-secondary" role=button href="mypage_user.php?id=<?= $id; ?>">マイページへ戻る</a>

      <button class="btn btn-primary float-right" type="submit" name="edit">変更を適用する</button>
      </br>
      </br>
      <?php if (isset($success)) : ?>
        <h3 class="text-left"><?php echo h($success); ?></h3>
      <?php endif; ?>
      <?php if (isset($error)) : ?>
        <h3 class="text-left"><?php echo h($error); ?></h3>
      <?php endif; ?>
    </div>
  </form>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>


</html>