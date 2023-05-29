<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");

$categories = get_categories($con);//получаем список категорий

$page_content = include_template("main-sign-up.php", ["categories" => $categories]);

if($_SERVER['REQUEST_METHOD'] === 'POST') {//если метод для запроса страницы POST
	$required = ['email', 'name', 'password', 'contacts'];//массив полей, необходимых для заполнения
	$errors = [];//массив для ошибок, которые будут показаны внутри шаблона

	$rules = [ //правила валидации, отдельные функции, записанные в ассоциативный массив
		"email" => function($value) {
			return validate_email($value);
		}, "password" => function($value) {
			return validate_length($value, 6, 8);
		}, "contacts" => function($value) {
			return validate_length($value, 12, 1000);
		}];

	$user = filter_input_array(INPUT_POST, [ //получаем все значения из формы и одновременно их фильтруем, названия полей и доп.атрибуты
		"email" => FILTER_DEFAULT, "name" => FILTER_DEFAULT, "password" => FILTER_DEFAULT, "contacts" => FILTER_DEFAULT], true);

	foreach($user as $field => $value) { //проходим все поля, которые получили из формы
		if(isset($rules[$field])) { //если имя этого поля есть в правилах валидации
			$rule = $rules[$field]; //получаем функцию, отвечающую за валидацию этого поля; вызываем правило $rules для этого поля $field
			$errors[$field] = $rule($value); //выполняем функцию $rules($value), записываем в массив ошибками получившийся результат
		}
		if(in_array($field, $required) && empty($value) && $field == "email") { //если в массиве обязательных к заполнению полей $required, существует элемент $field и он пустой
			$errors[$field] = "Поле E-mail необходимо заполнить";
		}
		if(in_array($field, $required) && empty($value) && $field == "name") { //если в массиве обязательных к заполнению полей $required, существует элемент $field и он пустой
			$errors[$field] = "Поле Имя необходимо заполнить";
		}
		if(in_array($field, $required) && empty($value) && $field == "password") { //если в массиве обязательных к заполнению полей $required, существует элемент $field и он пустой
			$errors[$field] = "Поле Пароль необходимо заполнить";
		}
		if(in_array($field, $required) && empty($value) && $field == "contacts") { //если в массиве обязательных к заполнению полей $required, существует элемент $field и он пустой
			$errors[$field] = "Поле Контактные данные необходимо заполнить";
		}
	}

	$errors = array_filter($errors);//фильтруем ошибки, удаляя пустые значения. Если форма правильно заполнена, массив с ошибками будет пустой,
	// если же будут текстовые значения, мы должны показать их на экране

	if(count($errors)) {//если были ошибки, просто показыавет шаблон с формой
		$page_content = include_template("main-sign-up.php", [
			"categories" => $categories,
			"user" => $user, //передаём данные, полученные из формы
			"errors" => $errors //передаем в шаблон список ошибок
		]);
	} else { //если ошибок не было
		$users_data = get_users_data($con); //возвращает и записывает в $users_data массив данных пользователей: email, user_name из БД
		$emails = array_column($users_data, "email");//возвращает массив из значений одного столбца входного массива из БД
		$names = array_column($users_data, "user_name");//возвращает массив из значений одного столбца входного массива из БД
		if(in_array($user["email"], $emails)) {//если email, отправленный из формы, совпадает с каким-либо email в БД зарегистрированных пользователей
			$errors["email"] = "Пользователь с таким e-mail уже зарегистрирован";
		}
		if(in_array($user["name"], $names)) {//если имя пользователя, отправленное из формы, совпадает с именем в массиве имён зарегистрированных пользователей
			$errors["name"] = "Пользователь с таким именем уже зарегистрирован";
		}

		if(count($errors)) {//если были ошибки, просто показыавет шаблон с формой
			$page_content = include_template("main-sign-up.php", ["categories" => $categories, "user" => $user, //передаём данные, полученные из формы
				"errors" => $errors //передаем в шаблон список ошибок
			]);
		} else {
			$sql = get_query_create_user();//шаблон SQL-запроса для регистрации нового пользователя
			$user["password"] = password_hash($user["password"], PASSWORD_DEFAULT);//создает хэш пароля
			$stmt = db_get_prepare_stmt($con, $sql, $user); //Создает подготовленное выражение на основе готового SQL запроса и переданных данных
			$result = mysqli_stmt_execute($stmt);

			if($result) {//если запрос выполнился успешно
				header("Location: login.php");//переадресуем пользователя на страниу просмотра этого лота
			} else {
				$error = mysqli_error($con);
			}
		}
	}
}

$layout_content = include_template("layout.php",
	["content" => $page_content,
		"categories" => $categories,
		"title" => "Регистрация",
		"is_auth" => $is_auth,
		"user_name" => $user_name]);

print($layout_content);