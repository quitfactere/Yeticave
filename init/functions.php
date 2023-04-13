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


<?php if (!function_exists('price_format_substr')) {
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
?>

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
  //$hours = str_pad($hours, 2, "0", STR_PAD_LEFT);// дополняет строку $hours нулями, до двух символов, слева
  $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);
  $res[] = $hours;
  $res[] = $minutes;

  return $res;
}

/**
 * Возвращает массив из объекта результата запроса
 * @param object $result_query mysqli Результат запроса к базе данных
 * @return array
 */
function get_arrow($result_query)
{
  $row = mysqli_num_rows($result_query);//получаем количество сток в наборе результатов
  if ($row === 1) {
    $arrow = mysqli_fetch_assoc($result_query);//Выбирает одну строку данных из набора результатов и возвращает её в виде ассоциативного массива
  } else if ($row > 1) {
    $arrow = mysqli_fetch_all($result_query, MYSQLI_ASSOC);
  }

  return $arrow;
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

/** Вспомигогательная функция для получения значений из POST-запроса */
function getPostVal($name) {
  return $_POST[$name] ?? "";
}

function get_query_create_lot($user_id): string
{
  /** добавляет новый лот в таблицу lots */
  return "INSERT INTO lots (title, category_id, lot_description, start_price, step, date_finish, image_path, user_id ) VALUES (?, ?, ?, ?, ?, ?, ?, $user_id)";
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return stmt Подготовленное выражение
 */
function db_get_prepare_stmt_version($link, $sql, $data = []) {
  $stmt = mysqli_prepare($link, $sql);

  if ($stmt === false) {
    $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
    die($errorMsg);
  }

  if ($data) {
    $types = '';
    $stmt_data = [];

    foreach ($data as $key => $value) {
      $type = 's';

      if (is_int($value)) {
        $type = 'i';
      }
      else if (is_double($value)) {
        $type = 'd';
      }

      if ($type) {
        $types .= $type;
        $stmt_data[] = $value;
      }
    }

    $values = array_merge([$stmt, $types], $stmt_data);
    mysqli_stmt_bind_param(...$values);

    if (mysqli_errno($link) > 0) {
      $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
      die($errorMsg);
    }
  }

  return $stmt;
}

/**
 * Валидирует поле категории, если такой категории нет в списке
 * возвращает сообщение об этом
 * @param int $id категория, которую ввел пользователь в форму
 * @param array @allowed_list список существующих категорий
 * @return string Текст сообщения об ошибке
 */
function validate_category($id, $allowed_list)
{
  if (!in_array($id, $allowed_list)) {
    return "Указана несуществующая категория";
  }
}

function validate_number($num)
{ //проверка на то, что пользователь ввел число больше нуля
  if (!empty($num)) { //если значение поля (числа) не пустое
    $num *= 1;
    if (is_int($num) && $num > 0) { //если введённое значение - число И больше нуля
      return NULL;
    }
    return "Содержимое поля должно быть целым числом больше нуля";
  }
}

/**
 * проверяет, что дата окончания торгов не меньше одного дня
 * @param string $date дата, которую ввёл пльзователь в форму
 * @return string текст сообщения об ошибке
 */
function validate_date($date)
{
  if (is_date_valid($date)) {
    $now = date_create("now");
    $d = date_create($date);
    $diff = date_diff($d, $now);
    $interval = date_interval_format($diff, "%d");

    if ($interval < 1) {
      return "Дата окончания лота должна быть больше текущей не менее, чем на один день";
    };
  } else {
    return "Содержимое поля \"Дата окончания торгов\" должно быть датой в формате \"ГГГГ-ММ-ДД\"";
  }
}

?>

