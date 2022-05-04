<?php 
	require("connection.php");
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="/image/index.svg" type="image/x-icon"> <!-- иконка сайта во вкладке-->
	<link rel="preconnect" href="https://fonts.gstatic.com"> <!-- подключение шрифта -->
	<link href="https://fonts.googleapis.com/css2?family=Pangolin&display=swap" rel="stylesheet"> <!-- подключение шрифта -->
	<link rel="stylesheet" type="text/css" href="css/style.css"> <!-- подключение css -->
	<title> BookStore "TayaBook" </title>
</head>
<body>
	<header class="header">
		<div class="width33 ots">
			<a href="index.php" title="Вернуться на главную"><img class="logo" src="image/index.svg" style="margin-right: 8px; transform: scale(1.25);"></a>
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
			<h1 class="title_index"> BookStore "TayaBook" </h1>
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
					<input class="search_search" type="text" name="search" placeholder="Поиск по названию книги/автору" autocomplete="off" value="<?php echo $_POST[search];?>"> 
					<input class="search_bk_button" type="submit" name="button" value=""> <!-- submit все перезагружает (отправляет форму), а button просто кнопка -->
				</form>
				<?php if ($_SESSION[employee]==true) { ?>
				<input type="button" class="button_reg cto-to" style="margin: 0px; margin-left: 15px;"  name="new_book" value="Добавить новую книгу" onClick='location.href="new_book.php"'>
				<?php } ?>
			</div>
			<div class="container"> <!-- контейнер с книгой  -->
				<div class="w100">
					<?php
						if ((isset($_POST[button]) AND empty($_POST[search])) OR (!isset($_POST[button]))) { 
							$query="SELECT * FROM `Books`"; //отправка запроса на выборку книг из БД
						}
						else {
							$_POST[search]=mysqli_real_escape_string($link,$_POST[search]);
							$query="SELECT * FROM `Books` WHERE (`Author` LIKE '%$_POST[search]%') OR (`Name_Book` LIKE '%$_POST[search]%') OR (`ID_Book`='$_POST[search]')";
						}
						$res=mysqli_query($link, $query) or die(mysqli_error($link));
						for ($book=[]; $row=mysqli_fetch_assoc($res); $book[]=$row); //row-из переменной res все данные в массив; book - создали ПУСТОЙ массив; book2 из массива row в массив book
						$res=''; // обнуляем для дальнейшего использования
						foreach ($book as $value) { //foreach-цикл, row-массив с данными из БД, value - строка из БД
							if ($value[Name_Book]!='УДАЛЁННАЯ КНИГА') {
								$res .='<div class="tovar" id="tovar_'.$value[ID_Book].'">';
								$res .='<div class="img_book">';   //картинка
								$res .='<img src="image/books/'.$value[Name_Book].'.jpg">';
								$res .='</div>';
								$res .='<div class="right_block">';
								$res .='<div class="book_title" style="display: flex; align-items: center;">';  //название
								$res .='<div style="width: 65%;">';
								$res .='<h1>'.$value[Name_Book].'</h1>'; //onclick='location.href="edit_book.php"'
								$res .='</div>';
								$res .='<form style="width: 35%; display: flex; align-items: center;" method="POST">';
								if ($_SESSION[employee]==true) {
									$res .='<input type="text" class="hidden" name="transition_edit" value="'.$value[ID_Book].'">'; //скрытое поле для перехода на страницу редактирования
									$res.='<input class="button_reg cto-to" value="Редактировать" type="submit" id="edit" name="edit" onclick="editbox'.$value[ID_Book].'.checked = true">';
									$res .='<input class="hidden" name="editcheckbox" type="radio" id="editbox'.$value[ID_Book].'" value="'.$value[ID_Book].'">';
								}
								$res .='</form>';
								$res .='</div>';
								$res .='<div class="description">'; 
								$res .='<div class="desc_w"> ';
								$res .='<div>';  //автор
								$res .='<p> <strong>Автор:</strong> '.$value[Author].'</p>'; 
								$res .='</div>';
								$res .='<div>';  //год
								$res .='<p> <strong>Год издания:</strong> '.$value[Year].' </p>';
								$res .='</div>';
								$res .='<div>';  //жанры
								$res .='<p> <strong>Жанры:</strong> '.$value[Genres].' </p>';
								$res .='</div>';
								$res .='<div>';  //кол-вол страниц
								$res .='<p> <strong>Кол-во страниц:</strong> '.$value[Pages].' </p>';
								$res .='</div>';
								$res .='<div>';  //цена (при отсутствии в наличии - "нет в наличии")
								$res .='<p> <strong>Цена:</strong> '.$value[Price].' ₽ </p>';
								$res .='</div>';
								if ($value[Quantity]==0) {
									$res.='<div style="display: flex; text-align: center; width: 340px; justify-content: center;">';
									$res .='<p> <strong style="font-size: 30px; color: #ce3c32; text-align: center;">Нет в наличии</strong></p>';
									$res.='</div>';
								}
								$res .='<div class="add_fv_bt">';
								if ($_SESSION[auth]){
									$query = "SELECT * FROM `Basket` WHERE (`ID_Book`='$value[ID_Book]') and (`ID_User`='$_SESSION[id_user]')";
									$row = mysqli_query($link, $query) or die(mysqli_error($link));
							 		$num = mysqli_num_rows($row);
							  		if($num == 0) {
										$res .='<form action="index.php" method="POST">';
							  			$fav="Добавить в избранное";
							  			//СКРЫТОЕ ПОЛЕ С ПЕРЕМЕННОЙ ДЛЯ РЕДИРЕКТА
							  			$res .='<input type="text" class="hidden" name="request_num" value="'.$value[ID_Book].'">';
							  			//КНОПКА ПРИ НАЖАТИИ НА КОТОРУЮ RADIO С ID=BOX СТАНОВИТСЯ АКТИВНЫМ
										$res .='<input type="submit" id="test" name="add_fav" value="'.$fav.'" class="add_fv_bt" onclick="box'.$value[ID_Book].'.checked = true">'; //нажимает на скрытый чекбокс с айди бокс.айди_книги
										//СКРЫТЫЙ RADIO, КОТОРЫЙ ПЕРЕКЛЮЧАЕТСЯ С ПОМОЩЬЮ НАЖАТИЯ НА КНОПКУ
										$res .='<input class="hidden" name="checkbox" type="radio" id="box'.$value[ID_Book].'" value="'.$value[ID_Book].'">'; //чекбокс - "флажочки" с круглечком (точка), которую можно выбрать лишь одну. Он передает значение с value (в котором находится айди книги) в переменную $_POST[checkbox]
										if (isset($_POST[add_fav])) {
											$fav="Удалить из избранного";
											echo '<meta http-equiv=Refresh content="0; redirect.php">';
										}
										$res .='</form>';
							  		}
							  		else {
							  			$res .='<form method="POST">';
							  			$fav="Удалить из избранного";
							  			$res .='<input type="text" class="hidden" name="request_num" value="'.$value[ID_Book].'">';
							  			$res .='<input type="submit" id="test" value="'.$fav.'" name="del_fav" class="add_fv_bt" onclick="box'.$value[ID_Book].'.checked = true">';
							  			$res .='<input class="hidden" name="checkbox" type="radio" id="box'.$value[ID_Book].'" value="'.$value[ID_Book].'">';
							  			if (isset($_POST[del_fav])) {
											$fav="Добавить в избранное";
											echo '<meta http-equiv=Refresh content="0; redirect.php">';
										}
										$res .='</form>';
							  		}
						  		}
								$res .='</div>';
								$res .='</div>';
								$res .='<div class="desc">';  //описание
								$res .='<p> '.$value[Description].'</p>';
								$res .='</div>';
								$res .='</div>';
								$res .='</div>';
								$res .='</div>';
							}
						}
						echo $res;
						if ($_SESSION[auth]){ 
							if (isset($_POST[add_fav])) {
								$query = "INSERT INTO `Basket` (`ID_User`, `ID_Book`) VALUES ('$_SESSION[id_user]','$_POST[checkbox]')";
								$row = mysqli_query($link, $query) or die(mysqli_error($link));
								$_SESSION[request]="tovar_".$_POST[request_num];
							}
							if (isset($_POST[del_fav])) {
								$query = "UPDATE `Basket` SET `ID_User`=(SELECT `ID_User` FROM `Users` WHERE (`Username`='УДАЛЁННЫЙ ПОЛЬЗОВАТЕЛЬ')) WHERE ((`ID_User`='$_SESSION[id_user]') AND (`ID_Book`='$_POST[checkbox]'))";
								$row = mysqli_query($link, $query) or die(mysqli_error($link));
								$_SESSION[request]="tovar_".$_POST[request_num];
							}
						}
						if (isset($_POST[edit])) {
							$_SESSION[id_book]=$_POST[editcheckbox];
							echo '<meta http-equiv=Refresh content="0; edit_book.php">';
						}
					?> 	
				</div>	
			</div>
		</div>
	</section>
