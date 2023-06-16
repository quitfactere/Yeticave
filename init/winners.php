<?php

require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");

/**
 * Находит все лоты без победителей, дата истечения которых меньше или равна текущей дате.
 */

function get_no_winners($con) {
	if(!$con) {
		$error = mysqli_connect_error();
		return $error;
	} else {
		$sql = "SELECT id, title, date_finish, winner_id FROM lots WHERE DATE(date_finish) <= DATE(NOW()) AND winner_id IS NULL;";
		$result = mysqli_query($con, $sql);
		if($result) {
			$winners = get_arrow($result);
			return $winners;
		} else {
			$error = mysqli_error($con);
			return $error;
		}
	}
}

$without_winners = get_no_winners($con);

/** попробовать сделать через MAX
 * Получает последнюю ставку
 */
function get_last_bets($con, $id_lot) {
	if(!$con) {
		$error = mysqli_connect_error();
		return $error;
	} else {
		$sql = "SELECT users.user_name, users.email, bets.price_bet, DATE_FORMAT(bets.bet_date, '%d.%m.%y %H:%i') AS bet_date, 
       bets.user_id
        FROM bets
        JOIN lots ON bets.lot_id = lots.id
        JOIN users ON bets.user_id = users.id
        WHERE lots.id = $id_lot
        ORDER BY bets.bet_date DESC LIMIT 1;";
		$result = mysqli_query($con, $sql);
		if($result) {
			$last_bets = get_arrow($result);
			return $last_bets;
		}
		$error = mysqli_error($con);
		return $error;
	}
}

function save_winner_id($con, $user_id, $lot_id) {
	if(!$con) {
		$error = mysqli_connect_error();
		return $error;
	} else {
		$sql = "UPDATE lots SET winner_id = '$user_id' WHERE id = '$lot_id'";
		$result = mysqli_query($con, $sql);
		return $result;
	}
}

if(isset($without_winners["id"])) {
	$last_bet = get_last_bets($con, $without_winners["id"]);// для единственного лота без победителя, находит последнюю ставку

	$send_winner_id = save_winner_id($con, $last_bet['user_id'], $without_winners["id"]);
} elseif(isset($without_winners) && count($without_winners) > 1) {
	foreach($without_winners as $key => $value) {
		$last_bet = get_last_bets($con, $value["id"]);// для каждого лота без победителя, находит последнюю ставку
		$send_winner_id = save_winner_id($con, $last_bet['user_id'], $value["id"]);
	}
}

?>


