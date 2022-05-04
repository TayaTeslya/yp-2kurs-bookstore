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
	<title> BookStore "TayaBook" редактировать заказ </title>
</head>
<body>
	<header class="header" style="justify-content: center;">
		<div style="display: flex; justify-content: center; text-align: center;">
			<h1 class="title_index"> Редактировать заказ </h1>
		</div>
	</header>
	<section>
		<div class="center">
			<div class="container"> <!-- контейнер с книгой  $_SESSION[id_order_request] -->
				<div class="w100">
					<br>
					<?php
						$query="SELECT * FROM `Orders`, `Shops` WHERE (`ID_Order`='$_SESSION[id_order]' AND `Shops`.`ID_Shop`=`Orders`.`ID_Shop`) GROUP BY `ID_Order`";  //отправка запроса на выборку книг из БД
						$res=mysqli_query($link, $query) or die(mysqli_error($link));
						$row=mysqli_fetch_assoc($res);
						$id_selected_shop=$row[ID_Shop]; 
					?>
					<div class="tovar" style="border-radius: 20px; margin: 20px; font-size: 30px;">
						<div style="display: flex; font-size: 20px; margin: 20px;">
							<form method="POST" style="display: flex; font-size: 20px; margin: 20px;">
								<div style="display: flex; flex-direction: column; width: 75%;">			
									<strong>ID заказа: <?php echo $_SESSION[id_order]?></strong>
									<strong>ID пользователя: <?php echo $row[ID_User]?></strong>
									<strong>Дата заказа: <?php echo $row[Date_Order]?></strong>
									<span class="liliput">*при внесении изменений дата заказа изменится на сегодняшнюю</span>
									<strong>Статус заказа: <?php echo $row[Status] ?></strong>
									<ol>
										<?php $querys="SELECT `Orders`.`Quantity`, `Basket`.`ID_Book`, `Books`.`ID_Book`, `Name_Book`, `Author`, `Price`, `Address`, `Phone_Number` FROM `Orders`, `Basket`, `Books`, `Shops` WHERE (`ID_Order`='$_SESSION[id_order]' AND `Orders`.`ID_Basket`=`Basket`.`ID_Basket` AND `Books`.`ID_Book`=`Basket`.`ID_Book`) GROUP BY `Books`.`ID_Book`"; 
											$ress=mysqli_query($link, $querys) or die(mysqli_error($link));
											$cost_book=0;
											for ($order=[]; $rows=mysqli_fetch_assoc($ress); $order[]=$rows);
											foreach ($order as $values) { ?>
												<li>
													<div><strong>Наименование: </strong> <?php echo $values[Name_Book].' - '.$values[Author].' - '.$values[Price].' ₽ - '.$values[Quantity].' шт.'; ?></div>
												</li>
												<?php $cost_book=$cost_book+($values[Price]*$values[Quantity]);
											}	
										?>
									</ol>
									<div style="display: flex; justify-content: flex-start; align-items: center;">
										<strong>Адрес доставки: </strong>
										<select class="acc" name="edit_idshop" style="display: flex; justify-content: flex-start; width: 370px; font-size: 20px;">
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
									<strong>Стоимость заказа: <?php echo $cost_book.' ₽' ?></strong>
								</div>
								<div>								
									<input type="submit" name="edit_id_shop" value="Изменить адрес доставки" class="button_reg cto-to edit_but">
									<input type="submit" name="not_edit_id_shop" value="Отмена" class="button_reg cto-to edit_but edit_but_r">
								</div>
							</form>
							<?php 
							 if (isset($_POST[edit_id_shop])) {
							 	$error=false;
							 	$message='Изменения успешно внесены.';
							 	$query="UPDATE `Orders` SET `ID_Shop`='$_POST[edit_idshop]' WHERE (`ID_Order`='$_SESSION[id_order]')";
							 	$res=mysqli_query($link, $query) or die(mysqli_error($link));
							 	$row=mysqli_fetch_assoc($res);
							 	echo '<meta http-equiv=Refresh content="1; orders.php">';
							 }
							 if (isset($_POST[not_edit_id_shop])) {
							 	echo '<meta http-equiv=Refresh content="0; orders.php">';
							 }
							?>
						</div>
					</div>
				</div>
				<?php if ($error==false) { ?>
					<p class="success"><?php echo $message; ?></p>
				<?php } ?>
			</div>	
		</div>
	</section>
</body>
</html>


