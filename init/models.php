<?php
/**
 * Формирует SQL-запрос для получения списка новых лотов от определенной даты, с сортировкой
 * @param string $date Дата в виде строки, в формате 'YYYY-MM-DD'
 * @return string SQL-запрос
 */
function qet_query_list_lots($date)
{
	return "SELECT lots.id, lots.title, lots.image_path, lots.start_price, lots.date_finish, categories.category_name FROM lots
                JOIN categories ON lots.category_id = categories.id
                WHERE date_creation > $date ORDER BY date_creation DESC";
}

function get_query_lot($id_lot)
{
	return "SELECT title, lot_description, image_path, start_price, date_finish, categories.category_name
	FROM lots
	JOIN categories ON lots.category_id = categories.id
	WHERE lots.id = $id_lot";
}