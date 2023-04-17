<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");

// подлючаемся к БД, если true, то направляем запрос в БД, возвращает список лотов, асоциативный массив
if (!$con) {
  $error = mysqli_connect_error();
} else {
  $sql = "SELECT email FROM users ORDER BY id DESC";// возвращаем из БД лоты
  $result = mysqli_query($con, $sql, MYSQLI_STORE_RESULT);
  if ($result) { // если запрос вернул результат запроса из БД
    $email_arr = mysqli_fetch_all($result, MYSQLI_ASSOC); // формируем список категорий в виде ассоциативного массива
  } else {
    $error = mysqli_error($con);
  }
}

$email = $_POST["email"];
?><html><br>Массив с email<br></html><?php
var_dump($email_arr);?><html><br><br>Введённый email<br></html><?php
var_dump($email);

?>

  <html>
  <form class="" action="test_2.php" method="post" autocomplete="off"> <!-- form
    --invalid -->
    <h2>Регистрация нового аккаунта</h2>
    <div class="form__item"> <!-- form__item--invalid -->
      <label for="email">E-mail <sup>*</sup></label>
      <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= getPostVal("email") ?>">
      <span class="form__error">Введите e-mail</span>
    </div>
    <button type="submit" class="button">Зарегистрироваться</button>
      </form>
  </html>

<?php
$email_val = validate_email($email, $email_arr);
var_dump($email_val);