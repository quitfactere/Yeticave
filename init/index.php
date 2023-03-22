<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
ini_set('error_log', __DIR__ . '/php-errors.log');
require_once("helpers.php");
require_once ("functions.php");
require_once ("init.php");
require_once ("data.php");
require_once ("models.php");

$categories = get_categories($connect);

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