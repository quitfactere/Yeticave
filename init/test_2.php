<?php
require_once ("helpers.php");
require_once ("functions.php");
require_once ("data.php");
require_once ("init.php");
require_once ("models.php");

// подлючаемся к БД, если true, то направляем запрос в БД, возвращает список лотов, асоциативный массив
if(!$connect) {
	$error = mysqli_connect_error();
} else {
	$sql_query = "SELECT id, title, date_finish FROM lots";// возвращаем из БД лоты
	$result = mysqli_query($connect, $sql_query, MYSQLI_STORE_RESULT);
	if ($result) { // если запрос вернул результат запроса из БД
		$lots = mysqli_fetch_all($result, MYSQLI_ASSOC); // формируем список категорий в виде ассоциативного массива
	} else {
		$error = mysqli_error($connect);
	}
}

$date = $lots[0]['date_finish'];

$get_hours = get_time_left($date);
var_dump($get_hours[0]);

