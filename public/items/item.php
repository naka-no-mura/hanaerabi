<?php

require_once(__DIR__ . '/../../app/config/config.php');

$pdo = getPdoInstance($pdo);
$flowers = Flowers::getFlowers($pdo);

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
  <link rel="stylesheet" href="../../app/assets/stylesheets/style.css" type="text/css">
  <title>ハナエラビ</title>
</head>
<body>
  <head>
    <h1>そんなあなたへは</h1>
  </head>
  <main>
    <div>
      <?php foreach($flowers as $flower): ?>
        <h2 class="flower-name"><?php echo Utils::h($flower['name']); ?></h2>
        <p>花言葉は・・・</p>
        <p><big><?php echo Utils::h($flower['GROUP_CONCAT(meanings.meaning)']); ?></big></p>
        <img class="flower-img" src="<?php echo Utils::h($flower['image']); ?>" alt="花の画像">
      <?php endforeach; ?>
    </div>
  </main>
</body>
</html>