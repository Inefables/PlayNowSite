<?php 

// Редирект на страницу авторизации
function RedirectToLogin() {
	$new_url = '/login';
	header('Location: '.$new_url);
	exit();
}

$data = $_POST;
$showError = false;

if (isset($data['form_signup'])) {
	
	$errors = array();
	$showError = True;

	if (empty(trim($data['FIO']))) {
		$errors[] = 'Укажите ФИО!';
	}
	
	if (empty(trim($data['nickname']))) {
		$errors[] = 'Укажите никнейм!';
	}

	if (empty(trim($data['password_1']))) {
		$errors[] = 'Укажите пароль!';
	}

	if (empty(trim($data['password_2']))) {
		$errors[] = 'Подтвердите пароль!';
	}

	if (trim($data['password_1']) != trim($data['password_2'])) {
		$errors[] = 'Пароли не совпадают!';
	}

	if (R::count('users', 'email = ?', array($data['email'])) > 0) {
		$errors[] = 'Пользователь с таким Email уже зарегистрирован!';
	}

	if (empty($errors)) {
		$user = R::dispense('users');
		$user -> fio = htmlspecialchars($data['FIO']);
		$user -> nickname = htmlspecialchars($data['nickname']);
		$user -> email = htmlspecialchars($data['email']);
		$user -> password = password_hash(htmlspecialchars($data['password_1']), PASSWORD_DEFAULT);
		$user -> phone = htmlspecialchars($data['phone']);
		if (R::store($user)) {
			RedirectToLogin();
		} else {
			echo "<script> alert('Произошла ошибка при регистрации!') </script>";
		}

	}

}

?>

<div class="container">
	<div class="row">
		<div class="col-6 mx-auto">
			<h1>Регистрация</h1>

			<p class="fs-3 text-danger">
				<?php
				if ($showError) {
					echo ShowError($errors);
				}
				?>
			</p>

			<form action="" method="POST" id="registForm">

				<div class="mb-3">
					<label for="InputFIO" class="form-label">Фамилия, имя и отчество</label>
					<input type="text" name="FIO" class="form-control" placeholder="Введите данные" 
					id="InputFIO" aria-describedby="FIOhelp" required>
					<div id="FIOhelp" class="form-text">
						Никто не будет видеть ваши личные данные
					</div>
				</div>

				<div class="mb-3">
					<label for="InputNickname" class="form-label">Никнейм</label>
					<input type="text" name="nickname" class="form-control" placeholder="Введите никнейм"
					id="InputNickname" aria-describedby="nicknameHelp" required>
					<div id="nicknameHelp" class="form-text">
						Будет отображаться на сайте
					</div>
				</div>

				<div class="mb-3">
					<label for="InputEmail" class="form-label">Email</label>
					<input type="email" name="email" class="form-control" placeholder="Введите адрес электронной почты"
					id="InputEmail" aria-describedby="emailHelp" required>
					<div id="emailHelp" class="form-text">
						Будет использоваться для входа в личный кабинет и для получения ключей<br> 
						Мы никому не скажем адрес вашей почты
					</div>
				</div>

				<div class="mb-3">
					<label for="InputPassword1" class="form-label">Пароль</label>
					<input type="password" name="password_1" class="form-control" placeholder="Введите пароль"
					id="InputPassword1" required>
				</div>

				<div class="mb-3">
					<input type="password" name="password_2" class="form-control" placeholder="Подтвердите пароль"
					id="InputPassword2" aria-describedby="passwordHelp" required>
					<div id="passwordHelp" class="form-text">
						Никому не сообщайте и не отправляйте свои пароли
					</div>
				</div>

				<div class="mb-3">
					<label for="InputPhone" class="form-label">Номер телефона</label>
					<input type="tel" id="phone" name="phone" class="form-control phone" placeholder="Введите номер телефона"
					id="InputPhone" aria-describedby="nicknamePhone">
					<div id="nicknamePhone" class="form-text">
						Не обязательное поле для заполнения
					</div>
				</div>

				<button type="submit" name="form_signup" class="btn btn-primary">
					Зарегистрироваться
				</button>

			</form>

		</div>
	</div>
</div>

<!-- JS FILES -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<!-- Подключение jQuery плагина Masked Input -->
<script src="../js/plugins/jquery.maskedinput.min.js"></script>
<!-- Подключение основного скрипта -->
<script type="text/javascript" src="../js/mainScript.js"></script>
<!-- Подключение bootstrap скриптов -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


