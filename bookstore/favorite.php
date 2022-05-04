<?php 
	require("connection.php");
?>
<?php 
	if ($_SESSION[auth]!=true) {
		echo '<meta http-equiv=Refresh content="0; auth.php">'; 
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="/image/index.svg" type="image/x-icon"> <!-- иконка сайта во вкладке-->
	<link rel="preconnect" href="https://fonts.gstatic.com"> <!-- подключение шрифта -->
	<link href="https://fonts.googleapis.com/css2?family=Pangolin&display=swap" rel="stylesheet"> <!-- подключение шрифта -->
	<link rel="stylesheet" type="text/css" href="css/style.css"> <!-- подключение css -->
	<title> BookStore "TayaBook" избранное </title>
</head>
<body>
	<header class="header">
		<div class="width33 ots">
			<a href="index.php" title="Вернуться на главную"><img class="logo" src="image/index.svg" style="margin-right: 8px;"></a>
			<a href="shops.php" title="Магазины"><img class="logo" src="image/shops.svg" style="height: 50px;"></a>
			<a href="favorite.php" title="Избранное"><img class="logo" src="image/favorite.svg" style="height: 55px; margin-left: 0; margin-right: 10px; transform: scale(1.25);"></a>
			<?php 		
				if ($_SESSION[employee]==true) { ?>
					<a href="suppliers.php" title="Поставщики"><img class="logo" src="image/suppliers.svg" style="height: 52px; margin-left: 5px;"></a>
					<a href="users.php" title="Пользователи"><img class="logo" src="image/users.svg" style="height: 55px; margin-left: 15px;"></a>
					<a href="personnel.php" title="Сотрудники"><img class="logo" src="image/personnel.svg" style="height: 55px; margin-left: 18px;"></a>
			<?php } ?>
		</div>
		<div>
			<h1 class="title_index"> Избранное </h1>
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
			<div class="container"> <!-- контейнер с книгой  -->
				<div class="w100">
					<br>
					<?php
						$query="SELECT * FROM `Books`, `Basket` WHERE ((Books.`ID_Book`=Basket.`ID_Book`) AND (`ID_User`='$_SESSION[id_user]'))"; //отправка запроса на выборку книг из БД
						$res=mysqli_query($link, $query) or die(mysqli_error($link));
						$num_rows=mysqli_num_rows($res);
						$query="SELECT * FROM `Books`, `Basket` WHERE ((Books.`ID_Book`=Basket.`ID_Book`) AND (`ID_User`='$_SESSION[id_user]'))"; //отправка запроса на выборку книг из БД
						$res=mysqli_query($link, $query) or die(mysqli_error($link));
						for ($book=[]; $row=mysqli_fetch_assoc($res); $book[]=$row); //row-из переменной res все данные в массив; book - создали ПУСТОЙ массив; book2 из массива row в массив book
						$res=''; // обнуляем для дальнейшего использования
						foreach ($book as $value) { //foreach-цикл, row-массив с данными из БД, value - строка из БД
							$res .='<div class="tovar">';
							$res .='<div class="img_book">';   //картинка
							$res .='<img src="image/books/'.$value[Name_Book].'.jpg">';
							$res .='</div>';
							$res .='<div class="right_block">';
							$res .='<div class="book_title">';  //название
							$res .='<h1>'.$value[Name_Book].'</h1>';
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
				  			$res .='<form method="POST">';
				  			//СКРЫТОЕ ПОЛЕ С ПЕРЕМЕННОЙ ДЛЯ РЕДИРЕКТА
				  			$fav="Удалить из избранного";
						  	$res .='<input type="text" class="hidden" name="request_num" value="'.$value[ID_Book].'">';
							//КНОПКА ПРИ НАЖАТИИ НА КОТОРУЮ RADIO С ID=BOX СТАНОВИТСЯ АКТИВНЫМ
							$res .='<input type="submit" id="test" name="del_fav" value="'.$fav.'" class="add_fv_bt" onclick="box'.$value[ID_Book].'.checked = true">';
							//СКРЫТЫЙ RADIO, КОТОРЫЙ ПЕРЕКЛЮЧАЕТСЯ С ПОМОЩЬЮ НАЖАТИЯ НА КНОПКУ
							$res .='<input class="hidden" name="checkbox" type="radio" id="box'.$value[ID_Book].'" value="'.$value[ID_Book].'">';
							$res .='</form>';
							$res .='</div>';
							$res .='</div>';
							$res .='<div class="desc">';  //описание
							$res .='<p> '.$value[Description].'</p>';
							$res .='</div>';
							$res .='</div>';
							$res .='</div>';
							$res .='</div>';
						}
					if ($num_rows!=0) {
						echo $res;
					}
					else {
						echo '<p>Упс! Вы ничего не добавили в избранное :)</p>';
					}
					if (isset($_POST[del_fav])) {
						$query = "UPDATE `Basket` SET `ID_User`=(SELECT `ID_User` FROM `Users` WHERE (`Username`='УДАЛЁННЫЙ ПОЛЬЗОВАТЕЛЬ')) WHERE ((`ID_User`='$_SESSION[id_user]') AND (`ID_Book`='$_POST[request_num]'))";
						$row = mysqli_query($link, $query) or die(mysqli_error($link));
						$_SESSION[request]="favorite.php";
						echo '<meta http-equiv=Refresh content="0; redirect2.php">';
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



