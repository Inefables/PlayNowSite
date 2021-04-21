<?php 

$data = $_POST;

$showError = false;

if (isset($data['form_login'])) {
	
	$errors = array();
	$showError = True;

	if (empty(trim($data['email']))) {
		$errors[] = 'Укажите Email!';
	}

	if (empty(trim($data['password']))) {
		$errors[] = 'Укажите пароль!';
	}

	$user = R::findOne('users', 'email = ?', array($data['email']));
	if ($user) {
		if (password_verify($data['password'], $user->password)) {
			$_SESSION['id'] = $user->id;

			RedirectToProfile();

		} else {
			$errors[] = 'Неверный пароль';
		}
	} else {
		$errors[] = 'Пользователь не найден';
	}
}

// Редирект на страницу личного кабинета
function RedirectToProfile() {
	$new_url = '/profile';
	header('Location: '.$new_url);
	exit();
}


?>

<div class="container">
	<div class="row">
		<div class="col-6 mx-auto">
			<h1>Авторизация</h1>
			<p class="fs-3 text-danger">
				<?php
				if ($showError) {
					echo ShowError($errors);
				}
				?>
			</p>
			<form action="" method="POST">

				<div class="mb-3">
					<label for="InputEmail" class="form-label">Email</label>
					<input type="email" name="email" class="form-control" 
					id="InputEmail" aria-describedby="emailHelp">
					<div id="emailHelp" class="form-text">
						Мы никогда никому не скажем адрес вашей почты.
					</div>
				</div>

				<div class="mb-3">
					<label for="InputPassword" class="form-label">Пароль</label>
					<input type="password" name="password" class="form-control" 
					id="InputPassword">
				</div>

				<div class="mb-3 text-align-center">
					<button type="submit" name="form_login" class="btn btn-primary">
						Войти
					</button>
				</div>

			</form>
			<div class="mb-3 text-align-center">
				<a href="/register" class="btn btn-warning">Зарегистрироваться</a>
			</div>
			

		</div>
	</div>
</div>
