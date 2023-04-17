<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");

$categories = get_categories($con);//получаем список категорий
$categories_id = array_column($categories, "id");//возвращает массив из значений id категорий

$page_content = include_template("main-add.php", [
  "categories" => $categories
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {//если метод для запроса страницы POST
  $required = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];//массив полей, необходимых для заполнения
  $errors = [];//массив для ошибок, которые будут показаны внутри шаблона

  $rules = [ //правила валидации, отдельные функции, записанные в ассоциативный массив
    "category" => function($value) use ($categories_id) {
      return validate_category($value, $categories_id);
    },
    "lot-rate" => function($value) {
      return validate_number($value);
    },
    "lot-step" => function($value) {
      return validate_number($value);
    },
    "lot-date" => function($value) {
      return validate_date($value);
    }
  ];

  $lot = filter_input_array(INPUT_POST, [ //получаем все значения из формы и одновременно их фильтруем, названия полей и доп.атрибуты
    "lot-name" => FILTER_DEFAULT,
    "category" => FILTER_DEFAULT,
    "message" => FILTER_DEFAULT,
    "lot-rate" => FILTER_DEFAULT,
    "lot-step" => FILTER_DEFAULT,
    "lot-date" => FILTER_DEFAULT,
  ], true);

  foreach ($lot as $field => $value) { //проходим все поля, которые получили из формы
    if (isset($rules[$field])) { //если имя этого поля есть в правилах валидации
      $rule = $rules[$field]; //получаем функцию, отвечающую за валидацию этого поля; вызываем правило $rules для этого поля $field
      $errors[$field] = $rule($value); //выполняем функцию $rules($value), записываем в массив ошибками получившийся результат
    }
    if (in_array($field, $required) && empty($value)) { //если в массиве обязательных к заполнению полей $required, существует элемент $field и он пустой
      $errors[$field] = "Поле $field[\"name\"] необходимо заполнить";
    }
  }

  $errors = array_filter($errors);//фильтруем ошибки, удаляя пустые значения. Если форма правильно заполнена, массив с ошибками будет пустой,
                                  // если же будут текстовые значения, мы должны показать их на экране

  if (!empty($_FILES["lot-img"]["name"])) { //если файл загружен, присутствует в массиве $_FILES
    $tmp_name = $_FILES["lot-img"]["tmp_name"];//задаем временное имя загруженного файла
    $path = $_FILES["lot-img"]["name"];//путь к загруженному файлу

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($finfo, $tmp_name);//получаем тип загруженного файла
    if ($file_type === "image/jpeg") {
      $ext = ".jpg";
    } else if ($file_type === "image/png") {
      $ext = ".png";
    };
    if ($ext) { //если тип файла является изображением
      $filename = uniqid() . $ext;//задаем уникальный идентификатор файлу
      $lot["path"] = "uploads/" . $filename;//сохраняем путь к загруженному файлу
      move_uploaded_file($_FILES["lot-img"]["tmp_name"], "uploads/" . $filename);//перемещает файл из временного хранилища в новое место
    } else {
      $errors["lot-img"] = "Допустимые форматы файлов: jpg, jpeg, png";//если файл не является картинкой
    }
  } else {
    $errors["lot-img"] = "Вы не загрузили изображение";
  };

  if (count($errors)) {//если были ошибки, просто показыавет шаблон с формой
    $page_content = include_template("main-add.php", [
      "categories" => $categories,
      "lot" => $lot, //передаём данные, полученные из формы
      "errors" => $errors //передаем в шаблон список ошибок
    ]);
  } else { //если ошибок не было
    $sql = get_query_create_lot(2);//используем подготовленное выражение, добавляем новый лот
    $stmt = db_get_prepare_stmt($con, $sql, $lot); //Создает подготовленное выражение на основе готового SQL запроса и переданных данных
    $result = mysqli_stmt_execute($stmt);
  };

  if ($result) {//если запрос выполнился успешно
    $lot_id = mysqli_insert_id($con);//получаем id нового лота
    header("Location: /init/lot.php?id=" . $lot_id);//переадресуем пользователя на страниу просмотра этого лота
  } else {
    $error = mysqli_error($con);
  }
};

$layout_content = include_template("layout-add.php", [
  "content" => $page_content,
  "categories" => $categories,
  "is_auth" => $is_auth,
  "user_name" => $user_name
]);

print($layout_content);