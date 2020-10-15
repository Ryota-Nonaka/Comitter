<?php

require_once(__DIR__ . '/config.php');


$errorMessage = "";



if ($_SERVER["REQUEST_METHOD"] == "POST") {


  if (empty($_POST['shop_name'])) {
    $errorMessage = '店名が未入力です。';
  } else if (empty($_POST['shop_furigana'])) {
    $errorMessage = 'フリガナが入力されていません。';
  } else if (empty($_POST['shop_tell'])) {
    $errorMessage = '電話番号が未入力です。';
  } else if (empty($_POST['shop_email'])) {
    $errorMessage = 'メールアドレスが未入力です。';
  } else if (empty($_POST['shop_password'])) {
    $errorMessage = 'パスワードが未入力です。';
  } else if (empty($_POST['shop_zip'])) {
    $errorMessage = '郵便番号を入力してください。';
  } else if (empty($_POST['shop_pref'])) {
    $errorMessage = '住所を入力してください。';
  } else if (empty($_POST['shop_addr'])) {
    $errorMessage = '住所を入力してください。';
  } else if (empty($_POST['business_hour_open'])) {
    $errorMessage = '営業時間を入力してください。';
  } else if (empty($_POST['business_hour_close'])) {
    $errorMessage = '営業時間を入力してください。';
  } else if (empty($_POST['regular_holiday'])) {
    $errorMessage = '定休日を入力してください。';
  }




  if (!empty($_POST['shop_name']) && !empty($_POST['shop_furigana']) && !empty($_POST['shop_tell']) && !empty($_POST['shop_email']) && !empty($_POST['shop_password']) && !empty($_POST['shop_zip']) && !empty($_POST['shop_pref']) && !empty($_POST['shop_addr']) && !empty($_POST['business_hour_open']) && !empty($_POST['business_hour_close']) && !empty($_POST['regular_holiday'])) {

    $shop_username = $_POST['shop_name'];
    $shop_furigana = $_POST['shop_furigana'];
    $shop_tell = $_POST['shop_tell'];
    $shop_email = $_POST['shop_email'];
    $shop_ad01 = $_POST['shop_zip'];
    $shop_ad02 = $_POST['shop_pref'];
    $shop_ad03 = $_POST['shop_addr'];
    $business_hour_open = $_POST['business_hour_open'];
    $business_hour_close = $_POST['business_hour_close'];

    $shop_url = $_POST['shop_url'];

    if (isset($_POST['regular_holiday']) && is_array($_POST['regular_holiday'])) {
      $regular_holiday = implode("、", $_POST['regular_holiday']);
    }

    if (!$shop_email = filter_var($_POST['shop_email'], FILTER_VALIDATE_EMAIL)) {
      echo '正しいメールアドレスを入力してください。';
      return false;
    }



    if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['shop_password'])) {
      $pass = password_hash($_POST['shop_password'], PASSWORD_DEFAULT);
    } else {
      echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
      return false;
    }
    // エラー処理
    try {
      //データベース処理のクラス化
      $db = new Db();
      $pdo = $db->dbConnect();
      $stmt = $pdo->prepare("INSERT INTO shop_userdata(shop_name,shop_furigana,shop_tell,shop_email,shop_password,shop_zip,shop_pref,shop_addr,business_hour_open,business_hour_close,regular_holiday,shop_url) VALUES (:shop_name,:shop_furigana,:shop_tell,:shop_email,:shop_password,:shop_zip,:shop_pref,:shop_addr,:business_hour_open,:business_hour_close,:regular_holiday,:shop_url)");
      $stmt->bindParam(':shop_name',  $shop_username, PDO::PARAM_STR);
      $stmt->bindParam(':shop_furigana', $shop_furigana, PDO::PARAM_STR);
      $stmt->bindParam(':shop_tell',  $shop_tell, PDO::PARAM_STR);
      $stmt->bindParam(':shop_email',  $shop_email, PDO::PARAM_STR);
      $stmt->bindParam(':shop_password', $pass, PDO::PARAM_STR);
      $stmt->bindParam(':shop_zip',  $shop_ad01, PDO::PARAM_STR);
      $stmt->bindParam(':shop_pref',  $shop_ad02, PDO::PARAM_STR);
      $stmt->bindParam(':shop_addr', $shop_ad03, PDO::PARAM_STR);
      $stmt->bindParam(':business_hour_open',  $business_hour_open, PDO::PARAM_STR);
      $stmt->bindParam(':business_hour_close',  $business_hour_close, PDO::PARAM_STR);
      $stmt->bindParam(':regular_holiday', $regular_holiday, PDO::PARAM_STR);
      $stmt->bindParam(':shop_url', $shop_url, PDO::PARAM_STR);
      $stmt->execute();
      $_SESSION['login_shop_id'] = $pdo->lastInsertId();
      $_SESSION['login_shop'] = $shop_username;
      header('Location:new_account_image_shop.php');
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



  <!-- Page Content -->

  <div class="container mt-5 p-lg-5 bg-light">
    <form class="needs-validation" novalidate action="new_account_shop.php" method="post">
      <fieldset>
        <legend>新規登録フォーム</legend>
        <?php if (isset($errorMessage)) : ?>
          <div>
            <font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font>
          </div>
        <?php elseif (isset($signUpMessage)) : ?>
          <div>
            <font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font>
          </div>
        <?php endif; ?>
        <!--店名-->
        <div class="mb-8">
          <div class="form-group row">
            <label for="shop_name">店名</label>
            <input type="text" class="form-control" id="shop_name" name="shop_name" placeholder="店名" value="<?php if (!empty($_POST["shop_name"])) {
                                                                                                              echo htmlspecialchars($_POST["shop_name"], ENT_QUOTES);
                                                                                                            } ?>">
          </div>
        </div>
        <!--店名-->

        <!--フリガナ-->
        <div class="mb-8">
          <div class="form-group row">
            <label for="furigana">フリガナ</label>
            <input type="text" class="form-control" id="furigana" name="shop_furigana" placeholder="フリガナ" value="<?php if (!empty($_POST["shop_furigana"])) {
                                                                                                                    echo htmlspecialchars($_POST["shop_furigana"], ENT_QUOTES);
                                                                                                                  } ?>">
          </div>
        </div>
        <!--フリガナ-->
        </br>

        <!--電話番号-->
        <div class="form-group row">
          <label for="tell" class="col-sm-2 col-form-label">電話番号</label>
          <div class="col-sm-10">
            <input type="tell" class="form-control" id="tell" name="shop_tell" placeholder="電話番号" value="<?php if (!empty($_POST["shop_tell"])) {
                                                                                                            echo htmlspecialchars($_POST["shop_tell"], ENT_QUOTES);
                                                                                                          } ?>">

          </div>
        </div>
        <!--電話番号-->

        <!--Eメール-->
        <div class="form-group row">
          <label for="inputEmail" class="col-sm-2 col-form-label">Eメール</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="inputEmail" name="shop_email" placeholder="Eメール" value="<?php if (!empty($_POST["shop_email"])) {
                                                                                                                    echo htmlspecialchars($_POST["shop_email"], ENT_QUOTES);
                                                                                                                  } ?>">

          </div>
        </div>
        <!--/Eメール-->

        <!--パスワード-->
        <div class="form-group row mb-5">
          <label for="inputPassword" class="col-sm-2 col-form-label">パスワード</label>
          <div class="col-sm-10">
            <input type="password" name="shop_password" class="form-control" id="inputPassword" placeholder="パスワード" value="<?php if (!empty($_POST["shop_password"])) {
                                                                                                                              echo htmlspecialchars($_POST["shop_password"], ENT_QUOTES);
                                                                                                                            } ?>">

            <small id="passwordHelpBlock" class="form-text text-muted">パスワードは、文字と数字を含めて8～20文字で、空白、特殊文字、絵文字を含むことはできません。</small>
          </div>
        </div>
        <!--パスワード-->

        <!--住所-->
        <div class="form-row">
          <div class="col-md-3 mb-5">
            <label for="inputAddress01">郵便番号(7桁)</label>
            <input type="text" name="shop_zip" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','pref','addr');" class="form-control" id="inputAddress01" placeholder="1030013" value="<?php if (!empty($_POST["shop_zip"])) {
                                                                                                                                                                                          echo htmlspecialchars($_POST["shop_zip"], ENT_QUOTES);
                                                                                                                                                                                        } ?>">

          </div>
          <div class="col-md-3">
            <label for="inputAddress02">都道府県</label>
            <input type="text" name="shop_pref" id="inputAddress02" class="form-control" placeholder="東京都" value="<?php if (!empty($_POST["shop_pref"])) {
                                                                                                                    echo htmlspecialchars($_POST["shop_pref"], ENT_QUOTES);
                                                                                                                  } ?>">

          </div>
          <div class="col-md-6">
            <label for="inputAddress03">住所</label>
            <input type="text" name="shop_addr" class="form-control" id="inputAddress03" placeholder="中央区日本橋人形町" value="<?php if (!empty($_POST["shop_addr"])) {
                                                                                                                          echo htmlspecialchars($_POST["shop_addr"], ENT_QUOTES);
                                                                                                                        } ?>">

          </div>
        </div>
        <!--住所-->

        <!--営業時間-->
        <div class="row input-group col-md-6">
          <label for="scheduled-time">営業時間</label>
          <input type="time" class="form-control col-md-3" name="business_hour_open" id="scheduled-time" value="<?php if (!empty($_POST["business_hour_open"])) {
                                                                                                                  echo htmlspecialchars($_POST["business_hour_open"], ENT_QUOTES);
                                                                                                                } ?>">
          <p>　～　</p>
          <input type="time" name="business_hour_close" class="form-control col-md-3" id="scheduled-time" value="<?php if (!empty($_POST["business_hour_close"])) {
                                                                                                                    echo htmlspecialchars($_POST["business_hour_close"], ENT_QUOTES);
                                                                                                                  } ?>">
        </div>
        <!--営業時間-->

        </br>

        <!--定休日-->
        <div class="input-group col-md-6">
          <label for="scheduled-time">定休日</label>
          <input type="checkbox" name="regular_holiday[]" value="月曜日">月曜日
          <input type="checkbox" name="regular_holiday[]" value="火曜日">火曜日
          <input type="checkbox" name="regular_holiday[]" value="水曜日">水曜日
          <input type="checkbox" name="regular_holiday[]" value="木曜日">木曜日
          <input type="checkbox" name="regular_holiday[]" value="金曜日">金曜日
          <input type="checkbox" name="regular_holiday[]" value="土曜日">土曜日
          <input type="checkbox" name="regular_holiday[]" value="日曜日">日曜日
        </div>
        <!--定休日-->
        </br>



        <!--サイトURL-->
        <div class="form-group row">
          <label for="inputEmail" class="col-sm-2 col-form-label">お店のサイトURL</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="inputurl" name="shop_url" placeholder="" value="<?php if (!empty($_POST["shop_url"])) {
                                                                                                            echo htmlspecialchars($_POST["shop_url"], ENT_QUOTES);
                                                                                                          } ?>">

          </div>
        </div>
        <!--/サイトURL-->




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
            <button type="submit" class="btn btn-primary btn-block" name="signup_shop" value="新規登録">
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
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/locale/ja.js" type="text/javascript"></script>
  <!-- 郵便番号から住所自動入力 -->
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>

</body>

</html>