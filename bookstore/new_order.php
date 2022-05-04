<?php 
	require("connection.php");
?>
<?php 
	if ($_SESSION[auth]!=true) {
		echo '<meta http-equiv=Refresh content="0; index.php">'; 
	}
	$today=date('Y-m-d');
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="/image/index.svg" type="image/x-icon"> <!-- иконка сайта во вкладке-->
	<link rel="preconnect" href="https://fonts.gstatic.com"> <!-- подключение шрифта -->
	<link href="https://fonts.googleapis.com/css2?family=Pangolin&display=swap" rel="stylesheet"> <!-- подключение шрифта -->
	<link rel="stylesheet" type="text/css" href="css/style.css"> <!-- подключение css -->
	<title> BookStore "TayaBook" оформление заказ </title>
</head>
<body>
	<header class="header" style="justify-content: center;">
		<div style="display: flex; justify-content: center; text-align: center;">
			<h1 class="title_index"> Оформление заказа </h1>
		</div>
	</header>
	<section>
		<form method="POST" style="font-size: 20px; width:100%; margin-top: 30px; display: flex; justify-content: center; align-items: center; flex-direction: column;">
			<strong>Дата заказа: <?php echo $today?></strong>
			<ol>
				<?php
					$i=0;
					while ($i<count($_SESSION['idorders'])) {
						echo '<li>';
						$idbook=$_SESSION['idorders'][$i];
						$query="SELECT * FROM `Books` WHERE (`ID_Book`='$idbook')";
						$res=mysqli_query($link, $query) or die(mysqli_error($link));
						$row=mysqli_fetch_assoc($res);
						echo '<div><strong>Наименование: </strong>'.$row[Name_Book].' - '.$row[Author].' - '.$row[Price].' ₽</div>';
						echo '<strong>Кол-во: </strong><input type="text" name="quantity'.$idbook.'" value="'.$_POST[quantity.$idbook].'" autocomplete="off">';
						$i++;
						echo '</li>';
					}
				?>
			</ol>
			<div style="display: flex;">
				<strong>Адрес доставки: </strong>
				<select class="acc" name="select_idshop" style="display: flex; justify-content: flex-start; width: 370px; font-size: 20px;">
					<?php
						$query="SELECT * FROM `Shops`";
						$res=mysqli_query($link, $query) or die(mysqli_error($link));
						for ($shop=[]; $row=mysqli_fetch_assoc($res); $shop[]=$row);
						?> <option value="null">Выберите магазин</option>  <?php
						foreach ($shop as $value) { 
							if ($value[Address]!='СКЛАД') {
								if (isset($_POST[order_cheque]) AND $_POST[select_idshop]!='null' AND $value[ID_Shop]==$_POST[select_idshop]) {
									echo '<option value="'.$_POST[select_idshop].'" selected ">'.$value[Address].'</option>';
								}
								else {
									echo '<option value="'.$value[ID_Shop].'">'.$value[Address].'</option>';
								}
							}
						}
					?>
				</select>
			</div>
			<div>
				<input type="submit" name="order_cheque" value="Оформить заказ" class="button_reg cto-to">
				<input type="button" value="Назад" class="button_reg cto-to edit_but_r" onClick='location.href="make_order.php"'>
			</div>
		</form>
		<?php 
			if (isset($_POST[order_cheque])) {
				$i=0;
				$error=false;
				while ($i<count($_SESSION['idorders'])) {
					$idbook=$_SESSION['idorders'][$i];
					if (!empty($_POST[quantity.$idbook]) AND $_POST[quantity.$idbook]!='0') {
						$quantityb[$idbook]=$_POST[quantity.$idbook];
						$query="SELECT `Quantity`, `Name_Book` FROM `Books` WHERE (`ID_Book`='$idbook')";
						$res=mysqli_query($link, $query) or die(mysqli_error($link));
						$q=mysqli_fetch_assoc($res);
						if ($quantityb[$idbook]>$q[Quantity]) {
							$error=true;
							$message='На складе есть всего '.$q[Quantity].' книг(а) "'.$q[Name_Book].'"';
						}
					}
					else {
						$error=true;
						$message='Укажите кол-во книг.';
					}
					$i++;
				}
				if ($error==false) {
					if ($_POST[select_idshop]!='null') {
						$_SESSION[id_shop_order]=$_POST[select_idshop];
						$query="SELECT * FROM `Orders` WHERE (`ID_Order`=(SELECT MAX(`ID_Order`) FROM `Orders`))";
						$res=mysqli_query($link, $query) or die(mysqli_error($link));
						$num=mysqli_fetch_assoc($res);
						$num[ID_Order]++;
						$_SESSION[cheque_idorder]=$num[ID_Order];
						$i=0;
						while ($i<count($_SESSION['idorders'])) {
							$idbook=$_SESSION['idorders'][$i];
							$query="SELECT `ID_Basket` FROM `Basket` WHERE (`ID_Book`='$idbook' AND `ID_User`='$_SESSION[id_user]')";
							$res=mysqli_query($link, $query) or die(mysqli_error($link));
							$idbasket=mysqli_fetch_assoc($res);
							$query="SELECT `ID_Personnel` FROM `Personnel` WHERE (`FIO`='УДАЛЕННЫЙ ПЕРСОНАЛ')";
							$res=mysqli_query($link, $query) or die(mysqli_error($link));
							$idpers=mysqli_fetch_assoc($res);
							$query="INSERT INTO `Orders` (`ID_Basket`, `ID_Order`, `ID_User`, `ID_Shop`, `Date_Order`, `Status`, `ID_Personnel`, `Quantity`) VALUES ('$idbasket[ID_Basket]', '$num[ID_Order]', '$_SESSION[id_user]', '$_POST[select_idshop]', '$today', 'Не выполнен', '$idpers[ID_Personnel]', '$quantityb[$idbook]')";
							$res=mysqli_query($link, $query) or die(mysqli_error($link));
							$query="UPDATE `Basket` SET `ID_User`=(SELECT `ID_User` FROM `Users` WHERE (`Username`='УДАЛЁННЫЙ ПОЛЬЗОВАТЕЛЬ')) WHERE (`ID_Basket`='$idbasket[ID_Basket]')";
							$res=mysqli_query($link, $query) or die(mysqli_error($link));
							$query="SELECT `Quantity` FROM `Books` WHERE (`ID_Book`='$idbook')";
							$res=mysqli_query($link, $query) or die(mysqli_error($link));
							$q=mysqli_fetch_assoc($res);
							$q[Quantity]=$q[Quantity]-$quantityb[$idbook];
							$query="UPDATE `Books` SET `Quantity`='$q[Quantity]' WHERE (`ID_Book`='$idbook')";
							$res=mysqli_query($link, $query) or die(mysqli_error($link));
							$i++;
						}
						echo '<meta http-equiv=Refresh content="0; cheque.php">';
					}
					else {
						$error=true;
						echo '<p class="error">Укажите адрес доставки.</p>';
					}
				}
				else {
					echo '<p class="error">'.$message.'</p>';
				}
			}
		?>
	</section>
</body>
</html>


