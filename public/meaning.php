<?php

require_once(__DIR__ . '/../app/config/config.php');

$title = '気分を選ぶ';

$pdo = getPdoInstance($pdo);
$fmeanings = FlowerLanguages::getFlowerLanguages($pdo);

?>
<!DOCTYPE html>
<html lang="ja">
  <?php require_once(__DIR__ . '/./common/header.php'); ?>
<body>
  <head>
    <h1>今の気分は？</h1>
  </head>
  <main>
    <div>
      <?php shuffle($fmeanings); foreach ($fmeanings as $fmeaning): ?>
        <form action="item.php" method="get" class="meanings">
          <input type="hidden" name="flower_id" value="<?php echo Utils::h($fmeaning['id']); ?>">
          <input type="hidden" name="season" value="<?php echo Utils::h($fmeaning['season']); ?>">
          <input type="hidden" name="meaning" value="<?php echo Utils::h($fmeaning['meaning']); ?>">
          <input type="submit" class="meaning" value="<?php echo Utils::h($fmeaning['meaning']); ?>">
        </form>
      <?php endforeach; ?>
    </div>
  </main>
  <?php require_once(__DIR__ . '/./common/footer.php'); ?>
</body>
</html>