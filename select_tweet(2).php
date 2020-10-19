<?php
require_once(__DIR__ . '/config.php');

$user_id = $_SESSION['user_id'];
$job_id = $_SESSION['job_id'];

$twitterLogin = new MyApp\TwitterLogin();
$me = $_SESSION['me'];
$token = $_SESSION['token'];



$twitter = new MyApp\Twitter($me->tw_access_token, $me->tw_access_token_secret);

$tweets = array();
$tweet = array();

$tweets = $twitter->getTweets();


$tweet_array = array();
foreach ($tweets as $tweet) {
  $tweet_array[] = json_decode(json_encode($tweet), true);
  $results = array();
  $result = array();
}


// var_dump($tweet_array[1]['text']);

// var_dump($tweet_array['text']);
if (isset($_GET['search_tweets'])) {
  $key = $_GET['search_tweets'];



  $pattern = "/" . preg_quote($key, "/") . "/i";
  $results = array_filter(
    $tweet_array,
    function ($tw) use ($pattern) {
      if (preg_match($pattern, $tw['text'])) {
        return true;
      }
    },
    ARRAY_FILTER_USE_BOTH
  );
} else if (!isset($_GET['search_tweets'])) {
  $results = $tweet_array;
}


MyApp\Token::create();



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

  <h1>@<?= h($me->username); ?>'s Timeline</h1>
  <form type="text" name="search_tweets" method="get" action="">
    <input type="text" name="search_tweets" action="getTweets.php">
    <input type="submit" id="page" value="検索">
  </form>

  <ul>
    <?php foreach ($results as $result) : ?>
      <li><?= $result['text']; ?>
        <?php if (isset($result['entities'])) :
          $media_url = '';
          $entities = $result['entities'];
          if (isset($entities['media'])) :
            foreach ($entities['media'] as $entitie) :
              $media_url = $entitie['media_url'];
        ?>
              <img src="<?= $media_url; ?>">
            <?php endforeach; ?>
          <?php endif; ?>
        <?php endif; ?>
        <div class="media-body mt-3"><a href="https://twitter.com/<?= h($name) ?>/status/<?= $result['id']; ?>"><?= "https://twitter.com/" . $name . "/status/" . $result['id']; ?></a>
          <form method="post" action="">
            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
            <input type="hidden" name="job_id" value="<?= $_SESSION['job_id']; ?>">
            <input type="hidden" name="id" value="<?= $result['id']; ?>">
            <button class="btn btn-primary" name="tweet" type="button" data-toggle="modal" data-target="#<?= $result['id']; ?>">
              tweetを選択する
            </button>
          </form>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>


  <?php foreach ($results as $result) : ?>
    <div class="modal fade" id="<?= $result['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="<?= $result['id']; ?>Label" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="<?= $result['id']; ?>Label">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            ...
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>



  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
  <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>