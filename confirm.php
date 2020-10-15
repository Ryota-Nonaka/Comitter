<?php

require_once(__DIR__ . '/config.php');




// フォームのボタンが押されたら
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // フォームから送信されたデータを各変数に格納
    $name = $_POST["name"];
    $furigana = $_POST["furigana"];
    $email = $_POST["email"];
    $tel = $_POST["tel"];
    $sex = $_POST["sex"];
    $item = $_POST["item"];
    $content  = $_POST["content"];
}


if (isset($_POST["submit"])) {
    try {
        $db = new Db();
        $pdo = $db->dbConnect();

        $stmt = $pdo->prepare("INSERT INTO confirm(name,furigana,email,tel,sex,item,content) VALUES (:name,:furigana,:email,:tel,:sex,:item,:content)");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':furigana', $furigana, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':tel', $tel, PDO::PARAM_STR);
        $stmt->bindParam(':sex', $sex, PDO::PARAM_STR);
        $stmt->bindParam(':item', $item, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);

        $stmt->execute();

        header("Location:thanks.php");
    } catch (PDOException $e) {
        $errorMessage = 'データベースエラー';
        echo $e->getMessage();
    }
}


?>


<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="src\css\input.css"> -->

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


    </br>
    </br>
    </br>
    </br>
    <form action="confirm.php" method="post">


        <input type="hidden" name="name" value="<?php echo $name; ?>">
        <input type="hidden" name="furigana" value="<?php echo $furigana; ?>">
        <input type="hidden" name="email" value="<?php echo $email; ?>">
        <input type="hidden" name="tel" value="<?php echo $tel; ?>">
        <input type="hidden" name="sex" value="<?php echo $sex; ?>">
        <input type="hidden" name="item" value="<?php echo $item; ?>">
        <input type="hidden" name="content" value="<?php echo $content; ?>">
        <h1 class="contact-title center">お問い合わせ 内容確認</h1>
        <p class="center">お問い合わせ内容はこちらで宜しいでしょうか？<br>よろしければ「送信する」ボタンを押して下さい。</p>
        <table class="table">
            <tbody>
                <tr>
                    <th scope="row">お名前</th>
                    <td><?php echo $name; ?></td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <th scope="row">ふりがな</th>
                    <td><?php echo $furigana; ?></td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <th scope="row">メールアドレス</th>
                    <td><?php echo $email; ?></td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <th scope="row">電話番号</th>
                    <td><?php echo $tel; ?></td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <th scope="row">性別</th>
                    <td><?php echo $sex ?></td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <th scope="row">お問い合わせ項目</th>
                    <td><?php echo $item; ?></td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <th scope="row">お問い合わせ内容</th>
                    <td><?php echo nl2br($content); ?></td>
                </tr>
            </tbody>
        </table>
        <input class="btn btn-secondary" type="button" value="内容を修正する" onclick="history.back(-1)">
        <button class="btn btn-primary" type="submit" name="submit">送信する</button>
    </form>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>