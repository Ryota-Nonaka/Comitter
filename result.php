<?php
require_once(__DIR__ . '/config.php');
define('COMMENTS_PER_PAGE', 5);

if (isset($_GET['page']) && preg_match('/^[1-9][0-9]*/', $_GET['page'])) {
  $page = (int)$_GET['page'];
} else {
  $page = 1;
}



error_reporting(E_ALL & ~E_NOTICE);
$results = array();
$offset = COMMENTS_PER_PAGE * ($page - 1);
$db = new Db();
$pdo = $db->dbConnect();
$result = array();
if (isset($_GET['job_name']) && isset($_GET['job_location'])) {
  $name_search = htmlspecialchars($_GET['job_name']);
  $name_search_value = $name_search;
  $location_search = htmlspecialchars($_GET['job_location']);
  $location_search_value = $location_search;

  $sql = "SELECT * FROM job where job_title LIKE '%$name_search%' AND location  LIKE '%$location_search%' ";

  $stmt = $pdo->query($sql);
  foreach ($stmt as $row) {
    array_push($results, $row);
  }
  $totalPages = ceil(count($result) / COMMENTS_PER_PAGE);
} else if (!isset($_GET['job_name']) && isset($_GET['job_location'])) {
  $name_search = '';
  $name_search_value = $name_search;
  $location_search = htmlspecialchars($_GET['job_location']);
  $location_search_value = $location_search;

  $sql = "SELECT * FROM job where location  LIKE '%$location_search%' ";

  $stmt = $pdo->query($sql);
  foreach ($stmt as $row) {
    array_push($results, $row);
  }
  $totalPages = ceil(count($result) / COMMENTS_PER_PAGE);
} else if (isset($_GET['job_name']) && !isset($_GET['job_location'])) {
  $name_search = htmlspecialchars($_GET['job_name']);
  $name_search_value = $name_search;
  $location_search = '';
  $location_search_value = $location_search;
  $sql = "SELECT * FROM job where job_title LIKE '%$name_search%' ";
  $stmt = $pdo->query($sql);
  foreach ($stmt as $row) {
    array_push($results, $row);
  }
  $totalPages = ceil(count($result) / COMMENTS_PER_PAGE);
} else {
  $name_search = '';
  $name_search_value = $name_search;
  $location_search = '';
  $location_search_value = $location_search;

  $sql = "SELECT * FROM job";
  $result = array();
  $stmt = $pdo->query($sql);
  foreach ($stmt as $row) {
    array_push($results, $row);
  }
}




// if (isset($_GET['search']) && $_GET['search'] <> '') {
//   $search = htmlspecialchars($_GET['search']);
//   $search_value = $search;

//   try {
//     $db = new Db();
//     $pdo = $db->dbConnect();
//     $stmt = $pdo->prepare("SELECT * FROM job where job_title LIKE ? ");
//     $stmt->execute(array(sprintf('%%%s%%', addcslashes($_GET['search'], '\_%'))));
// $stmt = $pdo->query($sql);
//   foreach ($stmt as $row) {
//     array_push($jobs_info, $row);
//   }


//   $totalPages = ceil(count($jobs_info) / COMMENTS_PER_PAGE);
// } catch (Exception $e) {
//   echo 'エラーが発生しました。:' . $e->getMessage();
// }
// var_dump($_GET['search']);
// } else if {
//   try {
//     $db = new Db();
//     $pdo = $db->dbConnect();

//     $sql = "select * from job limit " . $offset . "," . COMMENTS_PER_PAGE;
//     $stmt = $pdo->query($sql);

//     foreach ($stmt as $row) {
//       array_push($jobs_info, $row);
//     }
//     $sql = "select count(*) from job";
//     $stmt = $pdo->query($sql)->fetchColumn();

//     $totalPages = ceil(intval($stmt) / COMMENTS_PER_PAGE);
//   } catch (PDOException $e) {
//     echo $e->getMessage();
//     exit;
//   }
// } else {
//   try {
//     $db = new Db();
//     $pdo = $db->dbConnect();

//     $sql = "select * from job limit " . $offset . "," . COMMENTS_PER_PAGE;
//     $stmt = $pdo->query($sql);

//     foreach ($stmt as $row) {
//       array_push($jobs_info, $row);
//     }
//     $sql = "select count(*) from job";
//     $stmt = $pdo->query($sql)->fetchColumn();

//     $totalPages = ceil(intval($stmt) / COMMENTS_PER_PAGE);
//   } catch (PDOException $e) {
//     echo $e->getMessage();
//     exit;
//   }
// }



$from = $offset + 1;
$to = $offset + COMMENTS_PER_PAGE < $total ? ($offset + COMMENTS_PER_PAGE)
  : $total;




?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <title>依頼一覧</title>
</head>

<body>
  <div class="container marketing"></div>
  <form method="get" action="result.php">
    <div class="form-row">
      <p class="text-left text-secondary">エリア・店名・期間で検索</ｐ>
        <!-- <div class="col-sm-auto">
            <input type="text" class="form-control" placeholder="年齢" name="age">
          </div> -->
        <div class="col-sm-XX">
          <input type="text" class="form-control" placeholder="店名" name="job_name" id="job_name" value="<?php echo $name_search_value ?>">
        </div>
        <div class="col-sm-XX">
          <input type="text" class="form-control" placeholder="エリア" name="job_location" id="job_location" value="<?php echo $location_search_value ?>">
        </div>
        <input type="submit" name="" value="検索">
    </div>
  </form>
  <!-- <form>
    <class class="form-row">
      <p class="text-left">エリア・店名・期間で検索</ｐ>
        <div class="col-sm-auto">
          <input type="text" class="form-control" placeholder="地域">
        </div>
        <div class="col-sm-XX">
          <input type="text" class="form-control" placeholder="店名">
        </div>
        <div class="col-sm-XX">
          <input type="text" id="datepicker" class="form-control" placeholder="期間">
        </div>
        <a class="btn btn-lg btn-primary nav-link" href="info.php" role="button">検索</a>
    </class>
  </form> -->
  <h1>依頼一覧</h1>
  <p>全<?php echo $total; ?>件中、<?php echo $from; ?>件〜<?php echo $to; ?>件を表示しています。</p>

  <br class="list-unstyled">


  <ul>

    <?php foreach ($results as $result) : ?>
      <li class="media">
        <img width="64" height="64" src="<?php echo $result['job_img_path']; ?>">

        <div class="media-body mt-3">
          <a class="mt-0 mb-1 font-weight-bold" href="job_contents.php?id=<?php echo $result['job_id']; ?>"><?php echo htmlspecialchars($result['job_title'], ENT_QUOTES, 'UTF-8'); ?></a>
          <p>広告依頼内容簡単に記述、クリックで詳細画面へ</p>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>

  <?php if ($page > 1) : ?>
    <a href="?page=<?php echo $page - 1; ?>">前へ</a>

  <?php endif; ?>
  <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
    <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
  <?php endfor; ?>
  <?php if ($page < $totalPages) : ?>
    <a href="?page=<?php echo $page + 1; ?>">次へ</a>
  <?php endif; ?>



  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->

  <script>
    $(function() {
      $("#datepicker").datepicker();
    });
  </script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>