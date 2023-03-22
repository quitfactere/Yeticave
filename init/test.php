<?php
$mysqli = new mysqli('yeticave', 'root', '12', 'my_db');
if ($mysqli->connect_error) {
  die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}