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
	<title> BookStore "TayaBook" редактировать сотрудника </title>
</head>
<body>
	<header class="header" style="justify-content: center;">
		<div style="display: flex; justify-content: center; text-align: center;">
			<h1 class="title_index"> Редактировать сотрудника </h1>
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
							if (isset($_POST[edit_personnel])) {
								$query="SELECT * FROM `Users`, `Personnel` WHERE (`ID_User`='$_SESSION[id_personnel]' AND `ID_Personnel`='$_SESSION[id_personnel]')";
								$res=mysqli_query($link, $query) or die(mysqli_error($link));
								$row=mysqli_fetch_assoc($res);
								$row[Passport]=$_POST[passport];
								$row[Date_Birth]=$_POST[date_birth];
								$row[Passport_Date_Issue]=$_POST[date];
								$row[Passport_Place_Issue]=$_POST[place];
								$row[Post]=$_POST[post];
								$row[Salary]=$_POST[salary];
								$row[ID_Shop]=$_POST[option_idshop];
								$id_selected_shop=$_POST[option_idshop];
								if (!empty($_POST[passport]) AND !empty($_POST[date]) AND !empty($_POST[place]) AND !empty($_POST[date_birth]) AND !empty($_POST[post]) AND !empty($_POST[salary])) {
									$str=strlen($_POST[passport]);
									if ($str==10) {
										$today=date('Y-m-d');
									 	$howyears=$today-$_POST[date_birth];
										if ($howyears>=18) {
											$pas_birth=$_POST[date]-$_POST[date_birth];
											if ($pas_birth==14 OR $pas_birth==20 OR $pas_birth==45) {
												$query="SELECT * FROM `Personnel` WHERE (`Passport`='$_POST[passport]' AND `ID_Personnel`!='$_SESSION[id_personnel]')";
												$res=mysqli_query($link, $query) or die(mysqli_error($link));
												$num=mysqli_fetch_assoc($res);
												if ($num==0) {
													$error=false;
													$message='Изменения успешно внесены.';
													$query="UPDATE `Personnel` SET `Passport`='$_POST[passport]', `Passport_Date_Issue`='$_POST[date]', `Passport_Place_Issue`='$_POST[place]', `Date_Birth`='$_POST[date_birth]', `Salary`='$_POST[salary]', `Post`='$_POST[post]', `ID_Shop`='$_POST[option_idshop]' WHERE (`ID_Personnel`='$_SESSION[id_personnel]')";
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
									$message='Заполните все поля.';
								}
							}
							else {
								$query="SELECT * FROM `Users`, `Personnel` WHERE (`ID_User`='$_SESSION[id_personnel]' AND `ID_Personnel`='$_SESSION[id_personnel]')";
								$res=mysqli_query($link, $query) or die(mysqli_error($link));
								$row=mysqli_fetch_assoc($res);
								$id_selected_shop=$row[ID_Shop];
							}
							if ($_POST[del_personnel]) {
								$error=false;
								$message='Сотрудник успешно удалён.';
								$query="UPDATE `Orders` SET `ID_Personnel`=(SELECT `ID_Personnel` FROM Personnel WHERE `FIO`='АДМИНИСТРАТОР') WHERE (`ID_Personnel`='$_SESSION[id_personnel]')";
								$res=mysqli_query($link, $query) or die(mysqli_error($link));
								$query="DELETE FROM `Personnel` WHERE (`ID_Personnel`='$_SESSION[id_personnel]')";
								$res=mysqli_query($link, $query) or die(mysqli_error($link));
								echo '<meta http-equiv=Refresh content="1; personnel.php">';
							}
							?>
							<div style="display: flex; justify-content: space-between; margin-bottom: 10px; width: 100%">
								<div>
									<strong> ID_User: </strong>
								</div>
								<div>
									<div>
										<div class="acc" name="user_information">
											<?php
												if ($row[Username]!='УДАЛЁННЫЙ ПОЛЬЗОВАТЕЛЬ') {
													echo '<span>'.$row[Username].' - '.$row[Phone_Number_User].'</span>';
												}
											?>
										</div>
									</div>
								</div>
							</div>
							<div style="display: flex; justify-content: space-between; margin-bottom: 10px; width: 88%">
								<div>
									<strong> Дата рождения: </strong>
								</div>
								<div>
									<input name="date_birth" type="date" autocomplete="off" placeholder="Пароль" value="<?php echo $row[Date_Birth] ?>" class="acc"> 
								</div>
							</div>
							<div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
								<div>
									<strong> Серия и номер паспорта: </strong>
								</div>
								<div>
									<input name="passport" pattern="[0-9]{10}" maxlength="10" type="text" autocomplete="off" placeholder="Серия и номер паспорта" value="<?php echo $row[Passport] ?>" class="acc"> 
								</div>
							</div>
							<div style="display: flex; justify-content: space-between; margin-bottom: 10px; width: 88%">
								<div>
									<strong> Дата выдачи паспорта: </strong>
								</div>
								<div>
									<input name="date" type="date" autocomplete="off" placeholder="Дата выдачи" value="<?php echo $row[Passport_Date_Issue]; ?>" class="acc"> 
								</div>
							</div>
							<div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
								<div>
									<strong> Место выдачи паспорта: </strong>
								</div>
								<div>
									<input name="place" type="text" autocomplete="off" placeholder="Место выдачи" value="<?php echo $row[Passport_Place_Issue]; ?>" class="acc"> 
								</div>
							</div>
							<div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
								<div>
									<strong> Должность: </strong>
								</div>
								<div>
									<input name="post" type="text" autocomplete="off" placeholder="Должность" class="acc" value="<?php echo $row[Post]; ?>"> 
								</div>
							</div>
							<div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
								<div>
									<strong> Заработная плата: </strong>
								</div>
								<div>
									<input name="salary" type="text" autocomplete="off" pattern="[0-9]{5,}" placeholder="Заработная плата" class="acc" value="<?php echo $_POST[salary]=$row[Salary]; ?>"> 
								</div>
							</div>
							<div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
								<div>
									<strong> Адрес магазина: </strong>
								</div>
								<div style="display: flex; justify-content: flex-start; width: 370px">
									<select class="acc" name="option_idshop" style="display: flex; justify-content: flex-start; width: 370px;">
										<?php
										$query="SELECT * FROM `Shops`";
										$res=mysqli_query($link, $query) or die(mysqli_error($link));
										for ($shop=[]; $row=mysqli_fetch_assoc($res); $shop[]=$row);
											foreach ($shop as $value) { 
												if ($value[Address]!='СКЛАД') {
													if ($value[ID_Shop]==$id_selected_shop) {
														echo '<option value="'.$value[ID_Shop].'" selected>'.$value[Address].'</option>';
													}
													else {
														echo '<option value="'.$value[ID_Shop].'">'.$value[Address].'</option>';
													}
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
								<input type="submit" name="edit_personnel" style="margin: 0; margin-right: 100px;" class="button_reg cto-to edit_but edit_but" value="Внести изменения">
								<input type="submit" name="del_personnel" style="margin: 0; margin-right: 100px;" class="button_reg cto-to edit_but edit_but_r" value="Удалить сотрудника">
								<input type="button" name="not_edit_personnel" style="margin: 0;" class="button_reg cto-to edit_but edit_but_r" value="Отмена" onClick='location.href="personnel.php"'>
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


