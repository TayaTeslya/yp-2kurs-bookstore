<?php
session_start();
$servername = "localhost";
$database = "bookstore";	//название бд
$username = "taya";
$password = "1357908642Av!";
// Создаем соединение
$link = mysqli_connect($servername, $username, $password, $database);
// Проверяем соединение
?>
