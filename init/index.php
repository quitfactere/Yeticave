<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");

if(!$con) { //если подключение не состоялось
	$error = mysqli_connect_error();
} else {//если подключение произошло успешно
	$sql = "SELECT character_code, category_name FROM categories";//запрос к БД на получение списка категорий
	$result = mysqli_query($con, $sql, MYSQLI_STORE_RESULT);//результат запроса записывается в переменную в виде буфер
}
if($result) {//если результат возвращает данные из БД
	$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);//формируется массив со списком категорий
} else {
	$error = mysqli_error($con);
}

$sql = qet_query_list_lots("\"2023-02-20 00:00:00\"");
//$sql_query = "SELECT id, title FROM lots WHERE date_creation > \"2023-03-23 00:00:00\"";
$result = mysqli_query($con, $sql);

if($result) {
	$goods = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
	$error = mysqli_error($con);
}


$page_content = include_template("main.php", [
	"categories" => $categories,
	"goods" => $goods
]);

$layout_content = include_template("layout.php", [
	"content" => $page_content,
	"categories" => $categories,
	"title" => "Главная",
	"is_auth" => $is_auth,
  "user_name" => $user_name
]);

print($layout_content);