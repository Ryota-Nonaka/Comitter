<?php

require_once(__DIR__ . '/config.php');


//同じメールアドレスが使われていたらエラーを出したい


$errorMessage = "";
$signUpMessage = "";
$row = array();
//エラーカウントの変数を書く
//条件式の中にエラーカウントを足していき最後にエラーカウント0ならば認証処理する。
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST['username'])) {
    $errorMessage = 'ユーザーIDが未入力です。';
  } else if (empty($_POST['email'])) {
    $errorMessage = 'メールアドレスが入力されていません。';
  } else if (empty($_POST['pass'])) {
    $errorMessage = 'パスワードが未入力です。';
  } else if (empty($_POST['zip'])) {
    $errorMessage = '郵便番号を入力してください。';
  } else if (empty($_POST['pref'])) {
    $errorMessage = '住所を入力してください。';
  } else if (empty($_POST['addr'])) {
    $errorMessage = '住所を入力してください。';
  }
  if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['pass']) && !empty($_POST['zip']) && !empty($_POST['pref']) && !empty($_POST['addr'])) {

    $user = $_POST['username'];
    $mail = $_POST['email'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $ad01 = $_POST['zip'];
    $ad02 = $_POST['pref'];
    $ad03 = $_POST['addr'];
    $introduction = $_POST['introduction'];
    $sex = $_POST['sex'];
    $age = $_POST['age'];




    if (!$mail = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      echo '正しいメールアドレスを入力してください。';
      return false;
    }

    if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['pass'])) {
      $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    } else {
      echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
      return false;
    }


    try {
      $db = new Db();
      $pdo = $db->dbConnect();
      $stmt = $pdo->prepare("INSERT INTO userdata(username,email,pass,zip,pref,addr,introduction, sex,age) VALUES (:username, :email, :pass, :zip, :pref, :addr,:introduction, :sex, :age)");
      $stmt->bindParam(':username', $user, PDO::PARAM_STR);
      $stmt->bindParam(':email', $mail, PDO::PARAM_STR);
      $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
      $stmt->bindParam(':zip', $ad01, PDO::PARAM_STR);
      $stmt->bindParam(':pref', $ad02, PDO::PARAM_STR);
      $stmt->bindParam(':addr', $ad03, PDO::PARAM_STR);
      $stmt->bindParam(':introduction', $introduction, PDO::PARAM_STR);
      $stmt->bindParam(':sex', $sex, PDO::PARAM_STR);
      $stmt->bindParam(':age', $age, PDO::PARAM_STR);
      header('Location:created_account_user.php');
      $stmt->execute();

      $_SESSION['login_shop'] = $shop_username;
    } catch (PDOException $e) {
      $errorMessage = 'すでにそのメールアドレスは使用されています。';
      echo $e->getMessage();
    }
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Bootstrap4 フォームコンポーネント( HTMLバリデーション )</title>

  <!--Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
  <!--Font Awesome5-->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" />

  <!--自作CSS -->
  <style type="text/css">
    /*ここに調整CSS記述*/
  </style>
</head>

