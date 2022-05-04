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
	<title> BookStore "TayaBook" редактировать логин и пароль пользователя </title>
</head>
<body>
	<header class="header" style="justify-content: center;">
		<div style="display: flex; justify-content: center; text-align: center;">
			<h1 class="title_index"> Редактировать логин и пароль пользователя </h1>
		</div>
	</header>
	<section>
		<div class="center">
			<div class="container"> <!-- контейнер с книгой  -->
				<div class="w100">
					<br>
					<?php
						$query="SELECT * FROM `Users` WHERE (`ID_User`='$_SESSION[user_id]')"; //отправка запроса на выборку книг из БД
						$res=mysqli_query($link, $query) or die(mysqli_error($link)); 
						$row=mysqli_fetch_assoc($res);
						$name=explode(" ", $row[Username]);
						if (isset($_POST[new_login])) {
							if (!empty($_POST[login]) and !empty($_POST[password])) { //*проверка на пустоту полей, всех, кроме отчества, т.к. оно необязательное*
								if (preg_match('/^[a-zA-Z0-9]+$/', $_POST[login])) {  //preg_match - маска ввода (пропустит только указанные символы)
									$login_count=strlen($_POST[login]);  //strlen - длина строки
									if ($login_count>=4){
										if ($login_count<=20){
											$pass_count=strlen($_POST[password]); 
											if ($pass_count>=6){
												if ($pass_count<=20){
													$_POST[password]=md5($_POST[password]);
													$query = "SELECT * FROM `Users` WHERE (`Login`='$_POST[login]' AND `ID_User`!='$_SESSION[user_id]')";
													$res = mysqli_query($link, $query) or die(mysqli_error($link));
											 		$num = mysqli_num_rows($res);
											  		if($num == 0) {   //*проверка есть ли такой логин и номер телефона*
															$query="UPDATE `Users` SET `Login`='$_POST[login]', `Password`='$_POST[password]' WHERE `ID_User`='$_SESSION[user_id]'"; //"" - в них sql-запрос; '' - все остальное
															$res = mysqli_query($link, $query) or die(mysqli_error($link));//отправка в БД	
															$error=false;
															$message='Изменения успешно внесены.';
															echo '<meta http-equiv=Refresh content="1; edit_user.php">'; //- перенаправит через 1 секунду на страницу авторизации
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
									$message='В логине можно использовать только латинские буквы и цифры.';
								}
							}
							else {
								$error=true;
								$message='Пожалуйста, заполните все поля.';
							}
						}
						else {
							$_POST[login]=$row[Login];
						}
						if (isset($_POST[not_new_login])) {
							echo '<meta http-equiv=Refresh content="0; edit_user.php">';
						}
						if (isset($_POST[del_user])) {
							//orders, basket
							$query = "UPDATE `Orders` SET `ID_User`=(SELECT `ID_User` FROM `Users` WHERE `Username`='УДАЛЁННЫЙ ПОЛЬЗОВАТЕЛЬ') WHERE  (`ID_User`='$_SESSION[user_id]')";
							$res = mysqli_query($link, $query) or die(mysqli_error($link));
							$query = "UPDATE `Basket` SET `ID_User`=(SELECT `ID_User` FROM `Users` WHERE `Username`='УДАЛЁННЫЙ ПОЛЬЗОВАТЕЛЬ') WHERE  (`ID_User`='$_SESSION[user_id]')";
							$res = mysqli_query($link, $query) or die(mysqli_error($link));
							$query = "DELETE FROM `Users` WHERE  (`ID_User`='$_SESSION[user_id]')";
							$res = mysqli_query($link, $query) or die(mysqli_error($link));
							echo '<meta http-equiv=Refresh content="1; users.php">';
							$error=false;
							$message='Пользователь успешно удалён.';
						}
					?>
					<div style="display: flex; width: 1320px; font-size: 30px; justify-content: center; align-items: center;">
						<form method="POST">
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
							<div>
								<input type="submit" name="new_login" class="button_reg cto-to edit_but edit_but" value="Внести изменения">
								<input type="submit" name="del_user" style="margin: 0; margin-right:10px;" class="button_reg cto-to edit_but edit_but edit_but_r" value="Удалить пользователя">
								<input type="submit" name="not_new_login" class="button_reg cto-to edit_but edit_but_r" value="Отмена">
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
			</div>
		</div>
	</section>
</body>
</html>


