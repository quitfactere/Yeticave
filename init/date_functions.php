<html><title>Дата, время</title></html>
<h3>Дата вчера, $date_yesterday = date_create("2023-05-31 09:00:00"), массив: </h3></html>
<?php
$date_custom = date_create("2023-06-06 06:00:00");
var_dump($date_custom);?>

<html><h3>Дата сейчас, $date_now = date_create("now"), массив: </h3></html>
<?php $date_now = date_create("now");
var_dump($date_now); ?>

<html><h3>Разница между датами, date_diff($date_now, $date_yesterday), массив: </h3></html>
<?php
$diff = date_diff($date_custom, $date_now);
var_dump($diff);?>

<html><h3>Форматирует разницу между датами, формат: дни часы минуты секунды </h3></html>
<?php $format_diff = date_interval_format($diff, "%D %H %I %S");
var_dump($format_diff); ?>

<html><h3>Разделить дату по пробелу, explode: </h3></html>
<?php $arr = explode(" ", $format_diff);
var_dump($arr);?>

<html><h3>Разница в часах: </h3></html>
<?php
$hours = $arr[0] * 24 + $arr[1];
var_dump($hours);?>

<html><h3>Разница в минутах: </h3></html>
<?php $minutes = intval($arr[2]);
var_dump($minutes); ?>

<html><h3>дополняет строку $hours нулями, до двух символов, слева </h3></html>
<?php var_dump($hours = str_pad($hours, 2, "0", STR_PAD_LEFT));// дополняет строку $hours нулями, до двух символов, слева?>

<html><h3>дополняет строку $minutes нулями, до двух символов, слева </h3></html>
<?php var_dump($minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT));?>

<html><h3>Первый элемент массива $res, часы </h3></html>
<?php var_dump($res[] = $hours);?>

<html><h3>Второй элемент массива $res, минуты </h3></html>
<?php var_dump($res[] = $minutes);?>

<html><h3>Функция gettimeofday</h3></html>
<?php var_dump(gettimeofday());?>

<html><div <?php if ($res[0] < 1) : ?>style="background-color:red" <?php endif; ?>>Если времени осталось меньше часа, блока закрашивается серым </div></html>

<html><h3>Функция getdate</h3></html>
<?php var_dump(getdate()); ?>

<html><h3>Функция</h3></html>
<?php $date = getdate();
echo $date_format = $date["hours"] . $date["minutes"] . $date["seconds"]; ?>

<html><h3>Дата сейчас, $date_now = date_create("now"), массив: </h3></html>
<?php $date = date_create("now");
var_dump($date);?>

<html><h3>Форматирует разницу между датами, формат: дни часы минуты секунды </h3></html>
<?php $format_date = date_format($date, "Y-m-d H:i:s");
var_dump($format_date); ?>


