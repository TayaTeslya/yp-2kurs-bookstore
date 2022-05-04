<?php  
	require("connection.php");
?>
<?php 
	if (isset($_POST[submit])) {
		if (!empty($_POST[login]) and !empty($_POST[password])) {
			$_POST[password]=md5($_POST[password]);
			$query = "SELECT * FROM Users WHERE (`Login`='$_POST[login]' AND `Password`='$_POST[password]')";
			$res = mysqli_query($link, $query) or die(mysqli_error($link));
	 		$rank = mysqli_fetch_assoc($res);
	 		$_SESSION[username]=$rank[Username];
	 		$_SESSION[id_user]=$rank[ID_User];
	 		if ($rank!=null) {
	 			$_SESSION[auth]=true; //глобальная переменная, т.е. используется во всех .php-файлах с session_start();
	 			$message='<p class="success"> Авторизация прошла успешно.</p>';
		 		if ($rank[Rank_User]=='Сотрудник') {
		 			$_SESSION[employee]=true;  //Если авторизованный пользователь является сотрудником, то ему выдаются права по работе с БД
				}
	 			echo '<meta http-equiv=Refresh content="1; index.php">'; // переход на главную страницуЕ
	 		}
	 		else {
	 			$message='<p class="error"> Логин или пароль введены неверно.</p>';
	 		}
		}
		else {
			$message='<p class="error"> Пожалуйста, заполните все поля.</p>';
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="/image/index.svg" type="image/x-icon"> <!-- иконка сайта во вкладке-->
	<link rel="preconnect" href="https://fonts.gstatic.com"> <!-- подключение шрифта -->
	<link href="https://fonts.googleapis.com/css2?family=Pangolin&display=swap" rel="stylesheet"> <!-- подключение шрифта -->
	<link rel="stylesheet" type="text/css" href="css/style.css"> <!-- подключение css -->
	<title> BookStore "TayaBook" авторизация  </title>
</head>
<body>
	<div class="reg_background">
		<div class="user_registration-center"> <!-- расположение формы относительно страницы -->
			<h1 class="title">АВТОРИЗАЦИЯ</h1>
			<div class="user_form-wrapper">	<!-- "обертка" формы -->
				<form class="user_form-registration" method="POST">  <!-- расположение внутри формы -->
					<input type="text" name="login" placeholder="Логин" autocomplete="off" value="<?php echo $_POST[login] ?>">
					<input type="password" name="password" placeholder="Пароль" autocomplete="off"> 
					<input class="user_registration-button" type="submit" name="submit" value="Авторизоваться">
				</form>
				<?php echo $message;?> <!-- ошибка при введении не всех обязательных полей -->
				<a class="auth" href="reg.php">Нет аккаунта? Зарегистрироваться</a>
			</div>
		</div>
	</div>
</body>
</html>

