<?php

require_once(__DIR__ . '/config.php');
if (isset($_SESSION['login_shop'])) {
  $db = new Db();
  $pdo = $db->dbConnect();
  $id = $_SESSION['login_shop_id'];
  $sql = "SELECT * FROM shop_userdata WHERE id='$id'";
  $stmt = $pdo->query($sql);
  foreach ($stmt as $row) {
    $username = $row['shop_name'];
    $furigana = $row['shop_furigana'];
    $tell = $row['shop_tell'];
    $email = $row['shop_email'];
    $pref = $row['shop_pref'];
    $open = $row['business_hour_open'];
    $close = $row['business_hour_close'];
    $regular_holiday = $row['regular_holiday'];
    $url = $row['shop_url'];
  }
}

if (isset($_POST['edit'])) {
  $success = null;
  $error = null;
  $username = $_POST['shop_name'];
  $area = $_POST['area'];
  $open = $_POST['business_hour_open'];
  $close = $_POST['business_hour_close'];
  $url = $_POST['shop_url'];

  if (isset($_POST['regular_holiday']) && is_array($_POST['regular_holiday'])) {
    $regular_holiday = implode("、", $_POST['regular_holiday']);
  }

  try {
    $db = new Db();
    $pdo = $db->dbConnect();
    $stmt = $pdo->prepare("UPDATE shop_userdata SET shop_name='$username', shop_pref='$area', business_hour_open='$open',business_hour_close='$close',regular_holiday='$regular_holiday',shop_url='$url' WHERE id='$id'");

    $_SESSION['login_shop'] = $username;
    $stmt->execute();

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

$pref = array(
  1 => '北海道',
  2 => '青森県',
  3 => '岩手県',
  4 => '宮城県',
  5 => '秋田県',
  6 => '山形県',
  7 => '福島県',
  8 => '茨城県',
  9 => '栃木県',
  10 => '群馬県',
  11 => '埼玉県',
  12 => '千葉県',
  13 => '東京都',
  14 => '神奈川県',
  15 => '山梨県',
  16 => '長野県',
  17 => '新潟県',
  18 => '富山県',
  19 => '石川県',
  20 => '福井県',
  21 => '岐阜県',
  22 => '静岡県',
  23 => '愛知県',
  24 => '三重県',
  25 => '滋賀県',
  26 => '京都府',
  27 => '大阪府',
  28 => '兵庫県',
  29 => '奈良県',
  30 => '和歌山県',
  31 => '鳥取県',
  32 => '島根県',
  33 => '岡山県',
  34 => '広島県',
  35 => '山口県',
  36 => '徳島県',
  37 => '香川県',
  38 => '愛媛県',
  39 => '高知県',
  40 => '福岡県',
  41 => '佐賀県',
  42 => '長崎県',
  43 => '熊本県',
  44 => '大分県',
  45 => '宮崎県',
  46 => '鹿児島県',
  47 => '沖縄県'
);


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




  <div class="container mt-5 p-lg-5 bg-light">
    <h1 class="contact-title">プロフィール編集画面</h1>


    <form action="profile_edit_shop.php" enctype="multipart/form-data" method="post" name="edit" onsubmit="return validate()">

      <!--店名-->
      <div class="mb-8">
        <div class="form-group row">
          <label for="shop_name">店名</label>
          <input type="text" class="form-control" id="shop_name" name="shop_name" placeholder="店名" value="<?php if ($_SESSION['login_shop']) {
                                                                                                            echo $username;
                                                                                                          } ?>">
        </div>
      </div>
      <!--店名-->

      <!--エリア-->
      <div class="input-group mt-3 input-group-sm col-sm-XX row">

        <label>エリア</label>

        <select class="form-control ml-2 col-sm-3" name="area">
          <?php foreach ($pref as $value) : ?>
            <option value="<?= $value ?>"> <?= $value; ?></option>
          <?php endforeach; ?>
        </select>
        <!--/エリア-->


        <!--営業時間-->
        <div class="input-group input-group-sm col-md-6">
          <label class="mr-3" for="scheduled-time">営業時間</label>
          <input type="time" class="form-control col-sm-3" name="business_hour_open" id="scheduled-time" value="<?= $open ?>">

          <p>　～　</p>
          <input type="time" name="business_hour_close" class="form-control col-md-3" id="scheduled-time" value="<?= $close ?>">
        </div>
      </div>
      <!--営業時間-->


      <!--定休日-->
      <div class="input-group row col-md-6 mt-3">
        <label class="mr-3" for="scheduled-time">定休日</label>
        <input type="checkbox" name="regular_holiday[]" value="月曜日">月曜日
        <input type="checkbox" name="regular_holiday[]" value="火曜日">火曜日
        <input type="checkbox" name="regular_holiday[]" value="水曜日">水曜日
        <input type="checkbox" name="regular_holiday[]" value="木曜日">木曜日
        <input type="checkbox" name="regular_holiday[]" value="金曜日">金曜日
        <input type="checkbox" name="regular_holiday[]" value="土曜日">土曜日
        <input type="checkbox" name="regular_holiday[]" value="日曜日">日曜日
      </div>
      <!--定休日-->

      <!--サイトURL-->
      <div class="input-group mt-3  row">
        <label for="inputEmail" class="col-sm-2 col-form-label">お店のサイトURL</label>

        <div class="col-sm-10">
          <input class="form-control" id="inputurl" name="shop_url" placeholder="" value="<?= $url ?>">

        </div>
      </div>
      <!--/サイトURL-->

      </br>
      <div class="row mt-8">
        <a class="btn btn-secondary" role=button href="mypage_shop.php?shop_name=<?= $_SESSION['login_shop'] ?>">マイページへ</a>
        <div class="row ml-3">
          <button class="btn btn-primary float-right" type="submit" name="edit">変更を適用する</button>
        </div>
      </div>
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

  </div>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>


</html>