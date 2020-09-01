<?php

require_once(__DIR__ . '/config.php');


// }

if (isset($_SESSION['login'])) {


  $db = new Db();
  $pdo = $db->dbConnect();
  $id = $_SESSION['id'];
  $sql = "SELECT * FROM userdata WHERE id='$id'";
  $stmt = $pdo->query($sql);
  foreach ($stmt as $row) {
    $username = $row['username'];
    $location = $row['pref01'];
    $introduction = $row['introduction'];
  }




  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username_edit = $_POST['username'];
    $location_edit = $_POST['location'];
    $introduction_edit = $_POST['introduction'];
    try {
      $db = new Db();
      $pdo = $db->dbConnect();
      $stmt = $pdo->prepare("UPDATE userdata SET username=?, pref01=?, introduction=? WHERE id='$id'");

      $stmt->bindParam(1, $username_edit, PDO::PARAM_STR);
      $stmt->bindParam(2, $location_edit, PDO::PARAM_STR);
      $stmt->bindParam(3,  $introduction_edit, PDO::PARAM_STR);

      $stmt->execute();
      $stmt->debugDumpParams();

      $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
   catch (Exception $e) {
      echo 'エラーが発生しました。:' . $e->getMessage();
    }
}

if (isset($_SESSION['me'])) {
  $db = new Db();
  $pdo = $db->dbConnect();
  $id = $_SESSION['id'];
  $sql = "SELECT * FROM userdata WHERE id='$id'";
  $stmt = $pdo->query($sql);
  foreach ($stmt as $row) {
    $username = $row['username'];
    $Location = $row['pref01'];
    $introduction = $row['text'];
  }
  // if (isset($_POST['edit'])) {
  //   try {

  //     $stmt = $dbh->prepare('SELECT * FROM tw_userdata WHERE id = :id');

  //     $stmt->execute(array(':id' => $_GET["id"]));

  //     $result = 0;

  //     $result = $stmt->fetch(PDO::FETCH_ASSOC);
  //   } catch (Exception $e) {
  //     echo 'エラーが発生しました。:' . $e->getMessage();
  //   }
  // }
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
  <h1 class="contact-title">プロフィール編集画面</h1>

  <form action="<?php print($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data" method="post" name="edit" onsubmit="return validate()">

    <div class="container-fluid col-md-6">

      <!-- <div class="row center-block"> -->
      <div class="form-group">
        <label>Username</label>
        <input class="form-control" type="text" name="username" value="<?php if (isset($_SESSION['login'])) {
                                                                          echo $username;
                                                                        } ?>">
      </div>
      <!-- </div> -->
      <!-- <div class="form-group col-md-6 row"> -->

      <!-- </div> -->
      <!-- <div class="form-group col-md-6 row"> -->
      <label>Location</label>
      <input class="form-control" type="text" name="location" value="<?php if (isset($_SESSION['login'])) {
                                                                        echo $location;
                                                                      } ?>">
      <!-- </div> -->
      <!-- <div class="form-group col-md-6 row"> -->

      <label>自己紹介</label>
      <textarea class="form-control" name="introduction" rows="10"><?php if (isset($_SESSION['login'])) {
                                                                      echo  $introduction;
                                                                    } ?></textarea>
      <!-- </div> -->
      </br>
      <button class="btn btn-primary" type="submit2" name="edit">変更を適用する</button>
                                                                  </div>
  </form>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>