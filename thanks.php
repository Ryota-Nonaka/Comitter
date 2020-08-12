<!DOCTYPE html>
<html lang="ja">

<head>

	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<!-- <link rel="stylesheet" href="src\css\input.css"> -->
	</head>

<body>

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
							<a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
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
		<a href="confirm_input.php">
			<p class="breadcrumb-item">お問い合わせに戻る</p>
		</a>
		</div>
		</div>
		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>

</html>