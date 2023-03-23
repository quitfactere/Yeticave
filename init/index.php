<?php
require_once("helpers.php");
require_once ("functions.php");
require_once ("init.php");
require_once ("data.php");
require_once ("models.php");
	
	if (!$connect) {
		$error = mysqli_connect_error();
	} else {
		$sql_query = "SELECT character_code, category_name FROM categories";
		$result = mysqli_query($connect, $sql_query);
	} if ($result) {
	$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
	$error = mysqli_error();
}

	$sql_query = qet_query_list_lots();
	
	$result = mysqli_query($connect, $sql_query);
	if ($result) {
		$goods = mysqli_fetch_all($result, MYSQLI_ASSOC);
	} else {
		$error = mysqli_error();
	}

/** @var получаем  $categories */
$categories = get_categories($connect);

$page_404 = include_template("404.php", [
	"categories" => $categories
]);

$page_content = include_template("main.php", [
  "categories" => $categories,
  "goods" => $goods
]);

$layout_content = include_template("layout.php", [
  "content" => $page_content,
  "categories" => $categories,
  "title" => "Главная"
]);

print($layout_content);