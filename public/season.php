<?php
require_once(__DIR__ . '/../app/config/config.php');

$title = '季節を選ぶ';
$seasons = ['春', '夏', '秋', '冬'];

?>
<!DOCTYPE html>
<html lang="ja">
  <?php require_once(__DIR__ . '/./common/header.php'); ?>
<body>
  <head>
    <h1>今の季節は？</h1>
  </head>
  <main>
    <div class="season-page">
      <?php foreach ($seasons as $season): ?>
        <form action="meaning.php" method="get" class="seasons">
          <input type="hidden" name="season" value="<?php echo Utils::h($season); ?>">
          <input type="submit" class="season" value="<?php echo Utils::h($season); ?>" >
        </form>
      <?php endforeach; ?>
    </div>
  </main>
  <?php require_once(__DIR__ . '/./common/footer.php'); ?>
</body>
</html>