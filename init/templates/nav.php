
<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $category): ?>
            <li class="nav__item">
                <a href="lots-of-cat.php<?= "?category=" . $category["character_code"] ?>">
                  <?php echo $category["category_name"]; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<!--
1. Сравнивать категории
2.
 -->
