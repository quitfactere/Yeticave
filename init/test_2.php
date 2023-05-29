<?php

$con = mysqli_connect('127.0.0.1', 'root', '', 'protocol');
mysqli_set_charset($con,'utf8');
$sql = "SELECT * FROM protocol_table";
$result = mysqli_query($con, $sql);
var_dump($result);
?>