<?php
if(!isset($_SESSION["name"])) {
?>

<?php $classname = isset($errors) ? "form--invalid" : ""; ?>
<form class="form container" action="sign-up.php" method="post" autocomplete="off"> <!-- form
    --invalid -->
    <h2>Регистрация нового аккаунта</h2>
	<?php $classname = isset($errors["email"]) ? "form__item--invalid" : ""; ?>
    <div class="form__item <?= $classname; ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= getPostVal("email"); ?>">
        <span class="form__error"><?php echo $errors["email"]; ?></span>
    </div>
	<?php $classname = isset($errors["name"]) ? "form__item--invalid" : ""; ?>
    <div class="form__item <?= $classname; ?>">
        <label for="name">Имя<sup>*</sup></label>
        <input id="name" type="text" name="name" placeholder="Введите имя"
               value="<?= getPostVal("name"); ?>">
        <span class="form__error"><?php echo $errors["name"]; ?></span>
    </div>
	<?php $classname = isset($errors["password"]) ? "form__item--invalid" : ""; ?>
    <div class="form__item <?= $classname; ?>">
        <label for="password">Пароль<sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?= getPostVal("password"); ?>">
        <span class="form__error"><?php echo $errors["password"]; ?></span>
    </div>

	
	<?php $classname = isset($errors["contacts"]) ? "form__item--invalid" : ""; ?>
    <div class="form__item <?= $classname; ?>">
        <label for="contacts">Контактные данные <sup>*</sup></label>
        <textarea id="contacts" name="contacts"
                  placeholder="Напишите как с вами связаться"><?= getPostVal("contacts"); ?></textarea>
        <span class="form__error"><?php echo $errors["contacts"]; ?></span>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="#">Уже есть аккаунт</a>
</form>
<?php } else {
	var_dump($errors(http_response_code(403)));
}; ?>