</body>
</html>




<!-- <div class="tovar">
						<div class="img_book"> 
							<img src="image/books/naruto.jpg">
						</div>
						<div class="right_block">
							<div class="book_title"> 
								<h2> Naruto. Наруто. Книга 2. Мост героя </h2>
							</div>
							<div class="description">
								<div class="desc_w"> 
									<div> 
										<p> <strong>Автор:</strong> Кисимото М. </p>
									</div>
									<div>
										<p> <strong>Год издания:</strong> 2021 </p>
									</div>
									<div>
										<p> <strong>Жанры:</strong> Художественная литература, Комиксы (издания для взрослых), Манга (японский стиль) </p>
									</div>
									<div>
										<p> <strong>Кол-во страниц:</strong> 544 с. </p>
									</div>
									<div>
										<p> <strong>Цена:</strong> 677 р. </p>
									</div>
								</div>
								<div class="desc"> 
									<p> Став настоящими ниндзя, Наруто, Саскэ и Сакура получают ответственное задание – охранять знаменитого строителя мостов Тадзуну из Страны Волн. На жизнь этого старика покушаются беглый синоби Дзабудза и его подопечный Хаку, обладающий невероятными способностями. Столкновение с такими опасными противниками оборачивается трагедией, когда Саскэ закрывает собой Наруто от смертоносной атаки Хаку… Кажется, участь команды Какаси уже предрешена, но в Наруто вдруг пробуждается загадочная сила… Сможет ли он переломить ход битвы? </p>
								</div>
							</div>	
						</div>
					</div> -->



			<!-- $res .= $value[Name_Book]; //фор ич не имеет рамок, работает, пока данные есть
			$res .= $value[Author]; //строку из массива book записываем в массив value
			$res .= $value[Year];
			$res .= $value[Genres];
			$res .= $value[Pages];	
			$res .= $value[Price];
			$res .= $value[Description];
			$res .= $value[Image_Book]; -->

