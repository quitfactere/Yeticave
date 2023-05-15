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

$layout_content = include_template("layout.php", [
	"content" => $page_404,
	"categories" => $categories,
	"title" => "Главная",
	"is_auth" => $is_auth,
  "user_name" => $user_name
]);

print($layout_content);