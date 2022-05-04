<?php 
	require("connection.php");
?>
<?php
// РЕДИРЕКТ НА СТРАНИЦУ ПРИ УДАЛЕНИИ В ИЗБРАННОМ
	echo '<meta http-equiv=Refresh content="0; favorite.php#'.$_SESSION[request].'">'; 
?>