<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");

$categories = get_categories($con);

$nav = include_template("nav.php", [
	"categories" => $categories
]);

if($_SESSION["id"]) {
	$bets = get_bets($con, $_SESSION["id"]);
}

$date = date_create("now");//дата сейчас
$total_minutes = [];

foreach($bets as $bet) {
	$date_bet = date_create($bet["bet_date"]);
	$diff = date_diff($date, $date_bet);
	$format_diff = date_interval_format($diff, "%D:%H:%I:%S");
	$arr = explode(":", $format_diff);
	$hours = (int)$arr[0] * 24 + (int)$arr[1];
	$minutes = intval($arr[2]);
	$total_minutes[] = $hours * 60 + $minutes;
}

foreach($total_minutes as $minutes => $value) {
	$minutes_ago = get_noun_plural_form($minutes, "минута", "минуты", "минут");
}

$page_content = include_template("main-my-bets.php", [//подключает шаблон main.php, передаёт туда данные "categories", "goods" - переменные из массива
	"categories" => $categories,
	"bets" => $bets,
	"total_minutes" => $total_minutes,
	"minutes_ago" => $minutes_ago
]);

$layout_content = include_template("layout.php", [
	"content" => $page_content,
	"categories" => $categories,
	"nav" => $nav,
	"bets" => $bets,
	"title" => "Мои ставки",
	"is_auth" => $is_auth,
	"user_name" => $user_name
]);

print($layout_content);