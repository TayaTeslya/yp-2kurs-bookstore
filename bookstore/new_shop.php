<?php 
	require("connection.php");
?>
<?php 
	if ($_SESSION[employee]!=true) {
		echo '<meta http-equiv=Refresh content="0; index.php">'; 
	}
	if (isset($_POST[new_shop])) {
		if (!empty($_POST[address]) and !empty($_POST[phone])) {
			$query="SELECT * FROM `Shops` WHERE (`Address`='$_POST[address]')"; //отправка запроса на выборку книг из БД
			$res=mysqli_query($link, $query) or die(mysqli_error($link));
			$num=mysqli_num_rows($res);
			if ($num==0) {
				$query="SELECT * FROM `Shops` WHERE (`Phone_Number`='$_POST[phone]')"; //отправка запроса на выборку книг из БД
				$res=mysqli_query($link, $query) or die(mysqli_error($link));
				$num=mysqli_num_rows($res);
				if ($num==0) {
					$error=false;
					$message="Магазин успешно добавлен.";
					$query="INSERT INTO `Shops` (`Address`, `Phone_Number`) VALUES ('$_POST[address]', '$_POST[phone]')"; //отправка запроса на выборку книг из БД
					$res=mysqli_query($link, $query) or die(mysqli_error($link));
					$row=mysqli_fetch_assoc($res);//row-из переменной res все данные в массив; book - создали ПУСТОЙ массив; book2 из массива row в массив book
					echo '<meta http-equiv=Refresh content="1; shops.php">';
				}
				else {
					$error=true;
					$message="Этот номер телефона принадлежит другому магазину.";
				}
			}
			else {
				$error=true;
				$message="Данный адрес уже есть.";
			}
		}
		else {
			$error=true;
			$message="Заполните все поля.";
		}
	}
	if (isset($_POST[not_new_shop])) {
		echo '<meta http-equiv=Refresh content="0; shops.php">';
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="/image/index.svg" type="image/x-icon"> <!-- иконка сайта во вкладке-->
	<link rel="preconnect" href="https://fonts.gstatic.com"> <!-- подключение шрифта -->
	<link href="https://fonts.googleapis.com/css2?family=Pangolin&display=swap" rel="stylesheet"> <!-- подключение шрифта -->
	<link rel="stylesheet" type="text/css" href="css/style.css"> <!-- подключение css -->
	<title> BookStore "TayaBook" добавить магазин </title>
</head>
<body>
	<header class="header" style="justify-content: center;">
		<div style="display: flex; justify-content: center; text-align: center;">
			<h1 class="title_index"> Добавить магазин </h1>
		</div>
	</header>
	<section>
		<div class="center">
			<div class="container">
				<div class="w100">
					<br>
					<div style="display: flex; margin-left:370px; justify-content: column; margin-top:100px; font-size:30px;">
						<form method="POST">
							<div>
								<strong>Адрес: </strong>
								<input style="margin-left: 235px;" type="text" name="address" placeholder="Адрес магазина" value="<?php echo $_POST[address] ?>" autocomplete="off" class="button_reg cto-to edit_but">
							</div>
							<div>
								<strong>Номер телефона: </strong>
								<input type="tel" name="phone" pattern="8[0-9]{10}" placeholder="Номер телефона" value="<?php echo $_POST[phone] ?>" autocomplete="off" class="button_reg cto-to edit_but">
							</div>
							<div style="margin-left: 100px;">
								<input type="submit" name="new_shop" value="Добавить магазин" class="button_reg cto-to">
								<input type="submit" name="not_new_shop" value="Отмена" class="button_reg cto-to edit_but_r">
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
</body>
</html>



