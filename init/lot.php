<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");

// подлючаемся к БД, если true, то направляем запрос в БД, возвращает список лотов, асоциативный массив
if(!$connect) {
	$error = mysqli_connect_error();
} else {
	$sql_query = "SELECT character_code, category_name FROM categories";// возвращаем из БД лоты
	$result = mysqli_query($connect, $sql_query, MYSQLI_STORE_RESULT);
	if ($result) { // если запрос вернул результат запроса из БД
		$categories = mysqli_fetch_all($result, MYSQLI_ASSOC); // формируем список категорий в виде ассоциативного массива
	} else {
		$error = mysqli_error($connect);
	}
}

/** @var получение и "очистка" значения id лота из GET-параметра $id */
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$page_404 = include_template("404.php", [
	"categories" => $categories
]);

/** если id лота true, то формируем запрос на получение данных о лоте из БД по его id
 *иначе стрница 404
 */
if($id) {//если ID лота присутствует
	$sql_query = get_query_lot($id);//возвращаем информацию о лоте по его id из БД
} else {
	print($page_404);
	die();
}

$result = mysqli_query($connect, $sql_query);
if($result) {
	$lot = mysqli_fetch_assoc($result);
} else {
	$error = mysqli_error($connect);
}

if(!$lot) {
	print($page_404);
	die();
}

$page_content = include_template("main-lot.php", [
	"categories" => $categories,
	"lot" => $lot
]);

$layout_content = include_template("layout-lot.php", [
	"content" => $page_content,
	"categories" => $categories,
	"title" => $lot["title"]
	]);

print($layout_content);