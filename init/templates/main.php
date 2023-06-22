  <section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и
      горнолыжное снаряжение.</p>
    <ul class="promo__list">
      <?php foreach ($categories as $category): ?>
        <li class="promo__item promo__item--<?php echo $category['character_code']; ?>">
          <a class="promo__link" href="lots-of-cat.php<?= "?category=" . $category["character_code"] ?>">
						<?php echo $category["category_name"]; ?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>
  <section class="lots">
    <div class="lots__header">
      <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
      <?php foreach ($lots as $lot): ?>
        <li class="lots__item lot">
          <div class="lot__image"><a href="lot.php?id=<?= $lot['id']; ?>">
            <img src="<?= $lot['image_path']; ?>" width="350" height="260" alt=""></a>
          </div>
          <div class="lot__info">
            <span class="lot__category"><?= $lot['category_name']; ?></span>
            <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $lot["id"]; ?>"> <?= htmlspecialchars($lot['title']); ?></a>
            </h3>
            <div class="lot__state">
              <div class="lot__rate">
                <span class="lot__amount">Стартовая цена</span>
                  <?= format_num(htmlspecialchars($lot["start_price"])); ?>
              </div>
              <?php $res = get_time_left($lot["date_finish"]) ?>
              <div class="lot__timer timer <?php if ($res[0] < 1) : ?> timer--finishing<?php endif; ?>">
                <?= "$res[0]" . "ч. " . "$res[1]" . "м. "; ?>
              </div>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>
