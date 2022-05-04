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
	<title> BookStore "TayaBook" поставщики </title>
</head>
<body>
	<header class="header">
		<div class="width33 ots">
			<a href="index.php" title="Вернуться на главную"><img class="logo" src="image/index.svg" style="margin-right: 8px;"></a>
			<a href="shops.php" title="Магазины"><img class="logo" src="image/shops.svg" style="height: 50px;"></a>
			<a href="favorite.php" title="Избранное"><img class="logo" src="image/favorite.svg" style="height: 55px; margin-left: 0; margin-right: 8px;"></a>
			<?php 	
				if ($_SESSION[employee]==true) { ?>
					<a href="suppliers.php" title="Поставщики"><img class="logo" src="image/suppliers.svg" style="height: 52px; margin-left: 10px;  transform: scale(1.25);"></a>
					<a href="users.php" title="Пользователи"><img class="logo" src="image/users.svg" style="height: 55px; margin-left: 15px;"></a>
					<a href="personnel.php" title="Сотрудники"><img class="logo" src="image/personnel.svg" style="height: 55px; margin-left: 18px;"></a>
			<?php } ?>
		</div>
		<div>
			<h1 class="title_index"> Поставщики </h1>
		</div>
		<div class="width33" style="display: flex; flex-direction: row;">
		<?php
			if ($_SESSION[auth]==true) { ?>
				<a href="orders.php" title="Заказы"><img class="logo" src="image/orders.svg" style="height: 70px;"></a>
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
		<br>
		<div class="center">
			<div class="search_div"> <!-- поиск книг по названию  -->
				<form class="search_div" method="POST">
					<input class="search_search" type="text" name="search" placeholder="Поиск по айди/организации/адресу" autocomplete="off" value="<?php echo $_POST[search];?>"> 
					<input class="search_bk_button" type="submit" name="button" value=""> <!-- submit все перезагружает (отправляет форму), а button просто кнопка -->
				</form>
				<?php if ($_SESSION[employee]==true) { ?>
					<input type="button" class="button_reg cto-to" value="Добавить нового поставщика" onClick='location.href="new_supplier.php"'>
				<?php } ?>
			</div>
			<div class="container"> <!-- контейнер с книгой  -->
				<div class="w100">
					<ul>
						<?php
							if ((isset($_POST[button]) AND empty($_POST[search])) OR (!isset($_POST[button]))) { 
								$query="SELECT * FROM `Suppliers`"; //отправка запроса на выборку книг из БД
								$res=mysqli_query($link, $query) or die(mysqli_error($link));
							}
							else {
								$query="SELECT * FROM `Suppliers` WHERE (`Organization` LIKE '%$_POST[search]%') OR (`Address` LIKE '%$_POST[search]%') OR (`ID_Supplier`='$_POST[search]')"; //отправка запроса на выборку книг из БД
								$res=mysqli_query($link, $query) or die(mysqli_error($link));
							}
							for ($sup=[]; $row=mysqli_fetch_assoc($res); $sup[]=$row); //row-из переменной res все данные в массив; book - создали ПУСТОЙ массив; book2 из массива row в массив book
							$res=''; // обнуляем для дальнейшего использования
							foreach ($sup as $value) { //foreach-цикл, row-массив с данными из БД, value - строка из БД
								if ($value[Organization]!='УДАЛЕННЫЙ ПОСТАВЩИК') {
									$res .='<form method="POST" style="display: flex; justify-content: space-between; align-items: center;">';
									$res .='<div>';
										$res .='<li>'.$value[Organization].' - '.$value[Address].' - '.$value[Phone_Number].'</li>';
									$res .='</div>';
									$res .='<br><br><br>';
									$res .='<div>';
										//СКРЫТОЕ ПОЛЕ С ПЕРЕМЕННОЙ ДЛЯ РЕДИРЕКТА
							  			$res .='<input type="text" class="hidden" name="sup_num" value="'.$value[ID_Supplier].'">';
							  			//КНОПКА ПРИ НАЖАТИИ НА КОТОРУЮ RADIO С ID=BOX СТАНОВИТСЯ АКТИВНЫМ
										$res .='<input type="submit" id="test" name="edit_sup" value="Редактировать" class="button_reg cto-to" style="margin: 0;" onclick="sup_box'.$value[ID_Supplier].'.checked = true">'; //нажимает на скрытый чекбокс с айди бокс.айди_книги
										//СКРЫТЫЙ RADIO, КОТОРЫЙ ПЕРЕКЛЮЧАЕТСЯ С ПОМОЩЬЮ НАЖАТИЯ НА КНОПКУ
										$res .='<input class="hidden" name="sup_checkbox" type="radio" id="sup_box'.$value[ID_Supplier].'" value="'.$value[ID_Supplier].'">'; //чекбокс - "флажочки" с круглечком (точка), которую можно выбрать лишь одну. Он передает значение с value (в котором находится айди книги) в переменную $_POST[checkbox]
										$_SESSION[id_sup]=$_POST[sup_num];
									$res .='</div>';	
									$res .='</form>';
								}
							}
							echo $res;
							if (isset($_POST[edit_sup])) {
								echo '<meta http-equiv=Refresh content="0; edit_supplier.php">';
							}
						?> 	
					</ul>
				</div>	
			</div>
		</div>
	</section>
</body>
</html>


