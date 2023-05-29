<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");

$categories = get_categories($con);//получаем список категорий

if($_SERVER['REQUEST_METHOD'] === 'GET') {//если метод для запроса страницы GET
	$search_request = trim(filter_input(INPUT_GET, "search", //Получаем значение из строки поиска
		FILTER_SANITIZE_FULL_SPECIAL_CHARS), " ");
	$errors = [];

	$lots_name_desc = get_found_lots($con, $search_request); // получаем массив с информацией о найденных лотах

	if(!isset($lots_name_desc)) {
		$errors["search"] = "Ничего не найдено по вашему запросу";
	}

	$limit = 3;//количество лотов на странице
	$offset = 3;//смещение по массиву найденных лотов
	$cur_page = $_GET["page"] ?? 1; //Если $_GET["page"] существует, то $cur_page = $_GET["page"], иначе $cur_page = 1

	$page_content = include_template("main-search.php", [
		"categories" => $categories,
		"lots_name_desc" => $lots_name_desc,
		"search_request" => $search_request,
		"errors" => $errors
	]);

	$layout_content = include_template("layout.php", [
		"content" => $page_content,
		"categories" => $categories,
		"lots_name_desc" => $lots_name_desc,
		"is_auth" => $is_auth,
		"user_name" => $user_name,
		"errors" => $errors
	]);
}

print($layout_content);