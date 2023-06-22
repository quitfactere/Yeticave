<div class="container">
  <section class="lots">
		<?php if(isset($errors["character_code"])): ?>
      <h2><span><?= $errors["character_code"]; ?></span></h2>
		<?php else: ?>
    <h2>Все лоты в категории
			<?= $category["category_name"]; ?></h2>
    <ul class="lots__list">
			<?php if(!isset($lots_of_cat[0]["id"])): ?>
      <li class="lots__item lot">
        <div class="lot__image">
          <img src="<?= $lots_of_cat["image_path"]; ?>" width="350" height="260"
               alt="<?= htmlspecialchars($lots_of_cat["title"]); ?>">
        </div>
        <div class="lot__info">
          <span class="lot__category"><?= $lots_of_cat["category_name"]; ?></span>
          <h3 class="lot__title"><a class="text-link"
                                    href="lot.php?id=<?= $lots_of_cat["id"]; ?>"><?= htmlspecialchars($lots_of_cat["title"]); ?></a>
          </h3>
          <div class="lot__state">
            <div class="lot__rate">
              <span class="lot__amount">Стартовая цена</span>
              <span class="lot__cost"><?= format_num($lots_of_cat["start_price"]); ?></span>
            </div>
						<?php $res = get_time_left($lots_of_cat["date_finish"]) ?>
            <div class="lot__timer timer <?php if($res[0] < 1) : ?> timer--finishing<?php endif; ?>">
							<?= "$res[0]" . ":" . "$res[1]"; ?>
            </div>
          </div>
        </div>
</div>
</li>
<?php elseif(isset($lots_of_cat)): ?>
	<?php foreach($lots_of_cat as $lot): ?>
    <li class="lots__item lot">
      <div class="lot__image">
        <img src="<?= $lot["image_path"]; ?>" width="350" height="260"
             alt="<?= $lot["title"]; ?>">
      </div>
      <div class="lot__info">
        <span class="lot__category"><?= $lot["category_name"] ?></span>
        <h3 class="lot__title"><a class="text-link"
                                  href="lot.php?id=<?= $lot["id"]; ?>"><?= $lot["title"] ?></a>
        </h3>
        <div class="lot__state">
          <div class="lot__rate">
            <span class="lot__amount">Стартовая цена</span>
            <span class="lot__cost"><?= format_num(htmlspecialchars($lot["start_price"])); ?></span>
          </div>
					<?php $res = get_time_left($lot["date_finish"]) ?>
          <div class="lot__timer timer <?php if($res[0] < 1) : ?> timer--finishing<?php endif; ?>">
						<?= "$res[0]" . ":" . "$res[1]"; ?>
          </div>
        </div>
      </div>
    </li>
	<?php endforeach; ?>
<?php endif; ?>
</ul>
</section>
<?php if($page_count > 1): ?>
  <ul class="pagination-list">
		<?php $prev = $cur_page - 1; ?>
		<?php $next = $cur_page + 1; ?>
    <li class="pagination-item pagination-item-prev">
      <a <?php if($cur_page >= 2): ?> href="lots-of-cat.php?category=<?= $category["character_code"]; ?>&page=<?= $prev; ?>"<?php endif; ?>>Назад</a>
    </li>
		<?php foreach($pages as $page): ?>
      <li class="pagination-item <?php if($page === $cur_page): ?>pagination-item-active<?php endif; ?>">
        <a href="lots-of-cat.php?category=<?= $category["character_code"]; ?>&page=<?= $page; ?>"><?= $page; ?></a></li>
		<?php endforeach; ?>
    <li class="pagination-item pagination-item-next">
      <a <?php if($cur_page < $page_count): ?> href="lots-of-cat.php?category=<?= $category["character_code"]; ?>&page=<?= $next; ?>"<?php endif; ?>>Вперед</a>
    </li>
  </ul>
<?php endif; ?>
</div>
<?php endif; ?>


