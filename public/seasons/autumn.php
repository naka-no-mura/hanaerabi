<?php

require('../../app/db/dbconnect.php');

$flowers = $db->query('SELECT * FROM seasons JOIN flowers ON flowers.season_id = seasons.id WHERE seasons.season = "秋"');

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>季節を選ぶ</title>
</head>
<body>
  <head>
    <h1>秋</h1>
    <?php foreach ($flowers as $flower): ?>
    <div>
      <p><?php echo htmlspecialchars($flower['name'], ENT_QUOTES); ?></p>
      <p><?php echo htmlspecialchars($flower['meaning'], ENT_QUOTES); ?></p>
      <img src="<?php echo htmlspecialchars($flower['image'], ENT_QUOTES); ?>" alt="">
    </div>
    <?php endforeach; ?>
  </head>
  <main>
  </main>
</body>
</html>