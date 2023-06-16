<?php
/**
 * Формирует SQL-запрос для получения списка новых лотов от определенной даты, с сортировкой
 * @param string $date Дата в виде строки, в формате 'YYYY-MM-DD'
 * @return string SQL-запрос
 */
function qet_query_list_lots($date) {
	return "SELECT lots.id, lots.title, lots.image_path, lots.start_price, lots.date_finish, categories.category_name FROM lots
                JOIN categories ON lots.category_id = categories.id
                WHERE lots.date_finish > $date ORDER BY date_creation DESC";
}

/**
 * Формирует SQL-запрос для показа лота на странице lot.php
 * @param integer $id_lot id лота
 * @return string SQL-запрос
 */
function get_query_lot($id_lot) {
	return "SELECT lots.title, lots.lot_description, lots.image_path, lots.start_price, lots.date_finish, lots.step, users.user_name, categories.category_name 
	FROM lots
	JOIN categories ON lots.category_id = categories.id
  JOIN users ON lots.user_id = users.id 
	WHERE lots.id = $id_lot";
}

/**
 * Формирует SQL-запрос для создания нового лота
 * @param integer $user_id id пользователя
 * @return string SQL-запрос
 */
function get_query_create_lot($user_id): string {
	/** добавляет новый лот в таблицу lots */
	return "INSERT INTO lots (title, category_id, lot_description, start_price, step, date_finish, image_path, user_id) 
	VALUES (?, ?, ?, ?, ?, ?, ?, $user_id)";
}

/**
 * Возвращает массив категорий
 * @param $con Подключение к MySQL
 * @return [Array | String] $categuries Ассоциативный массив с категориями лотов из базы данных
 * или описание последней ошибки подключения
 */
function get_categories($con) {
	if(!$con) {
		$error = mysqli_connect_error();
		return $error;
	} else {
		$sql = "SELECT * FROM categories;";
		$result = mysqli_query($con, $sql);
		if($result) {
			$categories = get_arrow($result);
			return $categories;
		} else {
			$error = mysqli_error($connect);
			return $error;
		}
	}
}

/**
 * Возвращает массив данных пользователей: адресс электронной почты и имя
 * @param $con Подключение к MySQL
 * @return [Array | String] $users_data Двумерный массив с именами и емейлами пользователей
 * или описание последней ошибки подключения
 */

function get_users_data($con) {
	if(!$con) {
		$error = mysqli_connect_error();
		return $error;
	} else {
		$sql = "SELECT email, user_name FROM users";
		$result = mysqli_query($con, $sql); //запрос к БД, возвращает результирующий  набор
		if($result) { // если запрос к БД, вернул истинный результат, т.е. данные
			$users_data = get_arrow($result); //возвращает ассоциативный массив, либо 1 строка, либо несколько
			return $users_data;
		}
		$error = mysqli_error($con);
		return $error;
	}
}

/** Формирует SQL-запрос для регистрации нового пользователя
 * @param integer $user_id id пользователя
 * @return string SQL-запрос
 */
function get_query_create_user() {
	return "INSERT INTO users (user_date_registration, email, user_name, user_password, contacts) VALUES (NOW(), ?, ?, ?, ?)";
}

/**
 *
 */

function get_login($con, $email) {
	if(!$con) {
		$error = mysqli_connect_error();
		return $error;
	} else {
		$sql = "SELECT id, email, user_password, user_name FROM users WHERE email = '$email'";
		$result = mysqli_query($con, $sql); //запрос к БД, возвращает результирующий  набор
		if($result) { // если запрос к БД, вернул истинный результат, т.е. данные
			$users_data = get_arrow($result); //возвращает ассоциативный массив, либо 1 строка, либо несколько
			return $users_data;
		}
		$error = mysqli_error($con);
		return $error;
	}
}

/** Получение наименования и описания всех лотов
 */

function get_found_lots($con, $search_request, $limit, $offset) {
	$sql = "SELECT lots.id, lots.title, lots.lot_description, lots.image_path, lots.start_price, lots.date_finish, categories.category_name 
	FROM lots	JOIN categories ON lots.category_id = categories.id
	WHERE match (title, lot_description) AGAINST(?) ORDER BY date_creation DESC LIMIT $limit OFFSET $offset;";

	$stmt = mysqli_prepare($con, $sql);
	mysqli_stmt_bind_param($stmt, 's', $search_request);//в stmt на место ? подставляет $search_request
	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);
	if($result) { // если запрос к БД, вернул истинный результат, т.е. данные
		$lots_name_desc = get_arrow($result); //возвращает ассоциативный массив, либо 1 строка, либо несколько
		return $lots_name_desc;
	}
	$error = mysqli_error($con);
	return $error;
}

