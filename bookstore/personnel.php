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
	<title> BookStore "TayaBook" сотрудники </title>
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
					<a href="users.php" title="Пользователи"><img class="logo" src="image/users.svg" style="height: 55px; margin-left: 15px; "></a>
					<a href="personnel.php" title="Сотрудники"><img class="logo" src="image/personnel.svg" style="height: 55px; margin-left: 18px; transform: scale(1.3);"></a>
			<?php } ?>
		</div>
		<div>
			<h1 class="title_index"> Сотрудники </h1>
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
		<div class="center">
			<div class="search_div"> <!-- поиск книг по названию  -->
				<form class="search_div" method="POST">
					<input class="search_search" type="text" name="search" placeholder="Поиск по фио/номеру паспорта/посту/магазину" autocomplete="off" value="<?php echo $_POST[search];?>"> 
					<input class="search_bk_button" type="submit" name="button" value=""> <!-- submit все перезагружает (отправляет форму), а button просто кнопка -->
				</form>
				<?php if ($_SESSION[employee]==true) { ?>
				<input type="button" class="button_reg cto-to" value="Добавить нового сотрудника" onClick='location.href="new_personnel.php"'>
				<?php } ?>
			</div>
			<div class="container"> <!-- контейнер с книгой  -->
				<div class="w100">
					<br>
					<?php
						if ((isset($_POST[button]) AND empty($_POST[search])) OR (!isset($_POST[button]))) { 
							$query="SELECT * FROM `Personnel`";
						}
						else {
							$query="SELECT * FROM `Personnel` WHERE (`Passport` LIKE '%$_POST[search]%') OR (`Post` LIKE '%$_POST[search]%') OR (`FIO` LIKE '%$_POST[search]%') OR (`ID_Shop`='$_POST[search]')";
						}
						$res=mysqli_query($link, $query) or die(mysqli_error($link));
						for ($personnel=[]; $row=mysqli_fetch_assoc($res); $personnel[]=$row); //row-из переменной res все данные в массив; book - создали ПУСТОЙ массив; book2 из массива row в массив book
						$res=''; // обнуляем для дальнейшего использования
						foreach ($personnel as $value) { //foreach-цикл, row-массив с данными из БД, value - строка из БД
							if ($value[FIO]!='УДАЛЕННЫЙ ПЕРСОНАЛ' AND $value[Post]!='Системный администратор') {
								$res .='<div class="tovar">';
									$res .='<ul>';
										$res .='<li>';
											$res .='<div style="display: flex; width: 1320px;">';
												$res .='<div style="display: flex; flex-direction: column; font-size: 20px; width: 50%;">';
													$res .='<div>';
														$res .='<strong>ФИО: </strong>'.$value[FIO];
													$res .='</div>';
													$res .='<div>';
														$res .='<strong>Серия и номер паспорта: </strong>'.$value[Passport];
													$res .='</div>';
													$res .='<div>';
														$res .='<strong>Дата выдачи паспорта: </strong>'.$value[Passport_Date_Issue];
													$res .='</div>';
													$res .='<div>';
														$res .='<strong>Место выдачи паспорта: </strong>'.$value[Passport_Place_Issue];
													$res .='</div>';
													$res .='<div>';
														$res .='<strong>Дата рождения: </strong>'.$value[Date_Birth];
													$res .='</div>';
													$res .='<div>';
														$res .='<strong>Номер телефона: </strong>'.$value[Phone_Number];
													$res .='</div>';
													$res .='<div>';
														$res .='<strong>Пост: </strong>'.$value[Post];
													$res .='</div>';
													$res .='<div>';
														$res .='<strong>Заработная плата: </strong>'.$value[Salary];
													$res .='</div>';
													$res .='<div>';
														$res .='<strong>Привязан к ID='.$value[ID_Shop].' магазину </strong>';
													$res .='</div>';
												$res .='</div>';
												$res .='<div style="width: 50%;">';
													$res .='<form method="POST">';
								  						$res .='<input type="text" class="hidden" name="personnel_num" value="'.$value[ID_Personnel].'">'; //СКРЫТОЕ ПОЛЕ С ПЕРЕМЕННОЙ ДЛЯ РЕДИРЕКТА
														$res .='<input type="submit" id="test" name="edit_user" value="Редактировать" class="button_reg cto-to edit_but" onclick="user_box'.$value[ID_Personnel].'.checked = true">'; //КНОПКА ПРИ НАЖАТИИ НА КОТОРУЮ RADIO С ID=BOX СТАНОВИТСЯ АКТИВНЫМ
														$res .='<input class="hidden" name="user_checkbox" type="radio" id="user_box'.$value[ID_Personnel].'" value="'.$value[ID_Personnel].'">'; //СКРЫТЫЙ RADIO, КОТОРЫЙ ПЕРЕКЛЮЧАЕТСЯ С ПОМОЩЬЮ НАЖАТИЯ НА КНОПКУ
													$res .='</form>';
												$res .='</div>';
											$res .='</div>';
										$res .='</li>';
									$res .='</ul>';
								$res .='</div>';
							}
						}
						echo $res;
						if (isset($_POST[edit_user])) {
							$_SESSION[id_personnel]=$_POST[personnel_num];
							echo '<meta http-equiv=Refresh content="0; edit_personnel.php">';
						}
					?>
				</div>	
			</div>
		</div>
	</section>
</body>
</html>