<h2><?= $lot['title'] ?></h2>
<div class="lot-item__content">
  <div class="lot-item__left">
    <div class="lot-item__image">
      <img src="<?= $lot['image_path'] ?>" width="730" height="548" alt="<?= $lot['title'] ?>">
    </div>
    <p class="lot-item__category">Категория: <span><?= $lot['category_name'] ?></span></p>
    <p class="lot-item__description"><?= $lot['lot_description']; ?></p>
    <p>Автор лота: <?php echo $lot['user_name']; ?></p>
  </div>

  <div class="lot-item__right">
		<?php if(isset($_SESSION['name']) && $lot["date_finish"] > $date_now && $_SESSION['name'] !== $lot['user_name']
			&& ((isset($history[0]["user_name"])) && $_SESSION['name'] !== $history[0]["user_name"])): ?>
      <div class="lot-item__state">
				<?php $res = get_time_left($lot["date_finish"]) ?>
        <div class="lot-item__timer timer <?php if($res[0] < 1) : ?> timer--finishing<?php endif; ?>">
					<?= "$res[0]" . "дн. " . "$res[1]:$res[2]"; ?>
        </div>
        <div class="lot-item__cost-state">
          <div class="lot-item__rate">
            <span class="lot-item__amount">Текущая цена</span>

            <span class="lot-item__cost"><?php if(count($history) != 0): ?><?= format_num($history[0]["price_bet"]); ?>
							<?php else: ?><?= format_num(htmlspecialchars($lot["start_price"])); ?><?php endif; ?></span>
            <!-- текущая цена - первый элемент массива со ставками, т.к. функция сортирует ставки по убыванию -->
          </div>
          <div class="lot-item__min-cost">
            Мин. ставка <span><?php if(count($history) > 0): ?><?= format_num($min_bet); ?>
							<?php else: ?><?= format_num($lot["start_price"]); ?>
							<?php endif; ?></span>
          </div>
        </div>
        <form class="lot-item__form" action="lot.php?id=<?= $id; ?>" method="post" autocomplete="off">
          <p class="lot-item__form-item form__item <?php if($error): ?>form__item--invalid<?php endif; ?>">
            <label for="cost">Ваша ставка</label>
            <input id="cost" type="text" name="cost"
                   placeholder="от <?php if(count($history) > 0): ?><?= format_num($min_bet); ?>
							<?php else: ?><?= format_num($lot["start_price"]); ?>
							<?php endif; ?>">
            <span class="form__error"><?= $error; ?></span>
          </p>
          <button type="submit" class="button">Сделать ставку</button>
        </form>
      </div>
		<?php else: ?>
      <div></div>
		<?php endif; ?>
    <div class="history">
      <h3>История ставок (<span>10</span>)</h3>
      <table class="history__list">
				<?php foreach($history as $key): ?>
          <tr class="history__item">
            <td class="history__name"><?= $key["user_name"] ?></td>
            <td class="history__price"><?= $key["price_bet"] ?></td>
            <td class="history__time"><?= $key["bet_date"] ?></td>
          </tr>
				<?php endforeach; ?>
      </table>
    </div>
  </div>

</div>
</section>


