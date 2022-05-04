<?php 
	require("connection.php");
?>
<?php
// РЕДИРЕКТ НА ТОВАР КОТОРЫЙ БЫЛ ПОДТВЕРЖДЕН НА СТРАНИЦЕ ЗАКАЗОВ
	echo '<meta http-equiv=Refresh content="0; orders.php#'.$_SESSION[id_order_request].'">'; 
?>