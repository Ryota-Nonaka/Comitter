<?php
require_once(__DIR__ . '/config.php');
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
        <form class="form-inline mt-2 mt-md-0">

          <!-- 切り替えボタンの設定 -->
          <?php


          if (isset($_SESSION['login'])) : ?>
            <div class=text-light> ようこそ、<span class="text-primary"> <?= $_SESSION['login'] ?> </span>さん！</div>
            <a href="mypage_user.php?username=<?php echo ($_SESSION['login']); ?>">マイページへ</a>
          <?php elseif (isset($_SESSION['me'])) : ?>
            <div class=text-light> ようこそ、<span class="text-primary"> <?= $userInfo->name ?> </span>さん！</div>
            <a href='mypage.php'>マイページへ</a>
          <?php elseif (isset($_SESSION['login_shop'])) : ?>
            <div class=text-light> ようこそ、<span class="text-primary"> <?= $_SESSION['login_shop'] ?> </span>さん！</div>
            <a href="mypage_shop.php?shop_name=<?php echo ($_SESSION['login_shop']) ?>">マイページへ</a>
          <?php endif; ?>



        </form>

      </div>
    </nav>

  </header>
  </br>
  </br>
  </br>
  <div class="container border bg-info">
    <h1>広告依頼フォーム</h1>
  </div>

  <form action="job.php" method="post" name="form" onsubmit="return validate()" enctype="multipart/form-data">
    <div class="container border px-lg-5 pb-lg-5 pt-sm-2">

      <div class="form-group">
        <label>タイトル</label>
        <input class="form-control" type="text" name="job_title" placeholder="PRしてほしいサービス名、メニュー名などを入力してください。" required>
      </div>


      <div class="form-group">
        <label>募集内容</label>
        <textarea class="form-control" type=" text" name="job_body" rows="5" placeholder="商品のPRポイント、求める人材などを簡単に入力してください。" required></textarea>
      </div>

      <div class="form-group">
        <label>報酬</label>
        <textarea class="form-control" type=" text" name="reward" rows="5" placeholder="例)割引券プレゼント、など" required></textarea>
      </div>



      <div class="form-group mt-3">
        <label>イメージ画像</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo h(MAX_FILE_SIZE); ?>">
        <div class="input-group row p-0 m-0">
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="inputGroupFile" aria-describedby="inputGroupFileAddon" name="image" required>
            <label class="custom-file-label" for="inputGroupFile03">イメージ画像を添付してください。</label>
          </div>
          <div class="input-group-append">
            <button type="button" class="btn btn-outline-secondary input-group-text" id="inputFileReset">取消</button>
          </div>
        </div>
      </div>

      <!--性別-->
      <div class="input-group input-group-sm mb-3 row">
        <div class="ml-3">
          <label>性別</label>
        </div>
        <select class="form-control col-sm-3 ml-2" id="exampleFormControlSelect1" name="sex" required>
          <option value="男性">男性</option>
          <option value="女性">女性</option>
          <option value="両方">どちらも</option>
        </select>
        <!--/性別-->

        <!-- 年齢 -->
        <div class="ml-3">
          <label>年齢</label>
        </div>
        <select class="form-control col-sm-3  ml-2" id="exampleFormControlSelect1" name="age" required>
          <?php for ($i = 10; $i <= 100; $i += 10) {
            echo '<option value=' . $i . '>' . $i . '</option>';
          } ?>
        </select>　代
      </div>
      <!-- 年齢 -->






      <!--エリア-->
      <div class="input-group input-group-sm col-sm-XX row">
        <div class="ml-3">
          <label>エリア</label>
        </div>
        <select class="form-control ml-2 col-sm-3" name="area" required>
          <?php foreach ($pref as $value) : ?>
            <option value="<?= $value ?>"> <?= $value; ?></option>
          <?php endforeach; ?>
        </select>
        <!--/エリア-->

        <!--条件-->
        <div class="ml-3">
          <label>必要いいね数</label>
        </div>
        <select class="form-control col-sm-3 ml-3" name="needs_like" required>
          <?php
          $i = 0;
          if ($i <= 100) {
            for ($i = 10; $i <= 100; $i += 10) {
              echo '<option value=' . $i . '>' . $i . '</option>';
            }
          }
          if ($i >= 100) {
            for ($i = 200; $i <= 1000; $i += 100) {
              echo '<option value=' . $i . '>' . $i . '</option>';
            }
          } ?>
        </select>
      </div>
      <button class="btn btn-primary mt-5" type="submit">確認画面へ</button>
  </form>
  </div>
  <!--条件-->




  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
  <script>
    bsCustomFileInput.init();

    document.getElementById('inputFileReset').addEventListener('click', function() {

      bsCustomFileInput.destroy();

      var elem = document.getElementById('inputFile');
      elem.value = '';
      var clone = elem.cloneNode(false);
      elem.parentNode.replaceChild(clone, elem);

      bsCustomFileInput.init();

    });
  </script>

</body>

</html>