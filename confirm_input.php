<!DOCTYPE html>
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
	<form action="confirm.php" method="post" name="form" onsubmit="return validate()">
		<h1 class="contact-title">お問い合わせ 内容入力</h1>
		<p>お問い合わせ内容をご入力の上、「確認画面へ」ボタンをクリックしてください。</p>
		<div class="container-fluid col-md-6">

			<label>お名前</label>
			<input class="form-control" type="text" name="name" placeholder="例）山田太郎" value="">

			<label>ふりがな</label>
			<input class="form-control type=" text" name="furigana" placeholder="例）やまだたろう" value="">

			<label>メールアドレス</label>
			<input class="form-control" type="text" name="email" placeholder="例）guest@example.com" value="">

			<label>電話番号</label>
			<input class="form-control" type="text" name="tel" placeholder="例）0000000000" value="">

			<div class="form-check">
				<label for="radio1">性別</label>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="sex" id="radio1" value="男性" checked>
					<label class="form-check-label" for="radio1">男性</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="sex" id="radio2" value="女性">
					<label class="form-check-label" for="radio2">女性</label>
				</div>
			</div>

			<label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">お問い合わせ項目</label>
			<select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="item">
				<option selected value="">お問い合わせ項目を選択してください</option>
				<option value="ご質問・お問い合わせ">ご質問・お問い合わせ</option>
				<option value="ご意見・ご感想">ご意見・ご感想</option>
			</select>

			<label>お問い合わせ内容</label>
			<textarea class="form-control" name="content" rows="10" placeholder="お問合せ内容を入力"></textarea>
			</br>
			<button class="btn btn-primary" type="submit">確認画面へ</button>
		</div>
	</form>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>