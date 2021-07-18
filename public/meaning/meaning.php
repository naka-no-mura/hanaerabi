<?php

require_once(__DIR__ . '/../../app/config/config.php');

$pdo = getPdoInstance($pdo);
$fmeanings = FlowerLanguages::getFlowerLanguages($pdo);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@400;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../app/assets/stylesheets/style.css" type="text/css">
  <title>ハナエラビ</title>
</head>
<body>
  <head>
    <h1>今の気分は？</h1>
  </head>
  <main>
    <div>
      <?php shuffle($fmeanings); foreach ($fmeanings as $fmeaning): ?>
        <form action="../items/item.php" method="get" class="meanings">
          <input type="hidden" name="flower_id" value="<?php echo Utils::h($fmeaning['id']); ?>">
          <input type="hidden" name="season" value="<?php echo Utils::h($fmeaning['season']); ?>">
          <input type="submit" class="meaning" value="<?php echo Utils::h($fmeaning['meaning']); ?>">
        </form>
      <?php endforeach; ?>
    </div>
  </main>
</body>
</html>