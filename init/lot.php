<?php
require_once("helpers.php");
require_once("functions.php");
require_once("init.php");
require_once("data.php");
require_once("models.php");

// подлючаемся к БД, если true, то направляем запрос в БД, возвращает список категорий, асоциативный массив
if(!$connect) {
	$error = mysqli_connect_error();
} else {
	$sql_query = "SELECT character_code, category_name FROM categories";// возвращаем из БД список категорий
	$result = mysqli_query($connect, $sql_query);
}

if($result) { // если запрос вернул результат запроса из БД
	$categories = mysqli_fetch_all($result, MYSQLI_ASSOC); // формируем список категорий в виде ассоциативного массива
} else {
	$error = mysqli_error();
}

/** @var получение и "очистка" значения id лота из GET-параметра $id */
$id = filter_input((INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);//принимает параметр id из GET-запроса(INPUT_GET)

/** если id лота true, то формируем запрос на получение данных о лоте из БД по его id
 *иначе стрница 404
 */
if($id) {//если ID лота присутствует
	$sql = get_query_lot($id);//возвращаем значения лота из БД
} else {
	print($page_404);
	dir();
}

$result = mysqli_query($connect, $sql_query);
if($result) {
	$lot = get_arrow($result);
} else {
	$error = mysqli_error();
}

if(!$lot) {
	print($page_404);
	die();
}

$page_content = include_template("main-lot.php", [
	"categories" => $categories,
	"lot" => $lot
]);

$layout_content = include_template("layout.php", [
	"content" => $page_content,
	"categories" => $categories,
	"title" => $lot['title'],
	"is_auth" => $is_auth,
	"user_name" => $user_name
	]);