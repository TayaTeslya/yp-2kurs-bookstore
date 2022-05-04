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
	<title> BookStore "TayaBook" редактировать поставщика </title>
</head>
<body>
	<header class="header" style="justify-content: center;">
		<div style="display: flex; justify-content: center; text-align: center;">
			<h1 class="title_index"> Редактировать поставщика </h1>
		</div>
	</header>
	<section>
		<div class="center">
			<div class="container">
				<div class="w100">
					<?php  
						$query="SELECT * FROM `Suppliers` WHERE `ID_Supplier`='$_SESSION[id_sup]'"; //отправка запроса на выборку магазинов из БД
						$res=mysqli_query($link, $query) or die(mysqli_error($link));
						$row=mysqli_fetch_assoc($res);	
					?>
					<?php 
						if (isset($_POST[not_edit_sup])) {
							echo '<meta http-equiv=Refresh content="0; suppliers.php">';
						}
						if (isset($_POST[edit_sup])) {
							if (!empty($_POST[organization]) and !empty($_POST[address]) and !empty($_POST[phone])) {
								$query="SELECT * FROM `Suppliers` WHERE (`Organization`='$_POST[organization]' AND `ID_Supplier`!='$_SESSION[id_sup]')"; //отправка запроса на выборку магазинов из БД
								$res=mysqli_query($link, $query) or die(mysqli_error($link));
								$num=mysqli_num_rows($res);
								if ($num==0) {
									$error=false;
									$message="Изменения успешно внесены.";
									$query="UPDATE `Suppliers` SET `Organization`='$_POST[organization]', `Address`='$_POST[address]', `Phone_Number`='$_POST[phone]' WHERE `ID_Supplier`='$_SESSION[id_sup]'"; //отправка запроса на выборку магазинов из БД
									$res=mysqli_query($link, $query) or die(mysqli_error($link));
									$row=mysqli_fetch_assoc($res);	
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
						else {
							$_POST[organization]=$row[Organization];
							$_POST[address]=$row[Address];
							$_POST[phone]=$row[Phone_Number];
						}
						if (isset($_POST[del_sup])) {
							$error=false;
							$message="Поставщик успешно удалён.";
							$query="UPDATE `Books` SET `ID_Supplier`=(SELECT `ID_Supplier` FROM `Suppliers` WHERE `Organization`='УДАЛЕННЫЙ ПОСТАВЩИК') WHERE `ID_Supplier`='$_SESSION[id_sup]'";
							$res=mysqli_query($link, $query) or die(mysqli_error($link));
							$query="DELETE FROM `Suppliers` WHERE (`ID_Supplier`='$_SESSION[id_sup]')";
							$res=mysqli_query($link, $query) or die(mysqli_error($link));
							echo '<meta http-equiv=Refresh content="1; suppliers.php">';
						}
					?>
					<form method="POST">	
						<div style="display: flex; justify-content: center; margin-top:100px; font-size:30px;">
							<div style="display: flex; flex-direction: column; margin-right:15px;">
								<strong>Название организации: </strong>
								<input type="text" name="organization" autocomplete="off" value="<?php echo $_POST[organization]; ?>" class="acc">
							</div>
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
							<input type="submit" name="edit_sup" value="Внести изменения" class="button_reg cto-to">
							<input type="submit" name="del_sup" value="Удалить поставщика" class="button_reg cto-to edit_but_r">
							<input type="submit" name="not_edit_sup" value="Отмена" class="button_reg cto-to edit_but_r">
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


