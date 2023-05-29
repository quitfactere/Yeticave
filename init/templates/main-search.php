<div class="container">
  <section class="lots">
		<?php if(isset($errors["search"])): ?>
      <h2><span><?= $errors["search"]; ?></span></h2>
		<?php else: ?>
    <h2>Результаты поиска по запросу «<span><?= $search_request; ?></span>»</h2>
    <ul class="lots__list">
			<?php if(!isset($lots_name_desc[0]["id"])): ?>
        <li class="lots__item lot">
          <div class="lot__image">
            <img src="<?= $lots_name_desc["image_path"]; ?>" width="350" height="260"
                 alt="<?= $lots_name_desc["title"]; ?>">
          </div>
          <div class="lot__info">
            <span class="lot__category"><?= $lots_name_desc["category_name"] ?></span>
            <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $lots_name_desc["id"]; ?>"><?= $lots_name_desc["title"] ?></a>
            </h3>
            <div class="lot__state">
              <div class="lot__rate">
                <span class="lot__amount">Стартовая цена</span>
                <span class="lot__cost"><?= $lots_name_desc["start_price"] ?><b class="rub">р</b></span>
              </div>
              <div class="lot__timer timer">
                16:54:12
              </div>
            </div>
          </div>
        </li>
			<?php elseif(isset($lots_name_desc[0]["id"])): ?>
				<?php foreach($lots_name_desc as $finding_lot): ?>
          <li class="lots__item lot">
            <div class="lot__image">
              <img src="<?= $finding_lot["image_path"]; ?>" width="350" height="260"
                   alt="<?= $finding_lot["title"]; ?>">
            </div>
            <div class="lot__info">
              <span class="lot__category"><?= $finding_lot["category_name"] ?></span>
              <h3 class="lot__title"><a class="text-link"
                                        href="lot.php?id=<?= $finding_lot["id"]; ?>"><?= $finding_lot["title"] ?></a>
              </h3>
              <div class="lot__state">
                <div class="lot__rate">
                  <span class="lot__amount">Стартовая цена</span>
                  <span class="lot__cost"><?= $finding_lot["start_price"] ?><b class="rub">р</b></span>
                </div>
                <div class="lot__timer timer">
                  16:54:12
                </div>
              </div>
            </div>
          </li>
				<?php endforeach; ?>
			<?php endif; ?>
			<?php endif; ?>
    </ul>
  </section>
  <ul class="pagination-list">
    <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
    <li class="pagination-item pagination-item-active"><a>1</a></li>
    <li class="pagination-item"><a href="#">2</a></li>
    <li class="pagination-item"><a href="#">3</a></li>
    <li class="pagination-item"><a href="#">4</a></li>
    <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
  </ul>
</div>
