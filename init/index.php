<?php
require_once("helpers.php");
require_once ("functions.php");
require_once ("data.php");
require_once ("init.php");
require_once ("models.php");
	
	if (!$connect) {
		$error = mysqli_connect_error();
	} else {
		$sql_query = "SELECT character_code, category_name FROM categories";
		$result = mysqli_query($connect, $sql_query);
	} if ($result) {
	$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
	$error = mysqli_error($connect);
}
	
	$sql_query = qet_query_list_lots('2022-07-15');
	
	$result = mysqli_query($connect, $sql_query);
	if ($result) {
		$goods = mysqli_fetch_all($result, MYSQLI_ASSOC);
	} else {
		$error = mysqli_error($connect);
	}

$page_content = include_template("main.php", [
  "categories" => $categories,
  "goods" => $goods
]);

$layout_content = include_template("layout.php", [
  "content" => $page_content,
  "categories" => $categories,
  "title" => "Главная",
	/**"is_auth" => $is_auth,
	"user_name" => $user_name*/
]);

print($layout_content);