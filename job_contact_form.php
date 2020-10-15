<?php
require_once(__DIR__ . '/config.php');

$contacted_user = $_POST['contacted_user'];
$job_id = $_POST['job_id'];
$shop_id = $_POST['job_shop_id'];
$errorMessage = "";

$db = new Db();
$pdo = $db->dbConnect();
$sql = $pdo->prepare("SELECT * FROM userdata WHERE id='$contacted_user'");
$sql->execute();
foreach ($sql as $row) {
  $user_id = $row['id'];
  $username = $row['username'];
  $email = $row['email'];
  $pref = $row['pref'];
  $introduction = $row['introduction'];
  $profile_img = $row['img_path'];
  $sex = $row['sex'];
  $age = $row['age'];
  $followers = $row['followers_count'];
  $friends = $row['friends_count'];
}
$db = new Db();
$pdo = $db->dbConnect();
$sql = "SELECT * FROM job WHERE job_id='$job_id'";
$stmt = $pdo->query($sql);
foreach ($stmt as $row) {
  $job_title = $row['job_title'];
  $job_body = $row['job_body'];
  $job_img = $row['job_img_path'];
  $area = $row['area'];
  $like = $row['needs_like'];
  $reward = $row['reward'];
}
if (isset($_POST['regist'])) {
  try {
    $db = new Db();
    $pdo = $db->dbConnect();
    $stmt = $pdo->prepare("INSERT INTO job_management(shop_id,job_id,job_title,job_body,job_img_path,area,user_id,username,email,pref,introduction,user_img_path,sex,age,followers_count,friends_count,status,created,modified,reward,needs_like) VALUES(:shop_id,:job_id,:job_title,:job_body,:job_img_path,:area,:user_id,:username,:email,:pref,:introduction,:user_img_path,:sex,:age,:followers_count,:friends_count,1,now(),now(),:reward,:needs_like)");
    $stmt->bindParam(':shop_id', $shop_id, PDO::PARAM_INT);
    $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    $stmt->bindParam(':job_title', $job_title, PDO::PARAM_STR);
    $stmt->bindParam(':job_body', $job_body, PDO::PARAM_STR);
    $stmt->bindParam(':job_img_path', $job_img, PDO::PARAM_STR);
    $stmt->bindParam(':area', $area, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':pref', $pref, PDO::PARAM_STR);
    $stmt->bindParam(':introduction', $introduction, PDO::PARAM_STR);
    $stmt->bindParam(':user_img_path', $profile_img, PDO::PARAM_STR);
    $stmt->bindParam(':sex', $sex, PDO::PARAM_STR);
    $stmt->bindParam(':age', $age, PDO::PARAM_STR);
    $stmt->bindParam(':followers_count', $followers, PDO::PARAM_STR);
    $stmt->bindParam(':friends_count', $friends, PDO::PARAM_STR);
    $stmt->bindParam(':reward', $reward, PDO::PARAM_STR);
    $stmt->bindParam(':needs_like', $like, PDO::PARAM_STR);


    $stmt->execute();
    $stmt->debugDumpParams();
    $_SESSION['job_id'] = $job_id;
    $_SESSION['shop_id'] = $shop_id;
    header('Location:job_contact_success.php');
  } catch (PDOException $e) {
    $errorMessage = '現在申請中です。申請先店舗の承認をお待ちください。';
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

  </br>
  </br>
  <div id="contents" class="container">

    <div class="card">
      <div class="card-header alert alert-success m-0" role="alert">
        <h1 class="m-md-3 font-weight-bold">
          <?= $job_title ?>
        </h1>
      </div>
    </div>


    <div class="row justify-content-md-center">
      <img class="img-fluid" src="<?= h($job_img); ?>">
    </div>
    <div class="card">
      <div class="card-header alert alert-secondary m-0" role="alert">依頼内容</div>
      <table class=" table table-bordered m-0">
        <tbody>
          <tr>
            <th style="width:25%" scope="row">ジョブNo.</th>
            <td style="width:75%"><?= $job_id ?></td>
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
      <h1 class="text-center">このjobに申し込みますか？</h1>
      <div>
        <font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font>
      </div>
      <div class="container mt-5 p-lg-5 bg-light">
        <form action="job_contact_form.php" method="post">
          <input type="hidden" name="contacted_user" value="<?= $contacted_user; ?>">
          <input type="hidden" name="job_id" value="<?= $job_id; ?>">
          <input type="hidden" name="job_shop_id" value="<?= $shop_id; ?>">
          <div class="row">
            <div class="text-center col-sm-12">
              <button type="submit" class="btn btn-lg btn-primary" name="regist" value="submit">申し込む</button>
            </div>
          </div>
      </div>
      </form> <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>