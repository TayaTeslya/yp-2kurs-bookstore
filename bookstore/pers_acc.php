<?php 
	require("connection.php");
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="/image/index.svg" type="image/x-icon"> <!-- иконка сайта во вкладке-->
	<link rel="preconnect" href="https://fonts.gstatic.com"> <!-- подключение шрифта -->
	<link href="https://fonts.googleapis.com/css2?family=Pangolin&display=swap" rel="stylesheet"> <!-- подключение шрифта -->
	<link rel="stylesheet" type="text/css" href="css/style.css"> <!-- подключение css -->
	<title> BookStore "TayaBook" персональный аккаунт </title>
</head>
<body>
	<header class="header" style="justify-content: center;">
		<h1 class="title_index"> Персональный аккаунт </h1>
	</header>
	<?php 
		if ($_SESSION['auth'] != 'true') {
			echo '<meta http-equiv=Refresh content="0; index.php">'; //в случае попадения на эту страницу неавторизованного пользователя, редирект на главную страницу
		}
		$query = "SELECT * FROM Users WHERE (`ID_User`='$_SESSION[id_user]')";
		$res = mysqli_query($link, $query) or die(mysqli_error($link));
	 	$row = mysqli_fetch_assoc($res);
 		$name=explode(" ", $row[Username]);
		if (isset($_POST[submit])) {
			$row[Phone_Number_User]=$_POST[phone];
			$row[Login]=$_POST[login];
			$name_count=strlen(($_POST[name]))/2;
			if ($name_count>1 and $name_count<=60) {   // по 60 символов на имя, фамилию и отчество
				$name_count=(strlen($_POST[surname]))/2;
				if ($name_count>1 and $name_count<=60) {
					$name_count=(strlen($_POST[lastname]))/2;
					if ($name_count==0 xor ($name_count>=2 and $name_count<=60)){
						if ($_POST[phone][0]==8) {
							$name_count=strlen($_POST[phone]);
							if ($name_count==11) {
								$query = "SELECT * FROM Users WHERE ((`Phone_Number_User`='$_POST[phone]') AND (`ID_User`<>'$_SESSION[id_user]'))";
								$res = mysqli_query($link, $query) or die(mysqli_error($link));
						 		$num = mysqli_num_rows($res);
						  		if($num == 0) {   //*проверка есть ли такой номер телефона*
						  			$query = "SELECT * FROM Users WHERE ((`Login`='$_POST[login]') AND (`ID_User`<>'$_SESSION[id_user]'))";
									$res = mysqli_query($link, $query) or die(mysqli_error($link));
							 		$num = mysqli_num_rows($res);
							 		$login_count=strlen($_POST[login]);  //strlen - длина строки
									if ($login_count>=4){
										if ($login_count<=20){
							 				if($num == 0) { //проверка, занят ли логин
							 					$pass_count=strlen($_POST[password]); 
												if ($pass_count>=6){
													if ($pass_count<=20){
														$_POST[password]=md5($_POST[password]);
														$query ="UPDATE `Users` SET  `Phone_Number_User`='$_POST[phone]', `Username`='$_POST[surname]"." "."$_POST[name]"." "."$_POST[lastname]' WHERE `ID_User`='$_SESSION[id_user]'"; //"" - в них sql-запрос; '' - все остальное
														$res = mysqli_query($link, $query) or die(mysqli_error($link));//отправка в БД	
														$message='<p class="success"> Изменения успешно внесены.</p>';
														$name[0]=$_POST[surname];
														$name[1]=$_POST[name];
														$name[2]=$_POST[lastname];
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
												$message='<p class="error">Этот логин уже занят.</p>';
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
									$message='<p class="error">Этот номер телефона уже занят.</p>';
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
		if (isset($_POST[del_acc_submit])) {
			$query="UPDATE `Orders` SET `ID_User`=(SELECT `ID_User` FROM `Users` WHERE `Username`='УДАЛЁННЫЙ ПОЛЬЗОВАТЕЛЬ') WHERE (`ID_User`='$_SESSION[id_user]')"; //"" - в них sql-запрос; '' - все остальное 
			$res=mysqli_query($link, $query) or die(mysqli_error($link));//отправка в БД
			$query="UPDATE `Basket` SET `ID_User`=(SELECT `ID_User` FROM `Users` WHERE `Username`='УДАЛЁННЫЙ ПОЛЬЗОВАТЕЛЬ') WHERE `ID_User`='$_SESSION[id_user]'"; //"" - в них sql-запрос; '' - все остальное 
			$res=mysqli_query($link, $query) or die(mysqli_error($link));//отправка в БД
			$query="UPDATE `Orders` SET `ID_Personnel`=(SELECT `ID_Personnel` FROM Personnel WHERE `FIO`='УДАЛЕННЫЙ ПЕРСОНАЛ') WHERE (`ID_Personnel`='$_SESSION[id_user]')";
			$res=mysqli_query($link, $query) or die(mysqli_error($link));
			$query="DELETE FROM `Personnel` WHERE (`ID_Personnel`='$_SESSION[id_user]')";
			$res=mysqli_query($link, $query) or die(mysqli_error($link));
			$query="DELETE FROM `Users` WHERE `ID_User`='$_SESSION[id_user]'"; //"" - в них sql-запрос; '' - все остальное
			$res=mysqli_query($link, $query) or die(mysqli_error($link));//отправка в БД	
			$message='<p class="success"> Аккаунт успешно удален.</p>';
			$_SESSION[employee]=false;
			$_SESSION[auth]=false;
			echo '<meta http-equiv=Refresh content="1; index.php">';
		}
		if (isset($_POST[goto_index])) {
			echo '<meta http-equiv=Refresh content="0; index.php">';
		}
		if (isset($_POST[del_rows])) {
			//очистка заказов, которым больше месяца (таблица Orders)
			$today=date("Y-m-d", strtotime("-1 month"));
			$query="DELETE FROM `Orders` WHERE (`Date_Order`<'$today')";
			$res=mysqli_query($link, $query) or die(mysqli_error($link));
			//очистка заказов с удалёнными пользователями
			$query="DELETE FROM `Orders` WHERE (`ID_User`=(SELECT `ID_User` FROM `Users` WHERE `Username`='УДАЛЁННЫЙ ПОЛЬЗОВАТЕЛЬ'))";
			$res=mysqli_query($link, $query) or die(mysqli_error($link));
			//очистка корзины удаленных пользователей (и, соответственно, удаленной корзины после заказов)
			$query="DELETE FROM `Basket` WHERE ((`ID_Basket` NOT IN (SELECT `ID_Basket` FROM `Orders`)) AND ((`ID_User`=(SELECT `ID_User` FROM `Users` WHERE `Username`='УДАЛЁННЫЙ ПОЛЬЗОВАТЕЛЬ ')) OR (`ID_Book`=(SELECT `ID_Book` FROM `Books` WHERE `Name_Book`='УДАЛЁННАЯ КНИГА'))))";
			$res=mysqli_query($link, $query) or die(mysqli_error($link));
		}
	?>
	<section>
		<div class="center">
			<div class="container">
				<form method="POST" class="w100 echoclass">
					<?php if ($_SESSION[employee]==true) { ?>
						<input class="button_reg cto-to" type="submit" name="del_rows" value="Очистить ненужные файлы в БД">
					<?php } ?>
					<div class="w100 echoclass">
						<div class="column">
							<h1> Фамилия: </h1>
							<div class="align_center">
								<input class="acc" type="text" name="surname" placeholder="Ваша фамилия" autocomplete="off" value="<?php echo $name[0] ?>">
							</div>
						</div>
						<div class="column">
							<h1> Имя: </h1>
							<div class="align_center">
								<input class="acc" type="text" name="name" placeholder="Ваше имя" autocomplete="off" value="<?php echo $name[1] ?>">
							</div>
						</div>
						<div class="column">
							<h1> Отчество: </h1>
							<div class="align_center">
								<input class="acc" type="text" name="lastname" placeholder="Ваше отчество" autocomplete="off" value="<?php echo $name[2] ?>">
							</div>
							</div>
							<span class="liliput">*необязательное поле</span>
						<div class="column">
							<h1> Номер телефона: </h1>
							<div class="align_center">
								<input class="acc" type="text" name="phone" placeholder="Ваш номер" type="tel" pattern="8[0-9]{10}" name="phone" autocomplete="off" value="<?php echo $row[Phone_Number_User]; ?>">
							</div>
						</div>
						<div class="column">
							<h1> Логин: </h1>
							<div class="align_center">
								<input class="acc" type="text" name="login" placeholder="Логин" autocomplete="off" value="<?php echo $row[Login]; ?>">
							</div>
						</div>
						<div class="column">
							<h1> Пароль: </h1>
							<div class="align_center">
								<input class="acc" type="password" name="password" placeholder="Пароль" autocomplete="off" value="">
						</div>
					</div>
					<div>
						<input class="button_reg cto-to" type="submit" name="submit" value="Внести изменения">
						<input class="button_reg cto-to" type="button" value="Выйти из аккаунта" onclick='location.href="logout.php"'>
						<input class="button_reg cto-to edit_but_r" type="submit" name="del_acc_submit" value="Удалить аккаунт">
						<input type="submit" name="goto_index" class="button_reg cto-to edit_but" value="Вернуться на главную">
					</div>
					<?php echo $message;?>
				</form>
			</div>
		</div>
	</section>
</body>
</html>
</body>
</html>



