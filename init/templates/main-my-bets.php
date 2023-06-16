<?php require_once("helpers.php");

?>

<section class="rates container">
  <h2>Мои ставки</h2>
	<?php if(!empty($bets)): ?>
    <table class="rates__list">
			<?php foreach($bets as $bet): ?>
				<?php
				$date = date_create("now");
        $date_bet = date_create($bet["bet_date"]);
				$diff = date_diff($date, $date_bet);
				$format_diff = date_interval_format($diff, "%D:%H:%I:%S");
				$arr = explode(":", $format_diff);
				$hours = (int)$arr[0] * 24 + (int)$arr[1];
				$minutes = intval($arr[2]);
				$total_minutes[] = $hours * 60 + $minutes;

				foreach($total_minutes as $minutes => $value) {
					$minutes_ago = get_noun_plural_form($minutes, "минута", "минуты", "минут");
				}
				?>
        <tr class="rates__item">
          <td class="rates__info">
            <div class="rates__img">
              <img src="<?= $bet["image_path"] ?>" width="54" height="40" alt="<?= $bet["title"] ?>">
            </div>
            <h3 class="rates__title"><a href="lot.php?id=<?= $bet['id']; ?>"><?= $bet["title"] ?></a></h3>
          </td>
          <td class="rates__category">
						<?= $bet["category_name"] ?>
          </td>
					<?php $time = get_time_left($bet["date_finish"]); ?>
          <td class="rates__timer">
            <div class="timer <?php if($time[1] < 1 && $time[0] != 0): ?>timer--finishing<?php endif; ?>">
							<?php if($time[1] !== 0): ?>
								<?= "$time[1] : $time[2]"; ?>
							<?php else: ?>
                <span>Торги окончены</span>
							<?php endif; ?>
            </div>
          </td>
          <td class="rates__price">
						<?= $bet["price_bet"] ?>
          </td>
          <td class="rates__time">
          <?= "$value " . "$minutes_ago" . " назад" ?>
          </td>
        </tr>
			<?php endforeach; ?>
    </table>
	<?php endif; ?>
</section>
