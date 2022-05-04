<?php 
	require("connection.php");
?>
<?php 
	if ($_SESSION[auth]!=true) {
		echo '<meta http-equiv=Refresh content="0; index.php">'; 
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="/image/index.svg" type="image/x-icon"> <!-- иконка сайта во вкладке-->
	<link rel="preconnect" href="https://fonts.gstatic.com"> <!-- подключение шрифта -->
	<link href="https://fonts.googleapis.com/css2?family=Pangolin&display=swap" rel="stylesheet"> <!-- подключение шрифта -->
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@300&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/style.css"> <!-- подключение css -->
	<title> BookStore "TayaBook" чек </title>
</head>
<body>
	<section>
		<?php 
			$query="SELECT `Orders`.`ID_Order`, `Address` FROM `Orders`, `Basket`, `Shops` WHERE (`Orders`.`ID_Basket`=`Basket`.`ID_Basket` AND `ID_Order`='$_SESSION[cheque_idorder]' AND `Orders`.`ID_Shop`=`Shops`.`ID_Shop`)";
			$res=mysqli_query($link, $query) or die(mysqli_error($link));
			$row=mysqli_fetch_assoc($res);
		?>
		<div style="display: flex; flex-direction: column; width: 100%; height: 100%; align-items: center; justify-content: center; font-size: 20px;">
			<div style="width: 400px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
				<div style="text-align: center;">
					<strong class="font-cheque">ООО Малооптовый книжный интернет-магазин "TayaBook"</strong>
				</div>
				<div>
					<span class="font-cheque">:::::::::::::::::::::::::::::::::</span>
				</div>
				<div style="text-align: left; width: 400px;">
					<span class="font-cheque">Сайт: teslya-tip41.ru</span>
				</div>
				<div style="text-align: left; width: 400px;">
					<span class="font-cheque">Адрес: <?php echo $row[Address] ?></span>
				</div>
				<div style="text-align: left; width: 400px;">
					<?php  
						$today=date("m.d.y");
						$time=date("H:i:s");
					?>
					<span class="font-cheque">Дата: <?php echo $today.' '.$time ?></span>
				</div>
				<div>
					<span class="font-cheque">:::::::::::::::::::::::::::::::::</span>
				</div>
				<div>
					<strong class="font-cheque">Товарный чек заказа №<?php echo $row[ID_Order]; ?> </strong>
				</div>
				<div>
					<span class="font-cheque">:::::::::::::::::::::::::::::::::</span>
				</div>
				<div style="display: flex; text-align: left;">
					<ol>
						<?php 
							$i=0;
							$cost=0;
							while ($i<count($_SESSION['idorders'])) {
								echo '<div>';
								$idbook=$_SESSION['idorders'][$i];
								$query="SELECT `ID_Order`, `Orders`.`ID_User`, `Books`.`ID_Book`, `Name_Book`, `Orders`.`Quantity`, `Price`, `Author` FROM `Orders`, `Basket`, `Books` WHERE (`Orders`.`ID_Basket`=`Basket`.`ID_Basket` AND `ID_Order`='$_SESSION[cheque_idorder]' AND `Basket`.`ID_Book`=`Books`.`ID_Book` AND `Books`.`ID_Book`='$idbook')";
								$res=mysqli_query($link, $query) or die(mysqli_error($link));
								$rows=mysqli_fetch_assoc($res);
								echo '<li class="font-cheque">';
								echo '<span class="font-cheque">Наименование: '.$rows[Name_Book].' - '.$rows[Author].'</span>';
								echo '<br>';
								echo '<span class="font-cheque">'.$rows[Quantity].' Х '.$rows[Price].' ₽</span>';
								echo '<br>';
								$cost_book=$rows[Quantity]*$rows[Price];
								echo '<span class="font-cheque">Стоимость: '.$cost_book.' ₽</span>';
								echo '</li>';
								echo '<br>';
								$i++;
								echo '</div>';
								$cost=$cost+$cost_book;
							}
						?>
					</ol>
				</div>
				<div>
					<span class="font-cheque">:::::::::::::::::::::::::::::::::</span>
				</div>
				<div style="display: flex; justify-content: space-between; font-size: 30px; width: 400px;">
					<div>
						<strong class="font-cheque">Итог:</strong>
					</div>
					<div>
						<strong class="font-cheque"><?php echo $cost;?> ₽</strong>
					</div>
				</div>
			</div>
			<input type="button" class="button_reg cto-to edit_but_r" style="margin: 0;" onclick="this.style='display: none'; print();" value="Распечатать">
		</div>
	</section>
</body>
</html>
</body>
</html>



