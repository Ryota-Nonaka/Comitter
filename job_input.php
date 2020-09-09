<?php
require_once(__DIR__ . '/config.php');
$pref = array(
  0 => '選択下さい。',
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

          </div>
        </div>
      </div>
    </div>
  </div>
  </br>
  </br>
  </br>

  <h1>広告依頼フォーム</h1>

  <form action="job.php" method="post" name="form" onsubmit="return validate()" enctype="multipart/form-data">
    <div class="container-fluid col-md-6">

      <div class="form-group">
        <label>タイトル</label>
        <input class="form-control" type="text" name="job_title" value="">
      </div>


      <div class="form-group">
        <label>紹介内容</label>
        <textarea class="form-control" type=" text" name="job_body" placeholder="" value=""></textarea>
      </div>



      <!--性別-->
      <div class="form-group row">
        <label>　性別 </label>
        <select class="form-control col-sm-3" id="exampleFormControlSelect1" name="sex">
          <option value="男性">男性</option>
          <option value="女性">女性</option>
          <option value="無回答">無回答</option>
        </select>
        <!--/性別-->

        <!-- 年齢 -->
        <label>　　年齢</label>
        <select class="form-control col-sm-3" id="exampleFormControlSelect1" name=" age">
          <?php for ($i = 0; $i <= 100; $i += 10) {
            echo '<option value=' . $i . '>' . $i . '</option>';
          } ?>
        </select>　代
      </div>
      <!-- 年齢 -->

      <!--エリア-->
      <div class="form-group">
        <label>エリア</label>
        <select class="form-control col-mb-6" name="pref">
          <?php foreach ($pref as $value) { ?>
            <option value="<?php echo $value ?>"> <?php echo $value; ?></option>
          <?php } ?>
        </select>
      </div>
      <!--/エリア-->


      <div class="form-group">
        <label>イメージ画像</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo h(MAX_FILE_SIZE); ?>">
        <div class="input-group row">
          <div class="custom-file col-mb-6">
            <input type="file" class="custom-file-input" id="inputGroupFile03" aria-describedby="inputGroupFileAddon03" name="image">
            <label class="custom-file-label" for="inputGroupFile03">ファイルを選択</label>
            <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
          </div>
        </div>
      </div>
      <button class="btn btn-primary" type="submit">確認画面へ</button>
    </div>
  </form>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>