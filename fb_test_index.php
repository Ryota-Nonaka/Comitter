<?php

require_once(__DIR__ . '/config.php');

$fbLogin = new MyApp\FacebookLogin();

if ($fbLogin->isLoggedIn()) {
  $me = $_SESSION['me'];

  $fb = new MyApp\Facebook($me->fb_access_token);

  $userNode = $fb->getUserNode();
  $posts = $fb->getPosts();

  MyApp\Token::create();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Facebook Login</title>
  <style>
  #container {
    width: 500px;
    margin: 0 auto;
  }
  #login {
    text-align: center;
    margin: 70px auto;
  }
  .btn {
    background: #3b5998;
    color: #fff;
    width: 200px;
    padding: 5px;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
  }
  .btn:hover {
    opacity: 0.8;
  }
  #logout {
    text-align: right;
  }
  #profile {
    text-align: center;
  }
  h1 {
    font-size: 18px;
    margin: 0;
  }
  .pic {
    border-radius: 50%;
    margin-bottom: 10px;
  }
  p {
    margin: 0;
  }
  </style>
</head>
<body>
  <div id="container">

  <?php if ($fbLogin->isLoggedIn()) : ?>

    <div id="logout">
      <form action="logout.php" method="post">
        <input type="submit" value="Log out">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
      </form>
    </div>

    <div id="profile">
      <img src="http://graph.facebook.com/<?= h($me->fb_user_id); ?>/picture" class="pic">
      <h1><a href="<?= h($me->fb_link); ?>"><?= h($me->fb_name); ?></a></h1>
      <p><?= h($userNode['email']); ?></p>
    </div>

    <ul>
      <?php foreach ($posts as $post) : ?>
        <li><?= h($post['message']); ?></li>
      <?php endforeach; ?>
    </ul>

  <?php else : ?>

    <div id="login">
      <a href="login.php" class="btn">Facebook Login</a>
    </div>

  <?php endif; ?>
  </div>
</body>
</html>