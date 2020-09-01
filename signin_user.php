<?php
require 'config.php';

if (isset($_POST['email']) && ($_POST['password'])) {

  try {
    $db = new Db();
    $pdo = $db->dbConnect();
    $stmt = $pdo->prepare('select * from userdata where email = ?');
    $stmt->execute(array($_POST['email']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  } catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
  }



  //emailがDB内に存在しているか確認
  if (!isset($row['email'])) {
    echo 'メールアドレス又はパスワードが間違っています。';
    echo '<a href="index.php" class="badge badge-primary">トップページへ戻る</a>';
    return false;
  }
  //パスワード確認後sessionにメールアドレスを渡す
  if (password_verify($_POST['password'], $row['pass'])) {
    session_regenerate_id(true); //session_idを新しく生成し、置き換える
    $_SESSION['login'] = $row['username'];
    $_SESSION['id'] = $row['id'];
    header('Location:index.php');
    exit;
  } else {
    echo 'メールアドレス又はパスワードが間違っています。';
    echo '<a href="index.php" class="badge badge-primary">トップページへ戻る</a>';
    return false;
  }
}



?>

<!DOCTYPE html>
<html lang="ja">
サインインしたのちにマイページに飛ばす
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" />
  <link rel="stylesheet" href="src\css\signin.css" />
  <title>signin page</title>
</head>

<body class="container-fluid">
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
  </header>
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <div class="box">
        <div class="input-group">
          <span class="input-group-addon addon-facebook">
            <i class="fa fa-fw fa-2x fa-facebook fa-fw"></i>
          </span>
          <a class="btn btn-lg btn-block btn-facebook" id="twitter-button" href="#">
            Facebookアカウントでログイン</a>
        </div>

        <div class="input-group" id="twitter-button" data-provider="twitter">
          <span class="input-group-addon addon-twitter">
            <i class="fa fa-fw fa-2x fa-twitter fa-fw"></i>
          </span>
          <a class="btn btn-lg btn-block btn-twitter" href="login.php">
            Twitterアカウントでログイン</a>
        </div>



        <form role="form" action="signin_user.php" method="post">
          <div class="divider-form"></div>
          <div class="form-group">
            <label for="email">メールアドレス</label>
            <input name="email" type="email" class="form-control" id="email" placeholder="メールアドレスを入力してください" required>
          </div>

          <div class="divider-form"></div>

          <div class="form-group">
            <label for="exampleInputPassword1">パスワード</label>
            <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="パスワードを入力してください" required />
          </div>

          <div class="divider-form"></div>

          <p class="text-center">
            You agree to the <strong>Terms & Conditions</strong>.
          </p>

          <button type="submit" class="btn-block btn btn-lg btn-primary">
            サインインする
          </button>

          <p class="text-center">
            アカウントをお持ちでない方は <a href="new_account_user.php">新しくアカウントを作成する</a>
          </p>
        </form>
      </div>
    </div>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>

</html>