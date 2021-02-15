<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/incs/data.php';
require_once __DIR__ . '/incs/functions.php';

if (!empty($_POST)) {
	if (isset($_POST['id_form'])) {
		$fields = $mes = '';
		if ($_POST['id_form'] == 'formLogin') {
			$fields = load($fieldsLogin);
		} else {
			$fields = load($fieldsRegist);
		}

		$res = '';
		if ($erros = validate($fields)) {
			$res = ['answer' => 'error', 'errors' => $erros];
		} else {
			$flag = '';	
			if ($fields['id_form']['value'] == 'formLogin') {
			
				$res = ['answer' => 'ok', 'message' => 'You are welcome'];
			} else {
				if (!send_mail($fields, $mail_settings)) {
					$res = ['answer' => 'error', 'errors' => 'Error send message'];
				} else {
					$res = ['answer' => 'ok', 'message' => 'You have registered. A letter has been sent to your mail'];
				}
			}
		}
		exit(json_encode($res));
	}
	exit(json_encode(['answer' => 'error']));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="css/style.min.css" type="text/css">
</head>

<body>

	<div class="wrapper">
		<div class="container">

			<h1 class="header">Login To Your Account / Register New</h1>
			<div class="forms__title title">
				<div class="title__icon">
					<picture>
						<source srcset="img/icons/compose.webp" type="image/webp"><img src="img/icons/compose.png" alt="">
					</picture>
				</div>

				<div class="title__text">
					Login To Your Account / Register New
				</div>
			</div>
			<div class="forms__container" id="forms__container">
				<div class="forms__item form">
					<div class="forms__decor">
						<span></span>
					</div>
					<form method="POST" id="formLogin" name="formLogin" class="form__body form__body_l needs_validate">
						<div class="form__item">
							<div class="custom_input">
								<input id="loginName" type="text" name='name' class="form__input _req _alpha" placeholder="UserName" autocomplete="off">

							</div>
						</div>
						<div class="form__item">
							<input id="loginPassword" type="password" name="password" class="form__input _req _password" placeholder="Password" autocomplete="off">
						</div>
						<div class="form__group">
							<div class="form__item">
								<div class="options">
									<div class="options__item">
										<input id="loginRemember" type="checkbox" name="remember" class="options__input">
										<label for="loginRemember" class="options__label">Remember My password</label>
										<div class="options__tooltip">
											You no longer need to enter a password every time you use the site
										</div>
									</div>
								</div>
							</div>
							<input type="hidden" name="id_form" value="formLogin">
							<div class="form__item">
								<button class="form__btn" type="submit">Login</button>
							</div>
						</div>
					</form>
				</div>
				<div class="forms__item form">
					<h1 class="form__title">Register</h1>
					<form method="POST" id="formRegist" name="formRegist" class="form__body needs_validate">
						<div class="form__item">
							<label for="registEmail" class="form__label">Email</label>
							<input id="registEmail" type="text" name="email" class="form__input form__input_s _req _email" autocomplete="off">
						</div>
						<div class="form__item">
							<label for="registName" class="form__label">User Name</label>
							<input id="registName" type="text" class="form__input form__input_s _req _alpha" name="name" autocomplete="off">
						</div>
						<div class="form__item">
							<label for="registPassword" class="form__label">Password</label>
							<input id="registPassword" type="password" class="form__input form__input_s _req _password" name="password" autocomplete="off">
						</div>
						<div class="form__item form__item_right">
							<button class="form__btn form__btn_yellow" type="submit">Register</button>
						</div>
						<input type="hidden" name="id_form" value="formRegist">
					</form>
				</div>

			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="js/main.min.js"></script>
</body>

</html>