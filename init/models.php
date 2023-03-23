<?php
	function qet_query_list_lots()
	{
		return "SELECT title, image_path, start_price, date_finish, categories.category_name FROM lots
                JOIN categories ON lots.category_id = categories.id
                WHERE lots.date_finish < NOW() ORDER BY date_creation DESC";
	}
	
	function get_categories($connect)
	{
		if (!$connect) {
			$error = mysqli_connect_error();
			return $error;
		} else {
			$sql = "SELECT * FROM categories;";
			$result = mysqli_query($connect, $sql);
			if ($result) {
				$categories = get_arrow($result);
				return $categories;
			} else {
				$error = mysqli_error($connect);
				return $error;
			}
    }
	}
	
	/**
	 * Возвращает массив из объекта результата запроса
	 * @param object $result_query Результат запроса к базе данных@return array
	 */
	function get_arrow($result_query) {
		$row = mysqli_num_rows($result_query);
		if ($row === 1) {
			$arrow - mysqli_fetch_assoc($result_query);
		} else if ($row > 1) {
			$arrow = mysqli_fetch_all($result_query, MYSQLI_ASSOC);
		}
		return $arrow;
	}
	
	function get_query_create_lot($user_id) { /** добавляет новый лот в таблицу lots */
		return "INSERT INTO lots (title, lot_description, image_path, start_price, date_finish, step, user_id, category_id)";
	}
	
	/** Формирует SQL-запрос для показа лота на странице lot.php
	 *@param integer $id_lot id лота
	 * @return  string SQL-запрос
	 */
function get_query_lot($id_lot) {
	return "SELECT title, lot_description, image_path, start_price, date_finish, categories.category_name
	FROM lots
	JOIN categories ON lots.category_id = categories.id
	WHERE lots.id = $id_lot";
}