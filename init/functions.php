<?php if (!function_exists('price_format')) {
  function price_format($price)
  {
    $price_ceil = ceil($price);
    if ($price_ceil > 1000) {
      $price_ceil = number_format($price_ceil, 0, ".", " ") . " ";
    }
    return htmlspecialchars($price_ceil);
  }
}

?>


<?php /*if (!function_exists('price_format_substr')) {
                    function price_format_substr($price)
                    {
                      $price_ceil = ceil($price);
                      if ($price_ceil > 1000) {
                        $price_part_1 = substr($price_ceil, 0, -3);
                        $price_part_2 = substr($price_ceil, -3, 3);
                      }
                      return $price_ceil = $price_part_1 . ' ' . $price_part_2;
                      }
                    }
                  */?>

<?php
  function get_time_left($date)
  {
    date_default_timezone_set('Europe/Moscow');
    $final_date = date_create($date); // 1. создаем конечную дату
    $cur_date = date_create("now"); // 2. создаём текущую дату
    $diff = date_diff($final_date, $cur_date); // 3. разница между конечной датой и текущей
    $format_diff = date_interval_format($diff, "%d %H %I"); // 4. создаём формат вывода даты
    $arr = explode(" ", $format_diff); // 5. создаём массив из строк, разделённых разделителем "пробел"

    $hours = $arr[0] * 24 + $arr[1];
    $minutes = intval($arr[2]);
    $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);// дополняет строку $hours нулями, до двух символов, слева
    $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);
    $res[] = $hours;
    $res[] = $minutes;

    return $res;
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
function get_arrow($result_query)
{
  $row = mysqli_num_rows($result_query);
  if ($row === 1) {
    $arrow - mysqli_fetch_assoc($result_query);
  } else if ($row > 1) {
    $arrow = mysqli_fetch_all($result_query, MYSQLI_ASSOC);
  }
  return $arrow;
}

function get_query_create_lot($user_id)
{
  /** добавляет новый лот в таблицу lots */
  return "INSERT INTO lots (title, lot_description, image_path, start_price, date_finish, step, user_id, category_id)";
}

/** Формирует SQL-запрос для показа лота на странице lot.php
 * @param integer $id_lot id лота
 * @return  string SQL-запрос
 */

  ?>

