<?php


session_start();

//同じメールアドレスが使われていたらエラーを出したい


$errorMessage = "";
$signUpMessage = "";
//エラーカウントの変数を書く
//条件式の中にエラーカウントを足していき最後にエラーカウント0ならば認証処理する。
if (isset($_POST['signUp'])) {
  if (empty($_POST['username'])) {
    $errorMessage = 'ユーザーIDが未入力です。';
  } else if (empty($_POST['email'])) {
    $errorMessage = 'メールアドレスが入力されていません。';
  } else if (empty($_POST['pass'])) {
    $errorMessage = 'パスワードが未入力です。';
  } else if (empty($_POST['zip01'])) {
    $errorMessage = '郵便番号を入力してください。';
  } else if (empty($_POST['pref01'])) {
    $errorMessage = '住所を入力してください。';
  } else if (empty($_POST['addr01'])) {
    $errorMessage = '住所を入力してください。';
  }
  if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['pass']) && !empty($_POST['zip01']) && !empty($_POST['pref01']) && !empty($_POST['addr01'])) {

    $user = $_POST['username'];
    $mail = $_POST['email'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $ad01 = $_POST['zip01'];
    $ad02 = $_POST['pref01'];
    $ad03 = $_POST['addr01'];
    $text = $_POST['text'];



    $dsn = sprintf('mysql:dbname=loginmanagement;host=127.0.0.1;charset=utf8mb4', 'user', "baramo0814");

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
    // エラー処理
    try {
      //データベース処理のクラス化
      $pdo = new PDO('mysql:dbname=loginmanagement;127.0.0.1;charset=utf8mb4', 'user', "baramo0814", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ]);

      $stmt = $pdo->prepare("INSERT INTO userdata(username,email,pass,zip01,pref01,addr01,text) VALUES (:username, :email, :pass, :zip01, :pref01, :addr01,  :text)");
      $stmt->bindParam(':username', $user, PDO::PARAM_STR);
      $stmt->bindParam(':email', $mail, PDO::PARAM_STR);
      $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
      $stmt->bindParam(':zip01', $ad01, PDO::PARAM_STR);
      $stmt->bindParam(':pref01', $ad02, PDO::PARAM_STR);
      $stmt->bindParam(':addr01', $ad03, PDO::PARAM_STR);
      $stmt->bindParam(':text', $text, PDO::PARAM_STR);

      $_SESSION['loginuser'] = $row['username'];
      header('Location:created_account.php');
      $stmt->execute();
      $userid = $pdo->lastinsertid();
    } catch (PDOException $e) {
      $errorMessage = 'データベースエラー';
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
    <!--
    /*ここに調整CSS記述*/
    -->
  </style>
</head>

<body>
  <header>
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

          /*
          <!-- 切り替えボタンの設定 -->


        </form> */

      </div>
    </nav>

  </header>

  /*
  <!-- モーダルの設定 -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
            <!-- <button type="button" class="btn btn-primary">変更を保存</button> -->
          </div><!-- /.modal-footer -->
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog --> */
    </div>
  </div>

  <!-- Page Content -->

  <div class="container mt-5 p-lg-5 bg-light">
    <form class="needs-validation" novalidate action="./new account.php" method="post">
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
            <input type="text" name="zip01" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','pref01','addr01');" class="form-control" id="inputAddress01" placeholder="1030013" value="<?php if (!empty($_POST["zip01"])) {
                                                                                                                                                                                          echo htmlspecialchars($_POST["zip01"], ENT_QUOTES);
                                                                                                                                                                                        } ?>">

          </div>
          <div class="col-md-3">
            <label for="inputAddress02">都道府県</label>
            <input type="text" name="pref01" id="inputAddress02" class="form-control" placeholder="東京都" value="<?php if (!empty($_POST["pref01"])) {
                                                                                                                  echo htmlspecialchars($_POST["pref01"], ENT_QUOTES);
                                                                                                                } ?>">

          </div>
          <div class="col-md-6">
            <label for="inputAddress03">住所</label>
            <input type="text" name="addr01" class="form-control" id="inputAddress03" placeholder="中央区日本橋人形町" value="<?php if (!empty($_POST["addr01"])) {
                                                                                                                        echo htmlspecialchars($_POST["addr01"], ENT_QUOTES);
                                                                                                                      } ?>">

          </div>
        </div>
        <!--/住所-->

        <!--備考欄-->
        <div class="form-group pb-3">
          <label for="Textarea">備考欄</label>
          <textarea class="form-control" id="Textarea" name="text" rows="3" placeholder="その他、質問などありましたら" value="<?php if (!empty($_POST["text"])) {
                                                                                                                  echo htmlspecialchars($_POST["text"], ENT_QUOTES);
                                                                                                                } ?>"></textarea>
        </div>
        <!--/備考欄-->

        <!--利用規約-->
        <div class="form-group pb-3">
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" value="" id="invalidCheck" required />
            <label class="custom-control-label" for="invalidCheck">
              利用規約に同意する
            </label>
            <div class="invalid-feedback mb-3">
              提出する前に同意する必要があります
            </div>
          </div>
        </div>
        <!--/利用規約-->

        <!--ボタンブロック-->

        <div class="form-group row">
          <div class="col-sm-12">
            <button type="submit" class="btn btn-primary btn-block" name="signUp" value="新規登録">
              新規登録
            </button>
          </div>
        </div>
        <!--/ボタンブロック-->
    </form>
  </div>
  <!-- /container -->
  </fieldset>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <!-- 郵便番号から住所自動入力 -->
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
</body>

</html>