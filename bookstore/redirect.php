<?php 
	require("connection.php");
?>
<?php
// РЕДИРЕКТ НА ТОВАР КОТОРЫЙ БЫЛ ДОБАВЛЕН/УДАЛЁН НА ГЛАВНОЙ СТРАНИЦЕ
	echo '<meta http-equiv=Refresh content="0; index.php#'.$_SESSION[request].'">'; 
?>