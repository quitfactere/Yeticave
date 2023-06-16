<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");

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

foreach($categories as $category) {
	if(isset($_GET["category"]) && $_GET["category"] == $category["character_code"]) {
		$errors = [];
		$cur_page = $_GET["page"] ?? 1;//Если $_GET["page"] существует, то $cur_page = $_GET["page"], иначе $cur_page = 1
		$page_items = 3;//количество лотов на странице
		$offset = ($cur_page - 1) * $page_items;//смещение по массиву найденных лотов
		$lots_of_cat = qet_query_lots_cat($con, $category["character_code"], $page_items, $offset); // формирует запрос на получение спискановых лотов, с сортировкой, после указанной даты

		$items_count = get_count_lots_cat($con, $category["character_code"]);//получает кол-во найденных лотов
		$page_count = ceil($items_count / $page_items);//вычисляет кол-во страниц
		$pages = range(1, $page_count);//создаём массив страниц от 1 до последней

		if(!isset($lots_of_cat)) {
			$errors["character_code"] = "Нет лотов в данной категории";
		}

		$page_content = include_template("main-lots-of-cat.php", [//подключает шаблон main.php, передаёт туда данные "categories", "goods" - переменные из массива
			"categories" => $categories,
			"category" => $category,
			"lots_of_cat" => $lots_of_cat,
			"page_count" => $page_count,
			"cur_page" => $cur_page,
			"pages" => $pages,
			"errors" => $errors
		]);

		$layout_content = include_template("layout.php", [
			"content" => $page_content,
			"categories" => $categories,
			"nav" => $nav,
			"title" => "Главная",
			"is_auth" => $is_auth,
			"user_name" => $user_name,
			"errors" => $errors
		]);
	}
}

print($layout_content);