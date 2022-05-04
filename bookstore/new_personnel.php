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
	<title> BookStore "TayaBook" добавить сотрудника </title>
</head>
<body>
	<header class="header" style="justify-content: center;">
		<div style="display: flex; justify-content: center; text-align: center;">
			<h1 class="title_index"> Добавить сотрудника </h1>
		</div>
	</header>
	<section>
		<div class="center">
			<div class="container"> <!-- контейнер с книгой  -->
				<div class="w100">
					<br>
					<div style="display: flex; width: 1320px; font-size: 30px; justify-content: center; align-items: center;">
						<form method="POST" style="width: 60%;">
							<?php  
							if (isset($_POST[new_personnel])) {
								$query="SELECT * FROM `Users` WHERE (`ID_User`='$_POST[option_user]')";
								$res=mysqli_query($link, $query) or die(mysqli_error($link));
								$row=mysqli_fetch_assoc($res);
								if (!empty($_POST[passport]) AND !empty($_POST[date]) AND !empty($_POST[place]) AND !empty($_POST[date_birth]) AND !empty($_POST[post]) AND !empty($_POST[salary])) {
									$query="SELECT * FROM `Personnel` WHERE (`ID_Personnel`='$_POST[option_user]')";
									$res=mysqli_query($link, $query) or die(mysqli_error($link));
									$num=mysqli_fetch_assoc($res);
									if ($num==0) {
										$str=strlen($_POST[passport]);
										if ($str==10) {
											$today=date('Y-m-d');
											$howyears=$today-$_POST[date_birth];
											if ($howyears>=18) {
												$pas_birth=$_POST[date]-$_POST[date_birth];
												if ($pas_birth==14 OR $pas_birth==20 OR $pas_birth==45) {
													$query="SELECT * FROM `Personnel` WHERE (`Passport`='$_POST[passport]')";
													$res=mysqli_query($link, $query) or die(mysqli_error($link));
													$num=mysqli_fetch_assoc($res);
													if ($num==0) {
														$error=false;
														$message='Сотрудник успешно добавлен.';
														$query="INSERT INTO `Personnel`(`ID_Personnel`, `FIO`, `Passport`, `Passport_Date_Issue`, `Passport_Place_Issue`, `Date_Birth`, `Phone_Number`, `Salary`, `Post`, `ID_Shop`) VALUES ('$_POST[option_user]', '$row[Username]', '$_POST[passport]', '$_POST[date]', '$_POST[place]', '$_POST[date_birth]', '$row[Phone_Number_User]', '$_POST[salary]', '$_POST[post]', '$_POST[option_shop]')";
														$res=mysqli_query($link, $query) or die(mysqli_error($link));
														echo '<meta http-equiv=Refresh content="1; personnel.php">';
													}
													else {
														$error=true;
														$message='Неверные серия и/или номер паспорта.';
													}
												}
												else {
													$error=true;
													$message='Дата рождения и дата выдачи паспорта не соответствуют требованиям.';
												}
											}
											else {
												$error=true;
												$message='На должности принимают с 18 лет.';
											}
										}
										else {
											$error=true;
											$message='Проверьте правильность серии и номера паспорта.';
										}
									} 
									else {
										$error=true;
										$message='Этот пользователь уже числится как сотрудник.';
										echo '<meta http-equiv=Refresh content="1; personnel.php">';
									}
								}
								else {
									$error=true;
									$message='Заполните все поля.';
								}
							}
							?>
							<div style="display: flex; justify-content: space-between; align-items: center;">
								<div style="margin: 0;">
									<strong> ID_User: </strong>
								</div>
								<div style="display: flex; justify-content: flex-start; align-items: center;">
									<div style="display: flex; justify-content: flex-start;">
										<select class="acc" name="option_user" style="display: flex; justify-content: flex-start;">
											<?php
											$query="SELECT * FROM `Users` WHERE (`Rank_User`='Сотрудник') ORDER BY `Username`";
											$res=mysqli_query($link, $query) or die(mysqli_error($link));
											for ($user=[]; $row=mysqli_fetch_assoc($res); $user[]=$row);
												foreach ($user as $value) { 
													if ($value[Username]!='УДАЛЁННЫЙ ПОЛЬЗОВАТЕЛЬ') {
														echo '<option value="'.$value[ID_User].'">'.$value[Username].' - '.$value[Phone_Number_User].'</option>';
													}
												}
											?>
										</select>
									</div>
								</div>
							</div>
							<div style="display: flex; justify-content: space-between; margin-bottom: 10px; width: 88%">
								<div>
									<strong> Дата рождения: </strong>
								</div>
								<div>
									<input name="date_birth" type="date" autocomplete="off" placeholder="Пароль" value="<?php echo $_POST[date_birth]; ?>" class="acc"> 
								</div>
							</div>
							<div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
								<div>
									<strong> Серия и номер паспорта: </strong>
								</div>
								<div>
									<input name="passport" pattern="[0-9]{10}" maxlength="10" type="text" autocomplete="off" placeholder="Серия и номер паспорта" value="<?php echo $_POST[passport]; ?>" class="acc"> 
								</div>
							</div>
							<div style="display: flex; justify-content: space-between; margin-bottom: 10px; width: 88%">
								<div>
									<strong> Дата выдачи паспорта: </strong>
								</div>
								<div>
									<input name="date" type="date" autocomplete="off" placeholder="Дата выдачи" value="<?php echo $_POST[date]; ?>" class="acc"> 
								</div>
							</div>
							<div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
								<div>
									<strong> Место выдачи паспорта: </strong>
								</div>
								<div>
									<input name="place" type="text" autocomplete="off" placeholder="Место выдачи" value="<?php echo $_POST[place]; ?>" class="acc"> 
								</div>
							</div>
							<div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
								<div>
									<strong> Должность: </strong>
								</div>
								<div>
									<input name="post" type="text" autocomplete="off" placeholder="Должность" class="acc" value="<?php echo $_POST[post]; ?>"> 
								</div>
							</div>
							<div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
								<div>
									<strong> Заработная плата: </strong>
								</div>
								<div>
									<input name="salary" type="text" autocomplete="off" pattern="[0-9]{5,}" placeholder="Заработная плата" class="acc" value="<?php echo $_POST[salary]; ?>"> 
								</div>
							</div>
							<div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
								<div>
									<strong> Адрес магазина: </strong>
								</div>
								<div style="display: flex; justify-content: flex-start; width: 370px">
									<select class="acc" name="option_shop" style="display: flex; justify-content: flex-start; width: 370px;">
										<?php
										$query="SELECT * FROM `Shops`";
										$res=mysqli_query($link, $query) or die(mysqli_error($link));
										for ($shop=[]; $row=mysqli_fetch_assoc($res); $shop[]=$row);
											foreach ($shop as $value) { 
												if ($value[Address]!='СКЛАД') {
													echo '<option value="'.$value[ID_Shop].'">'.$value[Address].'</option>';
												}
											}
											?>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div style="display: flex; justify-content: center; margin-left: 100px;">
							<div style="width: 700px;">
								<input type="submit" name="new_personnel" style="" class="button_reg cto-to edit_but edit_but" value="Добавить сотрудника">
								<input type="button" name="not_new_personnel" style="" class="button_reg cto-to edit_but edit_but_r" value="Отмена" onClick='location.href="personnel.php"'>
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