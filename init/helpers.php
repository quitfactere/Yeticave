<?php
/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date) : bool {
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) { //data - массив значений формы из POST-запроса
    $stmt = mysqli_prepare($link, $sql);//возвращает объект запроса или false

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {//если есть переданные данные (значения POST-запроса)
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {//обходим массив со значениями, полученными из POST-запроса
            $type = 's';//метка вместо плейсхолдера

            if (is_int($value)) {//если данное значение есть целое число
                $type = 'i';//метка вместо плейсхолдера
            }
            else if (is_string($value)) {//если данное значение есть строка
                $type = 's';//метка вместо плейсхолдера
            }
            else if (is_double($value)) {//если данное значение есть число с плавающей запятой
                $type = 'd';//метка вместо плейсхолдера
            }

            if ($type) {//если есть метки (в массиве есть данные (число, дробь или строка))
                $types .= $type;//соединяем метки в одну строку
                $stmt_data[] = $value;//записываем в массив данное значение (число, строку или дробь)
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);/* соединяет в один массив подготовленное выражение ($stmt) и
 				строку с метками значений $types (isd) с одной стороны, и массив со значениями,
 				в соотв. со строкой меток $stmt_data с другой*/

        $func = 'mysqli_stmt_bind_param';//записываем строку, чтобы...
        $func(...$values);/* значения из полей формы, полученные из POST-запроса($stmt_data),
 				встали вместо меток ($types) в подготовленном выражении, в соответствии с расположением и типом меток ($types) */

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function get_noun_plural_form (int $number, string $one, string $two, string $many): string
{
    $number = (int) $number;
    $mod10 = $number % 10; //целочисленный остаток от деления на 10
    $mod100 = $number % 100; //целочисленный остаток от деления на 100

    switch (true) {
        case ($mod10 === 1)://если остаток от деления на 10 === 1
            return $one;//возвращает "минута"

        case ($mod10 >= 2 && $mod10 <= 4)://если остаток от деления на 10 >= 2 И <= 4
            return $two;//возвращает "минуты"

        case ($mod10 >= 5 || $mod10 == 0)://если остаток от деления на 10 > 5
            return $many; //возвращает "минут"

			default: // по умолчанию возвращает "минуты"
            return $many;
            /**
						 * 0, 10, 20, 50, 100 - минут - % 0
						 * 1, 21, 31, 51, 101 - минута - % 1
						 * 2, 3, 22, 33, 44, 204 - минуты - % >= 2 && <= 4
						 * 5, 16, 57, 108, 209 - минут - % > 5
						 */
    }
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = []) {
    $name = 'templates/' . $name;//name - название файла
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);//импортирует переменные из массива, ключи - имена переменных
    require $name;//подключает шаблон по пути

    $result = ob_get_clean();

    return $result;
}

