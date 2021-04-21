<?php 

// Редирект на страницу авторизации
function RedirectToLogin() {
	$new_url = '/login';
	header('Location: '.$new_url);
	exit();
}

?>

<div class="container tt-milks-ff">
	<h1>Личный кабинет</h1>
	<?php 

	$user = R::findOne('users', 'id = ?', array($_SESSION['id']));

	if ($user) {
		echo "Добро пожаловать,".$user->nickname;
		echo "<br><br><a href='/logout' class='btn btn-danger' id='exitBtn'>Выход</a>";
	} else {
		RedirectToLogin();
	}
	?>
</div>


<script type="text/javascript" src="../js/mainScript.js"></script>


