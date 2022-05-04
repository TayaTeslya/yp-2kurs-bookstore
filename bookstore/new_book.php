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
	<title> BookStore "TayaBook" добавить книгу </title>
</head>
<body>
	<header class="header" style="justify-content: center;">
		<div style="display: flex; justify-content: center; text-align: center;">
			<h1 class="title_index"> Добавить книгу </h1>
		</div>
	</header>
	<section>
		<div class="center">
			<div class="container"> <!-- контейнер с книгой  -->
				<div class="w100">
					<br>
					<?php
						if (isset($_POST[not_new_book])) {
							echo '<meta http-equiv=Refresh content="0; index.php">';
						}
						if (isset($_POST[new_book])) {
							if ((!empty($_POST[name_book])) and (!empty($_POST[author])) and (!empty($_POST[year])) and (!empty($_POST[genres])) and (!empty($_POST[pages])) and (!empty($_POST[price])) and (!empty($_POST[description]))) {
								$query="SELECT * FROM `Books` WHERE (`Name_Book`='$_POST[name_book]')"; //отправка запроса на выборку книг из БД
								$res=mysqli_query($link, $query) or die(mysqli_error($link));
								$num=mysqli_num_rows($res);
								if ($num==0) {
									if ((preg_match('/^[0-9]+$/',$_POST[pages])) and (preg_match('/^[0-9]+$/',$_POST[price])) and (preg_match('/^[0-9]+$/',$_POST[quantity]))) {
										if ($_POST[price]>0) {
											if ($_POST[pages]>0) {
												$today=date('Y');
												if (($_POST[year]-$today)<=0) {
													if (file_exists('image/books/'.$_POST[name_book].'.jpg')) {
														$error=false;
														$message='Книга успешно добавлена.';
														$value[ID_Supplier]=$_POST[option_sup];
														$query="INSERT INTO `Books` (`Name_Book`, `Author`, `Year`, `Genres`, `Description`, `Pages`, `Price`, `Quantity`, `ID_Shop`, `ID_Supplier`) VALUES ('$_POST[name_book]', '$_POST[author]', '$_POST[year]', '$_POST[genres]', '$_POST[description]', '$_POST[pages]', '$_POST[price]', '$_POST[quantity]', '1', '$_POST[option_sup]')"; //отправка запроса на выборку книг из БД
														$res=mysqli_query($link, $query) or die(mysqli_error($link));
														echo '<meta http-equiv=Refresh content="1; index.php">';
													}
													else {
														$message='Загрузите фото (если вы уже это сделали, повторно нажмите на кнопку "внести изменения").';
														$error=true;
													}
												}
												else {
													$message='Введите корректный год.';
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
									$message='Книга с таким названием уже добавлена.';
									$error=true;
								}
							}
							else {
								$message='Все поля должны быть заполнены.';
								$error=true;
							}
						}
					?>
					<div class="tovar">
						<form method="POST" enctype="multipart/form-data" style="display: flex;">
							<div>
								<div class="img_book">
									<img src="image/books/<?php echo $_POST[name_book]?>.jpg">
								</div>
								<?php
									$file="image/books/".$_POST[name_book].".jpg"; //в какую папку
									move_uploaded_file($_FILES['photo']['tmp_name'], $file); //название файла (по названию книги, по логину)
									$_FILES['photo']=null;
								?>
								<label for="upload-photo" class="">Загрузить фото:</label>
								<input name="photo" type="file" id="upload-photo" class="">
							</div>
							<div class="right_block" style="width: 100%">
								<div class="book_title">
									<strong>Поставщик: </strong>
									<select class="acc" style="width: 50%; font-size: 15px;" name="option_sup">
										<?php
											$query="SELECT * FROM `Suppliers` ORDER BY `Organization`";
											$res=mysqli_query($link, $query) or die(mysqli_error($link));
											for ($supplier=[]; $row=mysqli_fetch_assoc($res); $supplier[]=$row); //row-из переменной res все данные в массив; book - создали ПУСТОЙ массив; book2 из массива row в массив book
											$res=''; // обнуляем для дальнейшего использования 
											foreach ($supplier as $value) { 
												if ($value[Organization]!='УДАЛЕННЫЙ ПОСТАВЩИК') {
										  			echo '<option value="'.$value[ID_Supplier].'">'.$value[Organization].'</option>';
										  		}
										    }
									  	?>
									</select>
									<h1> <input class="acc" style="width: 100%;" type="text" name="name_book" placeholder="Название" autocomplete="off" value="<?php echo $_POST[name_book] ?>"> </h1>
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
												<input class="acc" style="font-size: 15px; width: 255px;" type="text" name="quantity" placeholder="Кол-во" autocomplete="off" value="<?php echo $_POST[quantity]?>">
											</div>
										</div>
						  			</div>
					  				<div class="desc">
										<textarea class="acc" style="font-size: 15px;" cols="70" rows="21" name="description" placeholder="Описание" autocomplete="off"><?php echo $_POST[description]?></textarea>
									</div>
								</div>
								<div>
									<input type="submit" class="button_reg cto-to edit_but" value="Добавить книгу" name="new_book">
									<input type="submit" class="button_reg cto-to edit_but edit_but_r" value="Отмена" name="not_new_book">
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