<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");

$categories = get_categories($con);//получаем список категорий

if($_SERVER['REQUEST_METHOD'] === 'GET') {//если метод для запроса страницы POST
	$search_request = trim(filter_input(INPUT_GET, "search", //Получаем значение из строки поиска
		FILTER_SANITIZE_FULL_SPECIAL_CHARS), " ");
	$sql = "SELECT * FROM lots 
	JOIN categories ON lots.category_id = categories.id
	WHERE match (title, lot_description) AGAINST('$search_request')";
	$lots_name_desc = get_lots_name_desc($con, $sql); // получаем массив с наименованиями и описание лотов

	var_dump($search_request);

	$page_content = include_template("main-search-result.php", [
		"categories" => $categories,
		"lots_name_desc" => $lots_name_desc,
		"search_request" => $search_request
	]);

	$layout_content = include_template("layout.php", [
		"content" => $page_content,
		"categories" => $categories,
		"is_auth" => $is_auth,
		"user_name" => $user_name
	]);
}

print($layout_content);