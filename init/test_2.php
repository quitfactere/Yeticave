<?php
/*$cur_date = strtotime("now");
print "Таймштамп текущей даты " . $cur_date . '<br>';
$date_born = strtotime("12 April 1986 15 hours 15 minutes");
print "Таймштамп даты рождения " . $date_born . '<br>';
$ts_diff = $cur_date - $date_born;
print "С даты рождения прошло " . $ts_diff . " секунд" . '<br>';
$years = $ts_diff / (31536000);
print "Или " . floor($years) . " лет" . '<br>';
$tomorrow = strtotime("tomorrow");
print "Таймштамп завтра " . $tomorrow . '<br>';
$left_untill_tomorrow = $tomorrow - $cur_date;
$hours = floor($left_untill_tomorrow / 3600);
$minutes = floor(($left_untill_tomorrow % 3600) / 60);
print "До завтра осталось " . $left_untill_tomorrow . " секунд. " .
	"Или " . $hours . " часа " .
	$minutes . " минут " . '<br>';*/

date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

$date_born_str = "12 April 1986";
$date_born = date_create($date_born_str);
$date_now = date_create("now");
$diff = date_diff($date_now, $date_born);
$years = date_interval_format($diff, "%Y");

print("Мне $years лет");

$interval = date_interval_create_from_date_string("23 day");
$future_dt = date_add($date_now, $interval);
$dt_format = date_format($future_dt, "d.m.Y");
print("Через 23 дня будет $dt_format");
?>