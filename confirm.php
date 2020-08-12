<?php

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;
// use PHPMailer\PHPMailer\OAuth;

// use League\OAuth2\Client\Provider\Google;

// require 'src\php_mailer\vendor\autoload.php';
// mb_language("ja");
// mb_internal_encoding("UTF-8");




$dsn = 'mysql:dbname=confirm;host=localhost';
$user = 'user';
$pass = "baramo0814";
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
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

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
        exit;
    } catch (PDOException $e) {
        $errorMessage = 'データベースエラー';
        echo $e->getMessage();
    }
}


//     try {
//         $mail = new PHPMailer(true);
//         $mail->CharSet = "iso-2022-jp";
//         $mail->Encoding = "7bit";
//         $mail->setLanguage('ja', 'src/php_mailer/vendor/phpmailer/phpmailer/language/');

//         $mail->SMTPDebug = SMTP::DEBUG_SERVER;
//         $mail->isSMTP();
//         $mail->Host = 'smtp.gmail.com';
//         $mail->SMTPAuth = true;
//         $mail->SMTPSecure = 'ssl';
//         $mail->Authtype = 'XOAUTH2';
//         $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
//         $mail->port = 465;

//         $google_email = 'tdnblue@gmail.com';

//         $clientId = '726992193287-i19lohgv0qt3e7608rj1be638ojvj3sb.apps.googleusercontent.com';
//         $clientSecret = 'C3CXF5q86gR6QvJol9N2b_Tl';
//         $refreshToken = ' 1//0enYUI79utwL6CgYIARAAGA4SNwF-L9IrNlZ3WkO-dEWW1h2RI4fggAZIM7UD2N5mmJnVkMFEsVEMFcc6tJdMHydFkMDPQj06b1I';

//         $provider = new Google(
//             [
//                 'clientId' => $clientId,
//                 'clientSecret' => $clientSecret,
//             ]
//         );

//         $mail->setOAuth(
//             new OAuth(
//                 [
//                     'provider' => $provider,
//                     'clientId' => $clientId,
//                     'clientSecret' => $clientSecret,
//                     'refreshToken' => $refreshToken,
//                     'userName' => $google_email,
//                 ]
//             )
//         );

//         $mail->setFrom('tdnblue@gmail.com', mb_encode_mimeheader('野中凌太'));
//         $mail->addAddress($email, mb_encode_mimeheader($name));
//         $mail->addReplyTo('tdnblue@gmail.com', mb_encode_mimeheader("お問い合わせ"));
//         // $mail->addCC('foo@example.com'); 

//         $mail->isHTML(true);
//         $mail->Subject = mb_encode_mimeheader("［自動送信］お問い合わせ内容の確認");
//         $mail->Body  = mb_convert_encoding(<<< EOM
//         {$name} 様
//         </br>
//         お問い合わせありがとうございます。
//         以下のお問い合わせ内容を、メールにて確認させていただきました。
//         </br>
//         ===================================================
//         【 お名前 】 
//         {$name}
//         </br>
//         【 ふりがな 】 
//         {$furigana}
//         </br>
//         【 メール 】 
//         {$email}
//         </br>
//         【 電話番号 】 
//         {$tel}
//         </br>
//         【 性別 】 
//         {$sex}
//         </br>
//         【 項目 】 
//         {$item}
//         </br>
//         【 内容 】 
//         {$content}
//         ===================================================
//         </br>
//         内容を確認のうえ、回答させて頂きます。
//         しばらくお待ちください。
//         EOM, "JIS", "UTF-8");

//         $mail->send();
//         header("Location:thanks.php");
//         exit;
//     } catch (Exception $e) {
//         //エラー（例外：Exception）が発生した場合
//         echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
//     }
// }

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
            <!-- <label class="col-md-5 border-bottom bg-light">お名前</label> -->
            <!-- <p class="col-md-6 border-bottom"></p> -->
            <!-- </div> -->
            <!-- <div class="row">
                <label class="col-md-5 border-bottom bg-light">ふりがな</label> -->
            <tbody>
                <tr>
                    <th scope="row">ふりがな</th>
                    <td><?php echo $furigana; ?></td>
                </tr>
            </tbody>
            <!-- <p class="col-md-6 border-bottom"></p> -->
            <!-- </div>
            <div class="row">
                <label class="col-md-5 border-bottom bg-light">メールアドレス</label> -->
            <tbody>
                <tr>
                    <th scope="row">メールアドレス</th>
                    <td><?php echo $email; ?></td>
                </tr>
            </tbody>
            <!-- <p class="col-md-6 border-bottom"></p> -->
            <!-- </div>
            <div class="row">
                <label class="col-md-5 border-bottom bg-light">電話番号</label> -->
            <tbody>
                <tr>
                    <th scope="row">電話番号</th>
                    <td><?php echo $tel; ?></td>
                </tr>
            </tbody>
            <!-- <p class="col-md-6 border-bottom"></p>
            </div>
            <div class="row">
                <label class="col-md-5 border-bottom bg-light">性別</label>
                <p class="col-md-6 border-bottom"></p>
            </div> -->
            <tbody>
                <tr>
                    <th scope="row">性別</th>
                    <td><?php echo $sex ?></td>
                </tr>
            </tbody>
            <!-- <div class="row">
                <label class="col-md-5 border-bottom bg-light">お問い合わせ項目</label>
                <p class="col-md-6 border-bottom"></p>
            </div> -->
            <tbody>
                <tr>
                    <th scope="row">お問い合わせ項目</th>
                    <td><?php echo $item; ?></td>
                </tr>
            </tbody>
            <!-- <div>
                <label class="col-md-5 border-bottom bg-light">お問い合わせ内容</label>
                <p class="col-auto"></p>
            </div> -->
            <tbody>
                <tr>
                    <th scope="row">お問い合わせ内容</th>
                    <td><?php echo nl2br($content); ?></td>
                </tr>
            </tbody>
        </table>
        <input class="btn btn-primary" type="button" value="内容を修正する" onclick="history.back(-1)">
        <button class="btn btn-primary" type="submit" name="submit">送信する</button>
    </form>
    
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>