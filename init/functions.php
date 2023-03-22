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
?>