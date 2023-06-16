<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");

$categories = get_categories($con);//получаем список категорий

$nav = include_template("nav.php", [
    "categories" => $categories
]);

if($_SERVER['REQUEST_METHOD'] === 'GET') {//если метод для запроса страницы GET
	$search_request = trim(filter_input(INPUT_GET, "search", //Получаем значение из строки поиска
		FILTER_SANITIZE_FULL_SPECIAL_CHARS), " ");
	$errors = [];

	if($search_request) {
		$items_count = get_count_lots($con, $search_request);//получает кол-во найденных лотов
		$cur_page = $_GET["page"] ?? 1;//Если $_GET["page"] существует, то $cur_page = $_GET["page"], иначе $cur_page = 1
		$page_items = 3;//количество лотов на странице
		$offset = ($cur_page - 1) * $page_items;//смещение по массиву найденных лотов
		$page_count = ceil($items_count / $page_items);//вычисляет кол-во страниц
		$pages = range(1, $page_count);//создаём массив страниц от 1 до последней
	}

	$lots = get_found_lots($con, $search_request, $page_items, $offset); // получаем массив с информацией о найденных лотах

	if(!isset($lots)) {
		$errors["search"] = "Ничего не найдено по вашему запросу";
	}

	$page_content = include_template("main-search.php", [
		"categories" => $categories,
		"search_request" => $search_request,
		"lots" => $lots,
		"errors" => $errors,
		"pages" => $pages,
		"page_count" => $page_count,
		"cur_page" => $cur_page
	]);

	$layout_content = include_template("layout.php", [
		"content" => $page_content,
		"categories" => $categories,
        "nav" => $nav,
		"lots" => $lots,
		"is_auth" => $is_auth,
		"user_name" => $user_name,
		"errors" => $errors
	]);
}

print($layout_content);