<?php
session_start();
$is_auth = isset($_SESSION["name"]);
if($is_auth) {
	$user_name = $_SESSION["name"];
} else {
	$user_name = NULL;
}

