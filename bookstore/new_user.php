<?php 
	require("connection.php");
?>
<?php 
	if ($_SESSION[employee]!=true) {
		echo '<meta http-equiv=Refresh content="0; index.php">'; 
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="/image/index.svg" type="image/x-icon"> <!-- иконка сайта во вкладке-->
	<link rel="preconnect" href="https://fonts.gstatic.com"> <!-- подключение шрифта -->
	<link href="https://fonts.googleapis.com/css2?family=Pangolin&display=swap" rel="stylesheet"> <!-- подключение шрифта -->
	<link rel="stylesheet" type="text/css" href="css/style.css"> <!-- подключение css -->
	<title> BookStore "TayaBook" добавить пользователя  </title>
</head>
<body>
	<header class="header" style="justify-content: center;">
		<div style="display: flex; justify-content: center; text-align: center;">
			<h1 class="title_index"> Добавить пользователя </h1>
		</div>
	</header>
	<section>
		<div class="center">
			<div class="container"> <!-- контейнер с книгой  -->
				<div class="w100">
					<br>
					<?php
						if (isset($_POST[new_user])) {
							if (!empty($_POST[name]) and !empty($_POST[surname]) and !empty($_POST[phone]) and !empty($_POST[login]) and !empty($_POST[password])) { //*проверка на пустоту полей, всех, кроме отчества, т.к. оно необязательное*
								if (preg_match('/^[a-zA-Z0-9]+$/', $_POST[login])) {  //preg_match - маска ввода (пропустит только указанные символы)
									$name_count=(strlen($_POST[name]))/2;
									if ($name_count>1 and $name_count<=60) {   // по 60 символов на имя, фамилию и отчество
										$name_count=(strlen($_POST[surname]))/2;
										if ($name_count>1 and $name_count<=60) {
											$name_count=strlen(($_POST[lastname]))/2;
											if ($name_count==0 xor ($name_count>=2 and $name_count<=60)){
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
															 			if ($_POST[rank]=='0') {
															 				$rank='Клиент';
															 			}
															 			else {
															 				$rank='Сотрудник';
															 			}
															 			$error=false;
															 			$message='Пользователь успешно добавлен.';
																		$query ="INSERT INTO Users (`Phone_Number_User`, `Username`, `Login`, `Password`, `Rank_User`) values ('$_POST[phone]', '$_POST[surname]"." "."$_POST[name]"." "."$_POST[lastname]', '$_POST[login]', '$_POST[password]', '$rank')"; //"" - в них sql-запрос; '' - все остальное
																		$res = mysqli_query($link, $query) or die(mysqli_error($link));//отправка в БД	
																		echo '<meta http-equiv=Refresh content="1; users.php">'; //- перенаправит через 1 секунду на страницу авторизации
																	}
																	else {
																		$error=true;
																		$message='Этот номер телефона уже занят.';
																	}
																} 
																else {
																	$error=true;
																	$message='Этот логин уже занят.';
																}
															}
															else {
																$error=true;
																$message='Максимальная длина пароля - 20 символов.';
															}
														}
														else {
															$error=true;
															$message='Минимальная длина пароля - 6 символов.';
														}
													}
													else {
														$error=true;
														$message='Максимальная длина логина - 20 символов.';
													}
												}
												else {
													$error=true;
													$message='Минимальная длина логина - 4 символа.';
												}
											}											
											else {
												$error=true;
												$message='Отчество должно содержать 2-60 символов.';
											}
										}
										else {
											$error=true;
											$message='Фамилия должна содержать 2-60 символов.';
										}	
									}
									else {
										$error=true;
										$message='Имя должно содержать 2-60 символов.';
									}
								}
								else {
									$error=true;
									$message='В логине можно использовать только латинские буквы и цифры.';
								}
							}
							else {
								$error=true;
								$message='Пожалуйста, заполните все поля.';
							}
						}
						if (isset($_POST[not_new_user])) {
							echo '<meta http-equiv=Refresh content="0; users.php">';
						}
					?>
					<div style="display: flex; width: 1320px; font-size: 30px; justify-content: center; align-items: center;">
						<form method="POST">
							<div style="display: flex; justify-content: space-around; margin-bottom: 10px;">
								<div style="width:40%">
									<strong> Фамилия: </strong>
								</div>
								<div>
								<input name="surname" type="text" autocomplete="off" placeholder="Фамилия" value="<?php echo $_POST[surname]; ?>" class="acc"> 
								</div>
							</div>
							<div style="display: flex; justify-content: space-around; margin-bottom: 10px;">
								<div style="width:40%">
									<strong> Имя: </strong>
								</div>
								<div>
									<input name="name" type="text" autocomplete="off" placeholder="Имя" value="<?php echo $_POST[name]; ?>" class="acc"> 
								</div>
							</div>
							<div style="display: flex; justify-content: space-around; margin-bottom: 10px;">
								<div style="width:40%">
									<strong> Отчество: </strong>
								</div>
								<div style="margin-left: 100px;">	
									<input name="lastname" type="text" autocomplete="off" placeholder="Отчество" value="<?php echo $_POST[lastname]; ?>" class="acc"> 
								</div>
							</div>
							<div style="display: flex; justify-content: space-around; margin-bottom: 10px;">
								<div style="width:40%">
									<strong> Номер телефона: </strong>
								</div>
								<div>
									<input type="tel" name="phone" pattern="8[0-9]{10}" placeholder="Номер телефона" autocomplete="off" value="<?php echo $_POST[phone]; ?>" class="acc"> 
								</div>
							</div>
							<div style="display: flex; justify-content: space-around; margin-bottom: 10px;">
								<div style="width:40%">
									<strong> Логин: </strong>
								</div>
								<div>
									<input name="login" type="text" autocomplete="off" placeholder="Логин" value="<?php echo $_POST[login]; ?>" class="acc"> 
								</div>
							</div>
							<div style="display: flex; justify-content: space-around; margin-bottom: 10px;">
								<div style="width:40%">
									<strong> Пароль: </strong>
								</div>
								<div>
									<input name="password" type="password" autocomplete="off" placeholder="Пароль" class="acc"> 
								</div>
							</div>
							<div style="display: flex;">
								<div style="width: 40% margin: 0;">
									<strong> Ранг: </strong>
								</div>
								<div style="margin-left: 171px;">
									<select class="acc" style="" name="rank">
										<option value="0">Клиент</option>
										<option value="1">Сотрудник</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div style="display: flex; justify-content: center; margin-left: 100px;">
						<div style="width: 700px;">
							<input type="submit" name="new_user" style="" class="button_reg cto-to edit_but edit_but" value="Добавить пользователя">
							<input type="submit" name="not_new_user" style="" class="button_reg cto-to edit_but edit_but_r" value="Отмена">
						</div>
					</div>
				</form>	
			</div>
			<?php if ($error==false) { ?>
				<p class="success"><?php echo $message; ?></p>
			<?php }
			else { ?>
				<p class="error" ><?php echo $message; ?></p>
			<?php } ?>
		</div>
	</section>
</body>
</html>