<body>
  <!-- <header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <a class="navbar-brand" href="index.php">TRY-GER</a>
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


  <!-- </form>

      </div>
    </nav>

  </header> -->


  <!-- モーダルの設定 -->
  <!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
            
          </div>
        </div>
      </div>
    </div>
  </div> -->

  <!-- Page Content -->

  <div class="container mt-5 p-lg-5 bg-light">
    <form class="needs-validation" novalidate action="new_account_user.php" enctype="multipart/form-data" method="post">
      <fieldset>
        <legend>新規登録フォーム</legend>
        <div>
          <font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font>
        </div>
        <div>
          <font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font>
        </div>

        <!--ユーザー名-->
        <div class="mb-8">
          <div class="form-group row">
            <label for="userName">ユーザー名</label>
            <input type="text" class="form-control" id="userName" name="username" placeholder="ユーザー名" value="<?php if (!empty($_POST["username"])) {
                                                                                                                echo htmlspecialchars($_POST["username"], ENT_QUOTES);
                                                                                                              } ?>">
          </div>
        </div>
        <!--/ユーザー名-->
        </br>

        <!--Eメール-->
        <div class="form-group row">
          <label for="inputEmail" class="col-sm-2 col-form-label">Eメール</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Eメール" value="<?php if (!empty($_POST["email"])) {
                                                                                                              echo htmlspecialchars($_POST["email"], ENT_QUOTES);
                                                                                                            } ?>">

          </div>
        </div>
        <!--/Eメール-->

        <!--パスワード-->
        <div class="form-group row mb-5">
          <label for="inputPassword" class="col-sm-2 col-form-label">パスワード</label>
          <div class="col-sm-10">
            <input type="password" name="pass" class="form-control" id="inputPassword" placeholder="パスワード" value="<?php if (!empty($_POST["pass"])) {
                                                                                                                    echo htmlspecialchars($_POST["pass"], ENT_QUOTES);
                                                                                                                  } ?>">

            <small id="passwordHelpBlock" class="form-text text-muted">パスワードは、文字と数字を含めて8～20文字で、空白、特殊文字、絵文字を含むことはできません。</small>
          </div>
        </div>
        <!--/パスワード-->

        <!--住所-->
        <div class="form-row">
          <div class="col-md-3 mb-5">
            <label for="inputAddress01">郵便番号(7桁)</label>
            <input type="text" name="zip" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','pref','addr');" class="form-control" id="inputAddress01" placeholder="1030013" value="<?php if (!empty($_POST["zip"])) {
                                                                                                                                                                                    echo htmlspecialchars($_POST["zip"], ENT_QUOTES);
                                                                                                                                                                                  } ?>">

          </div>
          <div class="col-md-3">
            <label for="inputAddress02">都道府県</label>
            <input type="text" name="pref" id="inputAddress02" class="form-control" placeholder="東京都" value="<?php if (!empty($_POST["pref"])) {
                                                                                                                echo htmlspecialchars($_POST["pref"], ENT_QUOTES);
                                                                                                              } ?>">

          </div>
          <div class="col-md-6">
            <label for="inputAddress03">住所</label>
            <input type="text" name="addr" class="form-control" id="inputAddress03" placeholder="中央区日本橋人形町" value="<?php if (!empty($_POST["addr"])) {
                                                                                                                      echo htmlspecialchars($_POST["addr"], ENT_QUOTES);
                                                                                                                    } ?>">

          </div>
        </div>
        <!--/住所-->

        <!--性別-->

        <div class="form-check">
          <input class="form-check-input" type="radio" name="sex" id="male" value="男性" checked>
          <label class="form-check-label" for="exampleRadios1">
            男性
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="sex" id="female" value="女性">
          <label class="form-check-label" for="exampleRadios2">
            女性
          </label>
        </div>
        <!--/性別-->
        </br>
        <!-- 年齢 -->
        <select name="age">
          <?php for ($i = 0; $i < 100; $i += 1) {
            echo '<option value=' . $i . '>' . $i . '</option>';
          } ?>
        </select>　歳
        <!-- 年齢 -->

        </br>
        <!--自己紹介欄-->
        <div class="form-group pb-3">
          <label for="Textarea">自己紹介欄</label>
          <textarea class="form-control" id="Textarea" name="introduction" rows="3" placeholder="自分のキャラクターや自己PRを記入してください。" value="<?php if (!empty($_POST["text"])) {
                                                                                                                                    echo htmlspecialchars($_POST["text"], ENT_QUOTES);
                                                                                                                                  } ?>"></textarea>
        </div>
        <!--/自己紹介欄-->

        <!--利用規約-->
        <!-- <div class="form-group pb-3">
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" value="" id="invalidCheck" required />
            <label class="custom-control-label" for="invalidCheck">
              利用規約に同意する
            </label>
            <div class="invalid-feedback mb-3">
              提出する前に同意する必要があります
            </div>
          </div>
        </div> -->
        <!--/利用規約-->

        <!--ボタンブロック-->

        <div class="form-group row">
          <div class="col-sm-12">
            <button type="submit" class="btn btn-primary btn-block" name="submit" value="新規登録">
              新規登録
            </button>
          </div>
        </div>
        <!--/ボタンブロック-->
    </form>

  </div>
  <!--/container -->
  </fieldset>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <!-- 郵便番号から住所自動入力 -->
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
  <script>
    var fileArea = document.getElementById('drag-drop-area');
    var fileInput = document.getElementById('fileInput');


    fileArea.addEventListener('dragover', function(evt) {
      evt.preventDefault();
      fileArea.classList.add('dragover');
    });

    fileArea.addEventListener('dragleave', function(evt) {
      evt.preventDefault();
      fileArea.classList.remove('dragover');
    });
    fileArea.addEventListener('drop', function(evt) {
      evt.preventDefault();
      fileArea.classList.remove('dragenter');
      var files = evt.dataTransfer.files;
      fileInput.files = files;
    });
  </script>
</body>

</html>