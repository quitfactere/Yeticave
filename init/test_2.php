<?php
$date = date_create("now");
$format_date = date_format($date, "Y-m-d");
$explode = explode("-", $format_date);
var_dump($explode[0]);
?>