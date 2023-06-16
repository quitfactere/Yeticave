<div class="container">
  <section class="lots">
		<?php if(isset($errors["search"])): ?>
      <h2><span><?= $errors["search"]; ?></span></h2>
		<?php else: ?>
    <h2>Результаты поиска по запросу «<span><?= $search_request; ?></span>»</h2>
    <ul class="lots__list">
			<?php if(!isset($lots[0]["id"])): ?>
        <li class="lots__item lot">
          <div class="lot__image">
            <img src="<?= $lots["image_path"]; ?>" width="350" height="260"
                 alt="<?= htmlspecialchars($lots["title"]); ?>">
          </div>
          <div class="lot__info">
            <span class="lot__category"><?= $lots["category_name"] ?></span>
            <h3 class="lot__title"><a class="text-link"
                                      href="lot.php?id=<?= $lots["id"]; ?>"><?= htmlspecialchars($lots["title"]); ?></a>
            </h3>
            <div class="lot__state">
              <div class="lot__rate">
                <span class="lot__amount">Стартовая цена</span>
                <span class="lot__cost"><?= format_num($lots["start_price"]); ?></span>
              </div>
							<?php $res = get_time_left($lots["date_finish"]) ?>
              <div class="lot__timer timer <?php if ($res[0] < 1) : ?> timer--finishing<?php endif; ?>">
								<?= "$res[0]" . "дн. " . "$res[1]:$res[2]"; ?>
              </div>
            </div>
            </div>
          </div>
        </li>
			<?php elseif(isset($lots[0]["id"])): ?>
				<?php foreach($lots as $lot): ?>
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
                <div class="lot__timer timer <?php if ($res[0] < 1) : ?> timer--finishing<?php endif; ?>">
									<?= "$res[0]" . "дн. " . "$res[1]:$res[2]"; ?>
                </div>
              </div>
            </div>
          </li>
				<?php endforeach; ?>
			<?php endif; ?>
			<?php endif; ?>
    </ul>
  </section>
	<?php if($page_count > 1): ?>
    <ul class="pagination-list">
			<?php $prev = $cur_page - 1; ?>
			<?php $next = $cur_page + 1; ?>
      <li class="pagination-item pagination-item-prev">
        <a <?php if($cur_page >= 2): ?> href="search.php?search=<?= $search_request; ?>&page=<?= $prev; ?>"<?php endif; ?>>Назад</a>
      </li>
			<?php foreach($pages as $page): ?>
      <li class="pagination-item <?php if($page === $cur_page): ?>pagination-item-active<?php endif; ?>">
        <a href="search.php?search=<?= $search_request; ?>&page=<?= $page; ?>"><?= $page; ?></a></li>
		<?php endforeach; ?>
    <li class="pagination-item pagination-item-next">
        <a <?php if($cur_page < $page_count): ?> href="search.php?search=<?= $search_request; ?>&page=<?= $next; ?>"<?php endif; ?>>Вперед</a>
      </li>
    </ul>
	<?php endif; ?>
</div>
