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
	<link rel="stylesheet" type="text/css" href="css/style.css"> <!-- подключение css -->
	<title> BookStore "TayaBook" заказы </title>
</head>
<body>
	<header class="header">
		<div class="width33 ots">
			<a href="index.php" title="Вернуться на главную"><img class="logo" src="image/index.svg" style="margin-right: 8px;"></a>
			<a href="shops.php" title="Магазины"><img class="logo" src="image/shops.svg" style="height: 50px;"></a>
			<a href="favorite.php" title="Избранное"><img class="logo" src="image/favorite.svg" style="height: 55px; margin-left: 0; margin-right: 8px;"></a>
			<?php 	
				if ($_SESSION[employee]==true) { ?>
					<a href="suppliers.php" title="Поставщики"><img class="logo" src="image/suppliers.svg" style="height: 52px; margin-left: 5px;"></a>
					<a href="users.php" title="Пользователи"><img class="logo" src="image/users.svg" style="height: 55px; margin-left: 15px;"></a>
					<a href="personnel.php" title="Сотрудники"><img class="logo" src="image/personnel.svg" style="height: 55px; margin-left: 18px;"></a>
			<?php } ?>
		</div>
		<div>
			<h1 class="title_index"> Заказы </h1>
		</div>
		<div class="width33" style="display: flex; flex-direction: row;">
		<?php
			if ($_SESSION[auth]==true) { ?>
				<a href="orders.php" title="Заказы"><img class="logo" src="image/orders.svg" style="height: 70px; transform: scale(1.25);"></a>
				<div class="button-auth width33 user_header" style="display:flex; width:60%; align-items: center; margin-left: 20px;"> <a style="color:white; text-decoration:none;" href="pers_acc.php" title="Личный кабинет"> <?php echo $_SESSION[username]; ?> </a> </div> 
			<?php 
			}
			else { ?>
				<div class="button-auth">
					<input type="submit"class="button_reg" name="" value="Войти" onClick='location.href="auth.php"'>
					<span>/</span>	
					<input type="button" class="button_reg" name="" value="Зарегистрироваться" onClick='location.href="reg.php"'>
				</div>
			<?php 
			}  ?>
		</div>
	</header>
	<section>
		<div class="center">
			<input type="submit" class="button_reg cto-to edit_but edit_but_r" style="margin-bottom: 10px;" value="Новый заказ" onClick='location.href="make_order.php"'>	
			<div class="search_div"> <!-- поиск книг по названию  -->
				<form class="search_div" method="POST">
					<input class="search_search" type="text" name="search" placeholder="Поиск по номеру заказа" autocomplete="off" value="<?php echo $_POST[search];?>"> 
					<input class="search_bk_button" type="submit" name="button" value=""> <!-- submit все перезагружает (отправляет форму), а button просто кнопка -->
				</form>
			</div>		
			<div class="container"> <!-- контейнер с книгой  -->
				<div class="w100">
					<?php
						if ($_SESSION[employee]==true) { //для сотрудника
							if ((isset($_POST[button]) AND empty($_POST[search])) OR (!isset($_POST[button]))) { 
								$query="SELECT * FROM `Orders`"; //отправка запроса на выборку книг из БД
								$res=mysqli_query($link, $query) or die(mysqli_error($link));
								$num_row=mysqli_num_rows($res);
								$query="SELECT * FROM `Orders`, `Shops` WHERE (`Shops`.`ID_Shop`=`Orders`.`ID_Shop`) GROUP BY `ID_Order`"; //отправка запроса на выборку книг из БД
								$res=mysqli_query($link, $query) or die(mysqli_error($link));
							}
							else {
								$query="SELECT * FROM `Orders`"; //отправка запроса на выборку книг из БД
								$res=mysqli_query($link, $query) or die(mysqli_error($link));
								$num_row=mysqli_num_rows($res);
								$query="SELECT * FROM `Orders`, `Shops` WHERE (`Shops`.`ID_Shop`=`Orders`.`ID_Shop`) AND (`ID_Order`='$_POST[search]') GROUP BY `ID_Order`"; //отправка запроса на выборку книг из БД
								$res=mysqli_query($link, $query) or die(mysqli_error($link));
							}
							for ($fav=[]; $row=mysqli_fetch_assoc($res); $fav[]=$row); //row-из переменной res все данные в массив; book - создали ПУСТОЙ массив; book2 из массива row в массив book
							$res=''; // обнуляем для дальнейшего использования
							foreach ($fav as $value) { //foreach-цикл, row-массив с данными из БД, value - строка из БД
								$res.='<div class="tovar" id="'.$value[ID_Order].'" style="border-radius: 20px; margin: 20px;">';
									$res.='<div style="display: flex; font-size: 20px; margin: 20px;">';
										$res.='<div style="display: flex; flex-direction: column; width: 75%;">';				
											$res.='<strong>ID заказа: '.$value[ID_Order].' </strong>';
											$res.='<strong>ID пользователя: '.$value[ID_User].' </strong>';
											$res.='<strong>Дата заказа: '.$value[Date_Order].' </strong>';
											$res.='<strong>Статус заказа: '.$value[Status].' </strong>';
											$res.='<ol>'; //нумерованный список
												$querys="SELECT `ID_Order`, `Date_Order`, `Status`, `Orders`.`Quantity`, `Basket`.`ID_Book`, `Books`.`ID_Book`, `Name_Book`, `Author`, `Price`, `Address`, `Phone_Number` FROM `Orders`, `Basket`, `Books`, `Shops` WHERE (`ID_Order`='$value[ID_Order]' AND `Orders`.`ID_Basket`=`Basket`.`ID_Basket` AND `Books`.`ID_Book`=`Basket`.`ID_Book`) GROUP BY `Books`.`ID_Book`"; //отправка запроса на выборку книг из БД
												$ress=mysqli_query($link, $querys) or die(mysqli_error($link));
												$cost_book=0;
												for ($order=[]; $rows=mysqli_fetch_assoc($ress); $order[]=$rows);
												foreach ($order as $values) { //foreach-цикл, row-массив с данными из БД, value - строка из БД
													$res.='<li>';
														$res.='<div><strong>Наименование: </strong>'.$values[Name_Book].' - '.$values[Author].' - '.$values[Price].' ₽ - '.$values[Quantity].' шт.</div>';
													$res.='</li>';
													$cost_book=$cost_book+($values[Price]*$values[Quantity]);
												}	
											$res.='</ol>';
											$res.='<strong>Магазин доставки: '.$value[Address].' - '.$value[Phone_Number].' </strong>';
											$res.='<strong>Стоимость заказа: '.$cost_book.' ₽ </strong>';
												$vipolnil="SELECT `FIO` FROM `Personnel`, `Orders` WHERE (`Personnel`.`ID_Personnel`='$value[ID_Personnel]' AND `ID_Order`='$value[ID_Order]')";
												$row_vipolnil=mysqli_query($link, $vipolnil) or die(mysqli_error($link));
												$res_vipolnil=mysqli_fetch_assoc($row_vipolnil);
												if ($res_vipolnil[FIO]!='УДАЛЕННЫЙ ПЕРСОНАЛ') {
													$res.='<strong>Выполнил заказ: '.$res_vipolnil[FIO].' </strong>';
												}
										$res.='</div>';
										$res.='<div style="width: 25%;">';
										if ($value[Status]=='Не выполнен') {
											$res.='<form method="POST">';
												$res .='<input type="text" class="hidden" name="confirm_num" value="'.$value[ID_Order].'">'; //подтвердить выполнение заказа
												$res .='<input type="submit" id="test" name="confirm_order" value="Подтвердить готовый заказ" class="button_reg cto-to" onclick="confirm_box'.$value[ID_Order].'.checked = true">';
												$res .='<input class="hidden" name="confirm_checkbox" type="radio" id="confirm_box'.$value[ID_Order].'" value="'.$value[ID_Order].'">';
											$res.='</form>';
											$res.='<form method="POST">';
												$res .='<input type="text" class="hidden" name="order_num" value="'.$value[ID_Order].'">';
												$res .='<input type="submit" id="test" name="edit_order" value="Редактировать заказ" class="button_reg cto-to" onclick="order_box'.$value[ID_Order].'.checked = true">';
												$res .='<input class="hidden" name="order_checkbox" type="radio" id="order_box'.$value[ID_Order].'" value="'.$value[ID_Order].'">';
											$res.='</form>';
										}
										$res.='</div>';
									$res.='</div>';
								$res.='</div>';
							}
						}						
						else { //для пользователя
							$query="SELECT * FROM `Orders` WHERE (`ID_User`='$_SESSION[id_user]')"; //отправка запроса на выборку книг из БД
							$res=mysqli_query($link, $query) or die(mysqli_error($link));
							$num_row=mysqli_num_rows($res);
							$query="SELECT * FROM `Orders`, `Shops` WHERE (`ID_User`='$_SESSION[id_user]' AND `Shops`.`ID_Shop`=`Orders`.`ID_Shop`) GROUP BY `ID_Order`"; //отправка запроса на выборку книг из БД
							$res=mysqli_query($link, $query) or die(mysqli_error($link));
							for ($fav=[]; $row=mysqli_fetch_assoc($res); $fav[]=$row); //row-из переменной res все данные в массив; book - создали ПУСТОЙ массив; book2 из массива row в массив book
							$res=''; // обнуляем для дальнейшего использования
							$cost=0;
							foreach ($fav as $value) { //foreach-цикл, row-массив с данными из БД, value - строка из БД
								$res.='<div class="tovar" style="border-radius: 20px; margin: 20px;">';
									$res.='<div style="display: flex; flex-direction: column; font-size: 20px; margin: 20px;">';
										$res.='<strong>ID заказа: '.$value[ID_Order].' </strong>';
										$res.='<strong>Дата заказа: '.$value[Date_Order].' </strong>';
										$res.='<strong>Статус заказа: '.$value[Status].' </strong>';
										$res.='<ol>'; //нумерованный список
											$querys="SELECT `ID_Order`, `Date_Order`, `Status`, `Orders`.`Quantity`, `Basket`.`ID_Book`, `Books`.`ID_Book`, `Name_Book`, `Author`, `Price`, `Address`, `Phone_Number` FROM `Orders`, `Basket`, `Books`, `Shops` WHERE (`ID_Order`='$value[ID_Order]' AND `Orders`.`ID_Basket`=`Basket`.`ID_Basket` AND `Books`.`ID_Book`=`Basket`.`ID_Book`) GROUP BY `Books`.`ID_Book`"; //отправка запроса на выборку книг из БД
											$ress=mysqli_query($link, $querys) or die(mysqli_error($link));
											$cost_book=0;
											for ($order=[]; $rows=mysqli_fetch_assoc($ress); $order[]=$rows);
											foreach ($order as $values) { //foreach-цикл, row-массив с данными из БД, value - строка из БД
												$res.='<li>';
												$res.='<div><strong>Наименование: </strong>'.$values[Name_Book].' - '.$values[Author].' - '.$values[Price].' ₽ - '.$values[Quantity].' шт.</div>';
												$res.='</li>';
												$cost_book=$cost_book+($values[Price]*$values[Quantity]);
											}	
											$cost=$cost+$cost_book;
										$res.='</ol>';
										$res.='<strong>Магазин доставки: '.$value[Address].' - '.$value[Phone_Number].' </strong>';
										$res.='<strong>Стоимость заказа: '.$cost.' ₽ </strong>';
									$res.='</div>';
								$res.='</div>';
							}
						}
						if (isset($_POST[edit_order])) {
							$_SESSION[id_order]=$_POST[order_num];
							echo '<meta http-equiv=Refresh content="0; edit_order.php">';
						}
						if (isset($_POST[confirm_order])) {
							$query="UPDATE `Orders` SET `ID_Personnel`='$_SESSION[id_user]', `Status`='Выполнен' WHERE `ID_Order`='$_POST[confirm_num]'";
							$res=mysqli_query($link, $query) or die(mysqli_error($link));
							$_SESSION[id_order_request]=$_POST[confirm_num];
							echo '<meta http-equiv=Refresh content="0; redirect1.php">';
						}
					if ($num_row!=0) {
						echo $res;
					}
					else {
						echo '<p>Упс! Вы ничего у нас не заказывали :)</p>';
					}
					?>
				</div>	
			</div>
		</div>
	</section>
</body>
</html>
</body>
</html>



