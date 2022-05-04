<?php  
	require("connection.php");
?>
<?php //echo $_POST[name]; - вывод переменной
	if (isset($_POST[submit])) { //isset - если существует, в данном случае если на кнопку "зарегистрироваться нажали"
		if ((!empty($_POST[name])) and (!empty($_POST[surname])) and (!empty($_POST[phone])) and (!empty($_POST[login])) and (!empty($_POST[password]))) { //*проверка на пустоту полей, всех, кроме отчества, т.к. оно необязательное*
			if (preg_match('/^[a-zA-Z0-9]+$/', $_POST[login])) {  //preg_match - маска ввода (пропустит только указанные символы)
				$name_count=(strlen($_POST[name]))/2;
				if ($name_count>1 and $name_count<=60) {   // по 60 символов на имя, фамилию и отчество
					$name_count=(strlen($_POST[surname]))/2;
					if ($name_count>1 and $name_count<=60) {
						$name_count=(strlen($_POST[lastname]))/2;
						if ($name_count==0 xor ($name_count>=2 and $name_count<=60)) {
							if ($_POST[phone][0]==8) {
								$name_count=strlen($_POST[phone]);
								if ($name_count==11) {
									$login_count=strlen($_POST[login]);  //strlen - длина строки
									if ($login_count>=4){
										if ($login_count<=20){
											$pass_count=strlen($_POST[password]); 
											if ($pass_count>=6){
												if ($pass_count<=20){
													$_POST[password]=md5($_POST[password]);
													$query = "SELECT * FROM Users WHERE (`Login`='$_POST[login]')";
													$res = mysqli_query($link, $query) or die(mysqli_error($link));
											 		$num = mysqli_num_rows($res);
											  		if($num == 0) {   //*проверка есть ли такой логин и номер телефона*
											  			$query = "SELECT * FROM Users WHERE (`Phone_Number_User`='$_POST[phone]')";
														$res = mysqli_query($link, $query) or die(mysqli_error($link));
												 		$num = mysqli_num_rows($res);
												 		if ($num == 0) { //проверка, занят ли номер телефона
															$query ="INSERT INTO Users (`Phone_Number_User`, `Username`, `Login`, `Password`, `Rank_User`) values ('$_POST[phone]', '$_POST[surname]"." "."$_POST[name]"." "."$_POST[lastname]', '$_POST[login]', '$_POST[password]', 'Клиент')"; //"" - в них sql-запрос; '' - все остальное
															$res = mysqli_query($link, $query) or die(mysqli_error($link));//отправка в БД	
															$message='<p class="success"> Регистрация прошла успешно. </p>';
															echo '<meta http-equiv=Refresh content="1; auth.php">'; //- перенаправит через 1 секунду на страницу авторизации
														}
														else {
															$message='<p class="error">Этот номер телефона уже занят.</p>';
														}
													} 
													else {
														$message='<p class="error">Этот логин уже занят.</p>';
													}
												}
												else {
													$message='<p class="error">Максимальная длина пароля - 20 символов.</p>';
												}
											}
											else {
												$message='<p class="error">Минимальная длина пароля - 6 символов.</p>';
											}
										}
										else {
											$message='<p class="error">Максимальная длина логина - 20 символов.</p>';
										}
									}
									else {
										$message='<p class="error">Минимальная длина логина - 4 символа.</p>';
									}
								}
								else {
									$message='<p class="error">Введите корректный номер телефона.</p>';
								}
							}
							else {
								$message='<p class="error">Номер телефона должен начинаться с 8.</p>';
							}

						}
						else {
							$message='<p class="error">Отчество должно содержать 2-60 символов.</p>';
						}
					}
					else {
						$message='<p class="error">Фамилия должна содержать 2-60 символов.</p>';
					}	
				}
				else {
					$message='<p class="error">Имя должно содержать 2-60 символов.</p>';
				}
			}
			else {
				$message='<p class="error">В логине можно использовать только латинские буквы и цифры.</p>';
			}
		}
		else {
			$message='<p class="error">Пожалуйста, заполните все поля.</p>';
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
	<title> BookStore "TayaBook" регистрация </title>
</head>
<body>
	<div class="reg_background">
		<div class="user_registration-center"> <!-- расположение формы относительно страницы -->
			<h1 class="title">РЕГИСТРАЦИЯ</h1>
			<div class="user_form-wrapper">	<!-- "обертка" формы -->
				<form class="user_form-registration" method="POST">  <!-- расположение внутри формы -->
					<input type="text" name="surname" placeholder="Ваша фамилия" autocomplete="off" value="<?php echo $_POST[surname] ?>">
					<input type="text" name="name" placeholder="Ваше имя" autocomplete="off" value="<?php echo $_POST[name] ?>">
					<input type="text" name="lastname" placeholder="Ваше отчество" autocomplete="off" value="<?php echo $_POST[lastname] ?>"><span class="liliput">*необязательное поле</span>
					<input type="tel" pattern="8[0-9]{10}" name="phone" placeholder="Ваш номер телефона" autocomplete="off" value="<?php echo $_POST[phone] ?>">
					<input type="text" name="login" placeholder="Логин" autocomplete="off" value="<?php echo $_POST[login] ?>">
					<input type="password" name="password" placeholder="Пароль" autocomplete="off"> 
					<input class="user_registration-button" type="submit" name="submit" value="Зарегистрироваться">
				</form>
				<?php echo $message;?> <!-- ошибка при введении не всех обязательных полей -->
				<a class="auth" href="auth.php">Уже есть аккаунт? Авторизироваться</a>
			</div>
		</div>
	</div>
</body>
</html>

