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
	<title> BookStore "TayaBook" выбрать книги </title>
</head>
<body>
	<header class="header" style="display: flex; justify-content: center;">
			<h1 class="title_index"> Выбрать книги для заказа (из избранного) </h1>
	</header>
	<section>
		<div style="display:flex; align-items: center; justify-content: center;">
			<form method="POST">
				<div style="display: flex; justify-content: center;">
					<input name="make_order" type="submit" value="Сделать заказ" class="button_reg cto-to">
					<input name="not_make_order" type="button" value="Отмена" class="button_reg cto-to edit_but_r" onClick='location.href="orders.php"'>
				</div>
				<div class="container"> <!-- контейнер с книгой  -->
					<div class="w100">
						<br>
						<?php
							if (isset($_POST[make_order])) {
								$_SESSION['idorders']=$_POST['checkbox'];
								if (!empty($_SESSION['idorders'])) {
									echo '<meta http-equiv=Refresh content="0; new_order.php">';
								}
								else {
									$error=true;
									$message='Вы ничего не выбрали.';
								}
							}
							if ($error==true) { ?>
								<p class="error" ><?php echo $message; ?></p>
							<?php }
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
								$res .='<div class="add_fv_bt">';
								$res .='</div>';
								$res .='</div>';
								$res .='<div class="desc">';  //описание
								if ($value[Quantity]!=0) {
									$res.='<div style="font-size: 30px; color: #3b5b54;">';
									$res .='<input type="checkbox" style="transform: scale(2);" name="checkbox[]" id="'.$value[ID_Book].'" value="'.$value[ID_Book].'">';
									$res .='<strong> Выбрать книгу </strong>';
									$res.='</div>';
								}
								else {
									$res.='<div>';
                                    $res .='<p> <strong style="font-size: 30px; color: #ce3c32; text-align: center;">Нет в наличии</strong></p>';
                                    $res.='</div>';
								}

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
						?>
					</div>	
				</div>
			</form>
		</div>
	</section>
</body>
</html>
</body>
</html>



