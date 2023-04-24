<nav class="nav">
    <ul class="nav__list container">
			<?php foreach($categories as $category): ?>
          <li class="nav__item">
              <a href="all-lots.html"><?= $category["category_name"]; ?></a>
          </li>
			<?php endforeach; ?>
    </ul>
</nav>
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
        <input id="name" type="name" name="name" placeholder="Введите имя"
               value="<?= getPostVal("name"); ?>">
        <span class="form__error"><?php echo $errors["name"]; ?></span>
    </div>
	<?php $classname = isset($errors["password"]) ? "form__item--invalid" : ""; ?>
    <div class="form__item <?= $classname; ?>">
        <label for="password">Пароль<sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?= getPostVal("password"); ?>">
        <span class="form__error"><?php echo $errors["password"]; ?></span>
    </div>

	
	<?php $classname = isset($errors["message"]) ? "form__item--invalid" : ""; ?>
    <div class="form__item <?= $classname; ?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="message"
                  placeholder="Напишите как с вами связаться"><?= getPostVal("message"); ?></textarea>
        <span class="form__error"><?php echo $errors["message"]; ?></span>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="#">Уже есть аккаунт</a>
</form>

