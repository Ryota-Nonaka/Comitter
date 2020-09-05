<?php
require_once(__DIR__ . '/config.php');
var_dump($_SESSION['login_shop_id']);
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

  <title>Hello, world!</title>
</head>

<body>
  <h1>広告依頼フォーム</h1>

  <form action="job.php" method="post" name="form" onsubmit="return validate()" enctype="multipart/form-data">
    <div class="container-fluid col-md-6">
      <!-- <div class="row center-block"> -->
      <label>title<span class="badge badge-danger">必須</span></label>
      <input class="form-control" type="text" name="job_title" placeholder="例）山田太郎" value="">
      <!-- </div> -->
      <!-- <div class="form-group col-md-6 row"> -->
      <label>紹介内容</label><span class="badge badge-danger">必須</span></label>
      <textarea class="form-control" type=" text" name="job_body" placeholder="" value=""></textarea>
      <!-- </div> -->
      <!-- <div class="form-group col-md-6 row"> -->


      <!--性別-->
      <div class=" form-check form-check-inline">
        <input type="radio" class="form-check-input" name="sex" value="radio" id="radio1">
        <label class="custom-control-label" for="custom-radio-1">男性 </label>
      </div>
      <div class="form-check form-check-inline">
        <input type="radio" class="form-check-input" name="sex" value="radio" id="radio2">
        <label class="custom-control-label" for="custom-radio-1">女性 </label>
      </div>
      <!--/性別-->

      <!-- 年齢 -->
      <select name="age">
        <?php for ($i = 0; $i <= 100; $i += 10) {
          echo '<option value=' . $i . '>' . $i . '</option>';
        } ?>
      </select>　代
      <!-- 年齢 -->


      <select class="form-control col-mb-6" name="pref">
        <?php foreach ($pref as $value) { ?>
          <option value="<?php echo $value ?>"> <?php echo $value; ?></option>
        <?php } ?>
      </select>


      <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo h(MAX_FILE_SIZE); ?>">
      <div class="input-group row">
        <div class="custom-file col-mb-3">
          <input type="file" class="custom-file-input" name="image">
          <label class="custom-file-label" for="inputGroupFile01">ファイルを選択</label>
          <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
        </div>
      </div>
      <button class="btn btn-primary" type="submit">画像アップロードへ</button>
    </div>
  </form>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>