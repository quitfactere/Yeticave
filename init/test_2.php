<?php
$vasya_pass = password_hash("vasya_pass", PASSWORD_DEFAULT);
$petya_pass = password_hash("petya_pass", PASSWORD_DEFAULT);
var_dump($vasya_pass);
var_dump($petya_pass);
