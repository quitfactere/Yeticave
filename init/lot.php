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

$nav = include_template("nav.php", [
	"categories" => $categories
]);
$layout_content = include_template("layout.php", [
	"content" => $page_404,
	"categories" => $categories,
	"title" => "Страница не найдена",
	"is_auth" => $is_auth,
	"user_name" => $user_name
]);
/** @var получение и "очистка" значения id лота из GET-параметра $id */
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);//получает значение id из GET-запроса, фильтрует

/** если id лота true, то формируем запрос на получение данных о лоте из БД по его id
 *иначе страница 404
 */
if($id) {//если ID лота присутствует
	$sql = get_query_lot($id);//возвращаем информацию о лоте по его id из БД
} else {
	print($layout_content);
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

if(isset($lot["start_price"])) {
	$start_bet = $lot["start_price"];
}

$date = date_create("now");
$date_now = date_format($date, "Y-m-d H:i:s");

$history = get_bets_history($con, $id);// выбирает из БД

if(count($history) <= 0) {
	$page_content = include_template("main-lot.php", [
		"categories" => $categories,
		"nav" => $nav,
		"lot" => $lot,
		"is_auth" => $is_auth,
		"user_name" => $user_name,
		"id" => $id,
		"history" => $history,
		"date_now" => $date_now
	]);
} else {
	$current_price = max($lot["start_price"], $history[0]["price_bet"]);//выбирает максимальное из двух значений, второй - максимальная ставка (из последних десяти)
	$min_bet = $current_price + $lot["step"];

	$nav = include_template("nav.php", [
		"categories" => $categories
	]);

	$page_content = include_template("main-lot.php", [
		"categories" => $categories,
		"nav" => $nav,
		"lot" => $lot,
		"is_auth" => $is_auth,
		"user_name" => $user_name,
		"current_price" => $current_price,
		"min_bet" => $min_bet,
		"id" => $id,
		"history" => $history,
		"date_now" => $date_now
	]);
}
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$bet = filter_input(INPUT_POST, "cost", FILTER_VALIDATE_INT);// 1
	if($bet < $min_bet) {
		$error = "Ставка не может быть меньше $min_bet";
	}
	if(empty($bet)) {
		$error = "Ставка должна быть целым числом, больше нуля";
	}

	if(isset($error)) {
		$page_content = include_template("main-lot.php", [
			"categories" => $categories,
			"nav" => $nav,
			"lot" => $lot,
			"is_auth" => $is_auth,
			"user_name" => $user_name,
			"current_price" => $current_price,
			"min_bet" => $min_bet,
			"error" => $error,
			"id" => $id,
			"history" => $history,
			"date_now" => $date_now
		]);
	} else {
		$result = add_bet_database($con, $bet, $_SESSION["id"], $id);
		header("Location: lot.php?id=" . $id);
	}
}

$layout_content = include_template("layout.php", [
	"content" => $page_content,
	"categories" => $categories,
	"lot" => $lot,
	"title" => $lot["title"],
	"nav" => $nav,
	"is_auth" => $is_auth,
	"user_name" => $user_name
]);

print($layout_content);