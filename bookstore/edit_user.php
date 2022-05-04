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
	<title> BookStore "TayaBook" редактировать пользователя </title>
</head>
<body>
	<header class="header" style="justify-content: center;">
		<div style="display: flex; justify-content: center; text-align: center;">
			<h1 class="title_index"> Редактировать пользователя </h1>
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
						if (isset($_POST[edit_user])) {
							if ((!empty($_POST[name])) and (!empty($_POST[surname])) and (!empty($_POST[phone]))) { //*проверка на пустоту полей, всех, кроме отчества, т.к. оно необязательное*
								$name_count=(strlen($_POST[name]))/2;
								if ($name_count>1 and $name_count<=60) {   // по 60 символов на имя, фамилию и отчество
									$name_count=(strlen($_POST[surname]))/2;
									if ($name_count>1 and $name_count<=60) {
										$name_count=strlen(($_POST[lastname]))/2;
										if ($name_count==0 xor ($name_count>=2 and $name_count<=60)){																		
								  			$query = "SELECT * FROM `Users` WHERE (`Phone_Number_User`='$_POST[phone]' AND `ID_User`!='$_SESSION[user_id]')";
											$res = mysqli_query($link, $query) or die(mysqli_error($link));
									 		$num = mysqli_num_rows($res);
									 		if ($num == 0) { //проверка, занят ли номер телефона
									 			if ($_POST[rank]=='0') {
									 				$rank='Клиент';
									 			}
									 			if ($_POST[rank]=='1') {
									 				$rank='Сотрудник';
									 			}
												$query="UPDATE `Users` SET `Phone_Number_User`='$_POST[phone]', `Username`='$_POST[surname]"." "."$_POST[name]"." "."$_POST[lastname]', `Rank_User`='$rank' WHERE `ID_User`='$_SESSION[user_id]'"; //"" - в них sql-запрос; '' - все остальное
												$res = mysqli_query($link, $query) or die(mysqli_error($link));//отправка в БД	
												$error=false;
												$message='Изменения успешно внесены.';
												echo '<meta http-equiv=Refresh content="0; users.php">'; //- перенаправит через 1 секунду на страницу авторизации
											}
											else {
												$error=true;
												$message='Этот номер телефона уже занят.';
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
								$message='Пожалуйста, заполните все поля.';
							}
						}
						else {
							$_POST[surname]=$name[0];
							$_POST[name]=$name[1];
							$_POST[lastname]=$name[2];
							$_POST[phone]=$row[Phone_Number_User];
							$_POST[login]=$row[Login];
							$_POST[password]=$row[Password];
							$_POST[rank]=$row[Rank_User];
						}
						if (isset($_POST[not_edit_user])) {
							echo '<meta http-equiv=Refresh content="0; users.php">';
						}
						if (isset($_POST[new_login])) {
							echo '<meta http-equiv=Refresh content="0; edit_user_password.php">';
						}
					?>
					<div style="display: flex; width: 1320px; font-size: 30px; justify-content: center; align-items: center;">
						<form method="POST">
							<div style="margin-bottom: 10px;">
								<strong> ID: </strong><span><?php echo $_SESSION[user_id]; ?></span>
							</div>
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
							<div style="display: flex;">
								<div style="width: 40% margin: 0;">
									<strong> Ранг: </strong>
								</div>
								<div style="margin-left: 171px;">
									<select class="acc" style="" name="rank">
										<?php
											if ($_POST[rank]=='Клиент') {
									  	?> 
											<option selected value="0">Клиент</option>
											<option value="1">Сотрудник</option>
										<?php } 
										else { ?>
											<option value="0">Клиент</option>
											<option selected value="1">Сотрудник</option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<?php if ($error==false) { ?>
							<p class="success"><?php echo $message; ?></p>
						<?php }
						else { ?>
							<p class="error" ><?php echo $message; ?></p>
						<?php } ?>
					</div>
						<div style="display: flex; justify-content: center; margin-left: 100px;">
							<div style="width: 700px;">
								<input type="submit" name="edit_user" style="" class="button_reg cto-to edit_but edit_but" value="Внести изменения">
								<input type="submit" name="new_login" style="" class="button_reg cto-to edit_but edit_but" value="Логин/пароль">
								<input type="submit" name="not_edit_user" style="" class="button_reg cto-to edit_but edit_but_r" value="Отмена">
							</div>
						</div>
				</form>	
			</div>
		</div>
	</section>
</body>
</html>


