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