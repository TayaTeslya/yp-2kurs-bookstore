<?php 
	require("connection.php");
?>
<?php  
	$query="SELECT * FROM `Shops` WHERE `ID_Shop`='$_SESSION[id_shop]'"; //отправка запроса на выборку магазинов из БД
	$res=mysqli_query($link, $query) or die(mysqli_error($link));
	$row=mysqli_fetch_assoc($res);	
?>
<?php 
	if ($_SESSION[employee]!=true) {
		echo '<meta http-equiv=Refresh content="0; index.php">'; 
	}
	if (isset($_POST[edit_shop])) {
		if (!empty($_POST[phone]) and !empty($_POST[address])) {
			$query="UPDATE `Shops` SET `Phone_Number`='$_POST[phone]', `Address`='$_POST[address]' WHERE (`ID_Shop`='$_SESSION[id_shop]')"; //отправка запроса на выборку магазинов из БД
			$res=mysqli_query($link, $query) or die(mysqli_error($link));
			$message="Изменения успешно внесены.";
			$error=false;
		}
		else {
			$message="Все поля должны быть заполнены.";
			$error=true;
		}
	}
	else {
		$_POST[address]=$row[Address];
		$_POST[phone]=$row[Phone_Number];
	}
	if (isset($_POST[del_shop])) { //УДАЛЁННАЯ КНИГА
		$query="UPDATE `Orders` SET `ID_Shop`=(SELECT `ID_Shop` FROM `Shops` WHERE `Address`='СКЛАД') WHERE `ID_Shop`='$_SESSION[id_shop]'"; //отправка запроса на выборку магазинов из БД
		$res=mysqli_query($link, $query) or die(mysqli_error($link));
		$query="UPDATE `Personnel` SET `ID_Shop`=(SELECT `ID_Shop` FROM `Shops` WHERE `Address`='СКЛАД') WHERE Personnel.`ID_Shop`='$_SESSION[id_shop]'"; //отправка запроса на выборку магазинов из БД
		$res=mysqli_query($link, $query) or die(mysqli_error($link));
		$query="DELETE FROM `Shops` WHERE `ID_Shop`=$_SESSION[id_shop]"; //отправка запроса на выборку магазинов из БД
		$res=mysqli_query($link, $query) or die(mysqli_error($link));	
		$message="Магазин успешно удалён.";
		$error=false;	
		echo '<meta http-equiv=Refresh content="1; shops.php">';		
	}
	if (isset($_POST[not_edit_shop])) {
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
	<title> BookStore "TayaBook" редактировать магазин </title>
</head>
<body>
	<header class="header" style="justify-content: center;">
		<div style="display: flex; justify-content: center; text-align: center;">
			<h1 class="title_index"> Редактировать магазин </h1>
		</div>
	</header>
	<section>
		<div class="center">
			<div class="container">
				<div class="w100">
					<form method="POST">	
						<div style="display: flex; justify-content: center; margin-top:100px; font-size:30px;">
							<div style="display: flex; flex-direction: column; margin-right:15px;">
								<strong>Адрес: </strong>
								<input type="text" name="address" autocomplete="off" value="<?php echo $_POST[address] ?>" class="acc">
							</div>
							<div style="display: flex; flex-direction: column; margin-left:15px;">		
								<strong>Номер телефона: </strong>
								<input type="tel" pattern="8[0-9]{10}" autocomplete="off" name="phone" value="<?php echo $_POST[phone] ?>" class="acc">
							</div>
						</div>	
						<div style="display: flex; justify-content: center;">
							<input type="submit" name="edit_shop" value="Внести изменения" class="button_reg cto-to">
							<input type="submit" name="del_shop" value="Удалить магазин" class="button_reg cto-to edit_but_r">
							<input type="submit" name="not_edit_shop" value="Отмена" class="button_reg cto-to edit_but_r">
						</div>	
					</form>
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




