<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");

$categories = get_categories($con);

$page_404 = include_template("main-404.php", [
  "categories" => $categories
]);

/** @var получение и "очистка" значения id лота из GET-параметра $id */
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);//получает значение id из GET-запроса, фильтрует

/** если id лота true, то формируем запрос на получение данных о лоте из БД по его id
 *иначе страница 404
 */
if($id) {//если ID лота присутствует
  $sql = get_query_lot($id);//возвращаем информацию о лоте по его id из БД
} else {
  print($page_404);
  die();
}

$result = mysqli_query($con, $sql); //получает из БД информацию о лоте

if($result) {
	$lot = get_arrow($result); // получает массив из объекта результата
} else {
	$error = mysqli_error($con);
}

if(!isset($lot)) {
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
	"title" => $lot["title"],
  "is_auth" => $is_auth,
  "user_name" => $user_name
	]);

print($layout_content);