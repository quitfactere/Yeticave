<?php

$date_yesterday = date_create("2023-03-29 20:13:00");
$date_now = date_create("now");
var_dump($date_now); ?>
<html><br><br>
</html>
<?php /*
print(explode(", ", $date_now)); */ ?>
<html><br><br>
</html>
<?php
$diff = date_diff($date_now, $date_yesterday);
var_dump($diff);
$format_diff = date_interval_format($diff, "%D %H %I"); ?>
<html><br><br>
</html>
<?php
var_dump($format_diff);
$date_array = explode(" ", $format_diff);?>
  <html><br><br>
  </html>
<?php
var_dump($date_array);


