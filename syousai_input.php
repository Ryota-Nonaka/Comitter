<?php


session_start();

//同じメールアドレスが使われていたらエラーを出したい


$errorMessage = "";
$signUpMessage = "";

if (isset($_POST['signUp'])) {
  if (empty($_POST['shopname'])) {
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
  if (!empty($_POST['shopname']) && !empty($_POST['email']) && !empty($_POST['pass']) && !empty($_POST['zip01']) && !empty($_POST['pref01']) && !empty($_POST['addr01'])) {

    $user = $_POST['shopname'];
    $mail = $_POST['email'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $ad01 = $_POST['zip01'];
    $ad02 = $_POST['pref01'];
    $ad03 = $_POST['addr01'];
    $text = $_POST['text'];

    $dsn = sprintf('mysql:dbname=reqruits;host=127.0.0.1;charset=utf8mb4_bin', 'root', "");

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
      $pdo = new PDO('mysql:dbname=reqruits;127.0.0.1;charset=utf8mb4_bin', 'root', "", [
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

      $stmt->execute();

      $userid = $pdo->lastinsertid();

      $signUpMessage = '登録が完了しました。あなたの登録IDは' . $userid . 'です。パスワードは' . $pass . 'です。';
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
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

  <title>依頼内容入力フォーム</title>
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
        <form class="form-inline mt-2 mt-md-0">

          <!-- 切り替えボタンの設定 -->
          <?php
          session_start();

          if (isset($_SESSION['login'])) {
            echo "ようこそ、" . $_SESSION['login'] . "さん！";
            echo "<a href='logout.php'>ログアウトはこちら。</a>";
          } else {
            echo  '<button type="button" class="btn btn-primary text-right" data-toggle="modal" data-target="#exampleModal">ログイン</button>';
          }
          ?>


        </form>

      </div>
    </nav>

  </header>

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
      </div><!-- /.modal-dialog -->
    </div>
  </div>
  <!-- Navigation -->
  <nav class="navbar navbar-light navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Bootstrap4 フォームコンポーネント ( HTMLバリデーション )</a>
  </nav>

  <!-- Page Content -->
  <div class="container mt-5 p-lg-5 bg-light">
    <form class="needs-validation" method="POST" action="syousai.php" novalidate>
      <!--店舗名-->
      <div class="form-row mb-4">
        <div class="col-md-8">
          <label for="lastName">店舗名</label>
          <input type="text" class="form-control" id="shopname" placeholder="店舗名を入力してください" required />
          <div class="invalid-feedback">
            入力してください
          </div>
        </div>
        <!-- <div class="col-md-6 mb-3">
            <label for="firstName">名前</label>
            <input
              type="text"
              class="form-control"
              id="firstName"
              placeholder="名前"
              required
            />
            <div class="invalid-feedback">
              入力してください
            </div>
          </div> -->
      </div>
      <!--/氏名-->

      <!--Eメール-->
      <div class="form-group row">
        <label for="inputEmail" class="col-sm-2 col-form-label">Eメール</label>
        <div class="col-sm-10">
          <input type="email" class="form-control" id="inputEmail" placeholder="Eメール" required />
          <div class="invalid-feedback">入力してください</div>
        </div>
      </div>
      <!--/Eメール-->

      <!--/募集期間-->
      <div class="form-group row">
        <label>期間</label>
        <div class="col-3">
          <input type="text" class="form-control" id="date_sample1" />
        </div>
        <label>~</label>
        <div class="col-3">
          <input type="text" class="form-control" id="date_sample2" />
        </div>
      </div>
      <!--/募集期間-->

      <!--住所-->
      <div class="form-row">
        <div class="col-md-3 mb-5">
          <label for="inputAddress01">郵便番号(7桁)</label>
          <input type="text" name="zip01" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','pref01','addr01');" class="form-control" id="inputAddress01" placeholder="1030013" required />
          <div class="invalid-feedback">入力してください</div>
        </div>
        <div class="col-md-3">
          <label for="inputAddress02">都道府県</label>
          <input type="text" name="pref01" id="inputAddress02" class="form-control" placeholder="東京都" required />
          <div class="invalid-feedback">入力してください</div>
        </div>
        <div class="col-md-6">
          <label for="inputAddress03">住所</label>
          <input type="text" name="addr01" class="form-control" id="inputAddress03" placeholder="中央区日本橋人形町" required />
          <div class="invalid-feedback">入力してください</div>
        </div>
      </div>
      <!--/住所-->

      <!--募集要項-->
      <div class="form-group pb-8">
        <label for="Textarea">募集要項</label>
        <textarea class="form-control" id="Textarea" rows="10" placeholder="希望の宣伝方法や求める人物像など簡単に" required></textarea>
        <div class="invalid-feedback">入力してください</div>
      </div>
      <!--/募集要項-->

      <!--ボタンブロック-->
      <div class="form-group row">
        <div class="col-sm-12">
          <button type="submit" class="btn btn-primary btn-block">
            この内容で募集する
          </button>
        </div>
    </form>
  </div>
  <!--/ボタンブロック-->

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script>
    $("#date_sample1").datepicker({
      dateFormat: 'yy-mm-dd',
      firstDay: 1,
      monthNames: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"]
    });
  </script>

  <script>
    $("#date_sample2").datepicker({
      dateFormat: 'yy-mm-dd',
      firstDay: 1,
      monthNames: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"]
    });
  </script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <!-- 郵便番号から住所自動入力 -->
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
  <!-- Validation -->
  <script>
    // 無効なフィールドがある場合にフォーム送信を無効にするスターターJavaScriptの例
    (function() {
      "use strict";

      window.addEventListener(
        "load",
        function() {
          // カスタムブートストラップ検証スタイルを適用するすべてのフォームを取得
          var forms = document.getElementsByClassName("needs-validation");
          // ループして帰順を防ぐ
          var validation = Array.prototype.filter.call(forms, function(
            form
          ) {
            // submitボタンを押したら以下を実行
            form.addEventListener(
              "submit",
              function(event) {
                if (form.checkValidity() === false) {
                  event.preventDefault();
                  event.stopPropagation();
                }
                form.classList.add("was-validated");
              },
              false
            );
          });
        },
        false
      );
    })();
  </script>
</body>

</html>