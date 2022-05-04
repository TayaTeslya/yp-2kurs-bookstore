<?php 
	require("connection.php");
?>
<?php
	if ($_SESSION[employee]!=true) {
		echo '<meta http-equiv=Refresh content="0; index.php">'; 
	} 
	if (isset($_POST[new_supplier])) {
		if (!empty($_POST[organization]) and !empty($_POST[address]) and !empty($_POST[phone])) {
			$query="SELECT * FROM `Suppliers` WHERE (`Organization`='$_POST[organization]')"; //отправка запроса на выборку книг из БД
			$res=mysqli_query($link, $query) or die(mysqli_error($link));
			$num=mysqli_num_rows($res);
			if ($num==0) {
				$error=false;
				$message="Поставщик успешно добавлен.";
				$query="INSERT INTO `Suppliers` (`Organization`, `Address`, `Phone_Number`) VALUES ('$_POST[organization]', '$_POST[address]', '$_POST[phone]')"; //отправка запроса на выборку книг из БД
				$res=mysqli_query($link, $query) or die(mysqli_error($link));
				echo '<meta http-equiv=Refresh content="1; suppliers.php">';
			}
			else {
				$error=true;
				$message="Такая организация уже есть.";
			}
		}
		else {
			$error=true;
			$message="Заполните все поля.";
		}
	}
	if (isset($_POST[not_new_supplier])) {
		echo '<meta http-equiv=Refresh content="0; suppliers.php">';
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="/image/index.svg" type="image/x-icon"> <!-- иконка сайта во вкладке-->
	<link rel="preconnect" href="https://fonts.gstatic.com"> <!-- подключение шрифта -->
	<link href="https://fonts.googleapis.com/css2?family=Pangolin&display=swap" rel="stylesheet"> <!-- подключение шрифта -->
	<link rel="stylesheet" type="text/css" href="css/style.css"> <!-- подключение css -->
	<title> BookStore "TayaBook" добавить поставщика </title>
</head>
<body>
	<header class="header" style="justify-content: center;">
		<div style="display: flex; justify-content: center; text-align: center;">
			<h1 class="title_index"> Добавить поставщика </h1>
		</div>
	</header>
	<section>
		<br>
		<div class="center">
			<div class="container"> <!-- контейнер с книгой  -->
				<div class="w100">
					<br>
					<div style="display: flex; margin-left:320px; justify-content: column; margin-top:100px; font-size:30px;">
						<form method="POST">
							<div>
								<strong>Название организации: </strong>
								<input type="text" name="organization" placeholder="Название организации" value="<?php echo $_POST[organization] ?>" autocomplete="off" class="button_reg cto-to edit_but">
							</div>
							<div>
							<div>
								<strong>Адрес: </strong>
								<input style="margin-left: 302px;" type="text" name="address" placeholder="Адрес поставщика" value="<?php echo $_POST[address] ?>" autocomplete="off" class="button_reg cto-to edit_but">
							</div>
								<strong>Номер телефона: </strong>
								<input style="margin-left: 168px;" type="tel"name="phone" pattern="8[0-9]{10}" placeholder="Номер телефона" value="<?php echo $_POST[phone] ?>" autocomplete="off" class="button_reg cto-to edit_but">
							</div>
							<div style="margin-left: 100px;">
								<input type="submit" name="new_supplier" value="Добавить поставщика" class="button_reg cto-to">
								<input type="submit" name="not_new_supplier" value="Отмена" class="button_reg cto-to edit_but_r">
							</div>
						</form>
					</div>
					<div style="margin-right: 100px;"> 
						<?php if ($error==false) { ?>
							<p class="success"><?php echo $message; ?></p>
						<?php }
						else { ?>
							<p class="error" ><?php echo $message; ?></p>
						<?php } ?>
					</div> 	
				</div>	
			</div>
		</div>
	</section>
</body>
</html>


