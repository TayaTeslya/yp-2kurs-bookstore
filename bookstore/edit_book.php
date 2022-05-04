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
	<title> BookStore "TayaBook" редактировать книгу  </title>
</head>
<body>
	<header class="header" style="justify-content: center;">
		<div style="display: flex; justify-content: center; text-align: center;">
			<h1 class="title_index"> Редактировать книгу </h1>
		</div>
	</header>
	<section>
		<div class="center">
			<div class="container"> <!-- контейнер с книгой  -->
				<div class="w100">
					<br>
					<?php 
						$query="SELECT * FROM `Books` WHERE (`ID_Book`='$_SESSION[id_book]')"; //отправка запроса на выборку книг из БД
						$res=mysqli_query($link, $query) or die(mysqli_error($link));
						$row=mysqli_fetch_assoc($res);//row-из переменной res все данные в массив; book - создали ПУСТОЙ массив; book2 из массива row в массив book
					?>
					<?php
						if (isset($_POST[del_submit])) {
							unlink('image/books/'.$row[Name_Book].'.jpg');
							$_FILES['photo']=null;
							$error=false;
							$message='Книга успешно удалена';
							$query="UPDATE `Basket` SET `ID_Book`=(SELECT `ID_Book` FROM `Books` WHERE (`Name_Book`='УДАЛЁННАЯ КНИГА')) WHERE (`ID_Book`='$_SESSION[id_book]')";
							$res=mysqli_query($link, $query) or die(mysqli_error($link));
							$query = "DELETE FROM `Books` WHERE (`ID_Book`='$_SESSION[id_book]')";
							$row = mysqli_query($link, $query) or die(mysqli_error($link));
							echo '<meta http-equiv=Refresh content="1; index.php">';
						}
						if (isset($_POST[edit_submit])) {
							if ((!empty($_POST[name_book])) and (!empty($_POST[author])) and (!empty($_POST[year])) and (!empty($_POST[genres])) and (!empty($_POST[pages])) and (!empty($_POST[price])) and (!empty($_POST[description]))) {
								$today=date('Y');
								if (($_POST[year]-$today)<=0) {
									if ((preg_match('/^[0-9]+$/',$_POST[pages])) and (preg_match('/^[0-9]+$/',$_POST[price])) and (preg_match('/^[0-9]+$/',$_POST[quantity]))) {
										if ($_POST[price]>0) {
											if ($_POST[pages]>0) {
												if (file_exists('image/books/'.$_POST[name_book].'.jpg')) {
													$error=false;
													$message='Изменения успешно внесены';
													$query="UPDATE `Books` SET `Name_Book`='$_POST[name_book]', `Author`='$_POST[author]', `Year`='$_POST[year]', `Genres`='$_POST[genres]', `Description`='$_POST[description]', `Pages`='$_POST[pages]', `Price`='$_POST[price]', `Quantity`='$_POST[quantity]' WHERE `ID_Book`='$row[ID_Book]'"; //отправка запроса на выборку книг из БД
													$res=mysqli_query($link, $query) or die(mysqli_error($link));
													echo '<meta http-equiv=Refresh content="1; index.php">';
												}
												else {
													$message='Загрузите фото (если вы уже это сделали, повторно нажмите на кнопку "внести изменения").';
													$error=true;
												}
											}
											else {
												$message='Кол-во страниц должно быть больше 0.';
												$error=true;
											}
										}
										else {
											$message='Цена должна быть больше 0.';
											$error=true;
										}
									}
									else {
										$message='Проверьте правильность введенных данных в полях "Цена" и/или "Кол-во страниц" и/или "Кол-во"';
										$error=true;
									}
								}
								else {
									$message='Введите корректный год.';
									$error=true;
								}
							}
							else {
								$message='Все поля должны быть заполнены.';
								$error=true;
							}
						}
						else {
							$_POST[name_book]=$row[Name_Book];
							$_POST[author]=$row[Author];
							$_POST[year]=$row[Year];
							$_POST[genres]=$row[Genres];
							$_POST[pages]=$row[Pages];
							$_POST[quantity]=$row[Quantity];
							$_POST[price]=$row[Price];
							$_POST[description]=$row[Description];
						}
						if (isset($_POST[not_edit_book])) {
							echo '<meta http-equiv=Refresh content="0; index.php">';
						}
					?>
					<div class="tovar">
						<form method="POST" enctype="multipart/form-data" style="display: flex;">
							<div>
								<div class="img_book">
									<img src="image/books/<?php echo $row[Name_Book]?>.jpg">
								</div>
								<?php
									if (isset($_POST[photo])) {
										$file="image/books/".$row[Name_Book].".jpg"; //в какую папку с названием файла
										move_uploaded_file($_FILES['photo']['tmp_name'], $file); //перекидываем глоб переменную файлс, в которой находится загруженное фото, с временной папки на сервер
										$_FILES['photo']=null;
									}
								?>
								<label for="upload-photo" class="">Загрузить фото:</label>
								<input name="photo" type="file" id="upload-photo" class="">
							</div>
							<div class="right_block" style="width: 100%">
								<div class="book_title">
									<h1> <input class="acc" style="width: 100%;" type="text" name="name_book" placeholder="Название" autocomplete="off" value="<?php echo $_POST[name_book]?>"> </h1>
								</div>
								<div class="description">
									<div class="desc_w">
										<div>
											<div>
												<strong>Автор: </strong>
											</div>
											<div>
												<input class="acc" style="font-size: 15px; width: 255px;" type="text" name="author" placeholder="Автор" autocomplete="off" value="<?php echo $_POST[author]?>">
											</div>
										</div>
										<br>
										<div>
											<div>
												<strong>Год издания: </strong>
											</div>
											<div>
												<input class="acc" style="font-size: 15px; width: 255px;" pattern="[0-9]{4}" type="text" name="year" placeholder="Год издания" autocomplete="off" value="<?php echo $_POST[year]?>">
											</div>
										</div>
										<br>
										<div>
											<div>
												<strong>Жанры: </strong>
											</div>
											<div>
												<textarea class="acc" style="font-size: 15px; width: 255px;" cols="30" rows="3" name="genres" placeholder="Жанры" autocomplete="off"><?php echo $_POST[genres]?></textarea>
											</div>
										</div>
										<br>
										<div>
											<div>
												<strong>Кол-во страниц: </strong>
											</div>
											<div>
												<input class="acc" style="font-size: 15px; width: 255px;" type="text" name="pages" placeholder="Кол-во страниц" autocomplete="off" value="<?php echo $_POST[pages]?>">
											</div>						
										</div>
										<br>
										<div>
											<div>
												<strong>Цена: </strong>
											</div>
											<div>
												<input class="acc" style="font-size: 15px; width: 255px;" type="text" name="price" placeholder="Цена" autocomplete="off" value="<?php echo $_POST[price]?>">
											</div>
										</div>
										<br>
										<div>
											<div>
												<strong>Кол-во: </strong>
											</div>
											<div>
												<input class="acc" style="font-size: 15px; width: 255px;" type="text" name="quantity" placeholder="Цена" autocomplete="off" value="<?php echo $_POST[quantity]?>">
											</div>
										</div>
						  			</div>
					  				<div class="desc">
										<textarea class="acc" style="font-size: 15px;" cols="70" rows="21" name="description" placeholder="Описание" autocomplete="off"><?php echo $_POST[description]?></textarea>
									</div>
								</div>
								<div>
									<input type="submit" class="button_reg cto-to edit_but" value="Внести изменения" name="edit_submit">
									<input type="submit" class="button_reg cto-to edit_but edit_but_r" value="Удалить книгу" name="del_submit">
									<input type="submit" name="not_edit_book" value="Отмена" class="button_reg cto-to edit_but_r">
								</div>	
								<div>
									<?php if ($error==false) { ?>
										<p class="success" style="text-align: center; margin-left: 250px;"><?php echo $message; ?></p>
									<?php } ?>
									<?php  if ($error==true) { ?>
										<p class="error" style="text-align: center; margin-left: 250px;"><?php echo $message; ?></p>
									<?php } ?>
								</div>
							</div>
						</form>
					</div>
				</div>	
			</div>
		</div>
	</section>
</body>
</html>


<!-- //СКРЫТОЕ ПОЛЕ С ПЕРЕМЕННОЙ ДЛЯ РЕДИРЕКТА

							
							
						}
					echo $res;;
					if (isset($_POST[del_fav])) {
						echo "1";
						
						echo '<meta http-equiv=Refresh content="0; redirect2.php">';
					}
					?>	 -->