function qet_query_lots_cat($con, $character_code, $limit, $offset) {
	$sql = "SELECT lots.id, lots.title, lots.lot_description, lots.image_path, lots.start_price, lots.date_finish, categories.category_name 
	FROM lots JOIN categories ON lots.category_id = categories.id
	WHERE categories.character_code = \"$character_code\" ORDER BY lots.date_creation DESC LIMIT $limit OFFSET $offset;";

	$result = mysqli_query($con, $sql);
	if($result) { // если запрос к БД, вернул истинный результат, т.е. данные
		$lots_of_cat = get_arrow($result); //возвращает ассоциативный массив, либо 1 строка, либо несколько
		return $lots_of_cat;
	}
	$error = mysqli_error($con);
	return $error;
}



/**
 * функция подсчитывает количество найденных лотов, в соответствии с поисковым запросом
 * @param $con
 * @param $search_request - поисковый запрос
 * @return mixed|string
 */
function get_count_lots($con, $search_request) {
	//выбирает и считает количество лотов, которые совпадают с поисковым запросом
	$sql = "SELECT COUNT(*) as cnt FROM lots 
	WHERE match (title, lot_description) AGAINST(?);";

	$stmt = mysqli_prepare($con, $sql);// подготавливает выражение $sql и возвращает указатель на это выражение
	mysqli_stmt_bind_param($stmt, 's', $search_request);//в stmt на место ? подставляет $search_request, тип string
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);//получает результат из выполнения подготовленного выражения
	if ($result) {
		$count = mysqli_fetch_assoc($result)["cnt"];
		return $count;
	}
	$error = mysqli_error($con);
	return $error;
}

/** выбирает и считает количество лотов, которые совпадают с поисковым запросом
 * @param $con
 * @param $character_code
 * @return mixed|string
 */
function get_count_lots_cat($con, $character_code) {
	$sql = "SELECT COUNT(*) as cnt FROM lots 
	JOIN categories ON lots.category_id = categories.id
	WHERE categories.character_code = \"$character_code\";";

	$result = mysqli_query($con, $sql);
	if ($result) {
		$count = mysqli_fetch_assoc($result)["cnt"];
		return $count;
	}
	$error = mysqli_error($con);
	return $error;
}

/**
 * Записывает в БД сделанную ставку
 * @param $con ресурс соединения
 * @param $sum сумма ставки
 * @param $user_id id пользователя
 * @param $lot_id id лота
 * @return bool $result возвращает true в случае успешной записи
 */
function add_bet_database($con, $sum, $user_id, $lot_id) {
    $sql = "INSERT INTO bets (bet_date, price_bet, user_id, lot_id) VALUE (NOW(), ?, $user_id, $lot_id)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $sum);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        return $result;
    }
    $error = mysqli_error($con);
    return $error;
}

/**
 * Возвращает массив десяти последних ставок для данного лота
 * @param $con подключние к БД
 * @param $id_lot id данного лота
 * @return array|string|null возвращаемый ассоциативный массив ставок
 */
function get_bets_history($con, $id_lot) {
    if (!$con) {
        $error = mysqli_connect_error();
        return $error;
    } else {
        $sql = "SELECT users.user_name, bets.price_bet, DATE_FORMAT(bets.bet_date, '%d.%m.%y %H:%i') AS bet_date, bets.user_id
        FROM bets
        JOIN lots ON bets.lot_id = lots.id
        JOIN users ON bets.user_id = users.id
        WHERE lots.id = $id_lot
        ORDER BY bets.bet_date DESC LIMIT 10;";
        $result = mysqli_query($con, $sql);
        if ($result) {
            $list_bets = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $list_bets;
        }
        $error = mysqli_error($con);
        return $error;
    }
}

/** Возвращает список ставок для конкретного пользователя
 * @param $con Ресурс подключения
 * @param $user_id ID пользователя
 * @return array|string
 */
function get_bets($con, $user_id) {
	$sql = "SELECT bets.bet_date, bets.price_bet, lots.title, lots.image_path, 
       		lots.category_id, lots.user_id, lots.date_finish, lots.id, categories.category_name FROM bets
					JOIN lots ON bets.lot_id = lots.id
					JOIN users ON bets.user_id = users.id
					JOIN categories ON categories.id = lots.category_id
					WHERE bets.user_id = $user_id
					ORDER BY bets.bet_date DESC";
	$result = mysqli_query($con, $sql);
	if($result) {
		$list_bets = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $list_bets;
	} else {
		$error = mysqli_error($con);
		return $error;
	}
}
