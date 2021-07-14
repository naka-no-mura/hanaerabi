<?php

require('../../app/db/dbconnect.php');

if ($_GET['season']) {
  $fmeanings = $db->prepare('SELECT flowers.meaning FROM flowers JOIN seasons ON flowers.season_id = seasons.id WHERE seasons.season =?');
  $fmeanings->bindValue('seasons.season', $_GET['season'], PDO::PARAM_STR);
  $fmeanings->execute();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>気分を選ぶ</title>
</head>
<body>
  <head>
    <h1>気分を選ぶ</h1>
    <p><?php echo print($_GET['season']); ?></p>
    <div>
      <?php foreach ($fmeanings as $fmeaning): ?>
        <p><?php echo htmlspecialchars($fmeaning['meaning'], ENT_QUOTES); ?></p>
      <?php endforeach; ?>
    </div>
  </head>
  <main>
  </main>
</body>
</html>