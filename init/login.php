<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");

$categories = get_categories($con);//получаем список категорий

$page_content = include_template("main-login.php",
	["categories" => $categories]
);

$nav = include_template("nav.php", [
    "categories" => $categories
]);

if($_SERVER['REQUEST_METHOD'] === 'POST') {//если метод для запроса страницы POST
	$required = ['email', 'password'];//массив полей, необходимых для заполнения
	$errors = [];//массив для ошибок, которые будут показаны внутри шаблона
	
	$rules = [ //правила валидации, отдельные функции, записанные в ассоциативный массив
		"email" => function($value) {
			return validate_email($value);
		},
		"password" => function($value) {
			return validate_length($value, 6, 10);
		}];
	
	$user_info = filter_input_array(INPUT_POST, [ //получаем все значения из формы и одновременно их фильтруем, названия полей и доп.атрибуты
		"email" => FILTER_DEFAULT,
		"password" => FILTER_DEFAULT,], true);
	
	foreach($user_info as $field => $value) {
		if(isset($rules[$field])) {
			$rule = $rules[$field];//получаем функцию валидирования
			$errors[$field] = $rule($value);//выполняем и записываем результат работы функции валидирования
		}

		if(in_array($field, $required) && empty($value) && $field === 'email') {
			$errors[$field] = "Поле E-mail необходимо заполнить";
		}
		if(in_array($field, $required) && empty($value) && $field === 'password') {
			$errors[$field] = "Поле Пароль необходимо заполнить";
		}
	}
	
	$errors = array_filter($errors);//фильтруем ошибки, удаляя пустые значения. Если форма правильно заполнена, массив с ошибками будет пустой,
	// если же будут текстовые значения, мы должны показать их на экране
	
	if(count($errors)) {//если были ошибки, просто показыавет шаблон с формой
		$page_content = include_template("main-login.php",
			["categories" => $categories,
				"user_info" => $user_info, //передаём данные, полученные из формы
				"errors" => $errors //передаем в шаблон список ошибок
			]);
	} else { //если ошибок не было
		$users_data = get_login($con, $user_info["email"]); //возвращает и записывает в $users_data массив данных пользователей: email, user_name из БД
		if($users_data) {
			if (password_verify($user_info["password"], $users_data["user_password"])) {
				$isession = session_start();
					$_SESSION['name'] = $users_data["user_name"];
					$_SESSION['id'] = $users_data["id"];
					header("Location: index.php");
			} else {
				$errors["password"] = "Вы ввели неверный пароль";
			}
		} else {
			$errors["email"] = "Пользователь с таким e-mail не зарегистрирован";
		}
		
		if(count($errors)) {//если были ошибки, просто показыавет шаблон с формой
			$page_content = include_template("main-login.php",
				["categories" => $categories,
					"user_info" => $user_info, //передаём данные, полученные из формы
					"errors" => $errors //передаем в шаблон список ошибок
				]);
		}
	}
}
$layout_content = include_template("layout.php",
	["content" => $page_content,
		"categories" => $categories,
        "nav" => $nav,
		"title" => "Регистрация",
		"is_auth" => $is_auth,
		"user_name" => $user_name]);

print($layout_content);