<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
ini_set('error_log', __DIR__ . '/php-errors.log');

require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");
require_once("winners.php");

if(!$con) { //если подключение не состоялось
	$error = mysqli_connect_error(); //возвращает сообщение об ошибки поледней попытки подключения
} else {//если подключение произошло успешно
	$sql = "SELECT character_code, category_name FROM categories";//запрос к БД на получение списка категорий
	$result = mysqli_query($con, $sql, MYSQLI_STORE_RESULT);//результат запроса записывается в переменную в виде буфер
}
if($result) {//если результат возвращает данные из БД
	$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);//формируется массив со списком категорий
} else {
	$error = mysqli_error($con); // возвращает сообщение об ошибке последнего вызова функции MySQLi, который может успешно выполниться или провалиться
}

$nav = include_template("nav.php", [
    "categories" => $categories
]);

$date = date_create("now");
$date_now = date_format($date, "Y-m-d");

$sql = qet_query_list_lots("\"$date_now\""); // формирует запрос на получение спискановых лотов, с сортировкой, после указанной даты
$result = mysqli_query($con, $sql); //результат запроса (подключение, выполнение запроса в БД)

if($result) {//если результат запроса истина, т.е. состоялся
	$lots = mysqli_fetch_all($result, MYSQLI_ASSOC); //выбирает все сроки из $result, возвращает ассоциативный массив
} else {
	$error = mysqli_error($con);
}

$page_content = include_template("main.php", [//подключает шаблон main.php, передаёт туда данные "categories", "goods" - переменные из массива
	"categories" => $categories,
	"lots" => $lots
]);

$layout_content = include_template("layout.php", [
	"content" => $page_content,
	"categories" => $categories,
    "nav" => $nav,
	"title" => "Главная",
	"is_auth" => $is_auth,
  "user_name" => $user_name
]);



print($layout_content);