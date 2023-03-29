<?php

$date_yesterday = date_create("2023-03-29 12:45:12");
$date_now = date_create("now");
var_dump($date_now); ?>
<html><br><br>
</html>
<?php
$diff = date_diff($date_now, $date_yesterday);
var_dump($diff);
//$date_array = explode(" ", $date);


