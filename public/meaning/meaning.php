<?php

require('../../app/db/dbconnect.php');

if ($_GET['season']) {
  $fmeanings = $db->prepare('SELECT flowers.meaning, flowers.id FROM flowers JOIN seasons ON flowers.season_id = seasons.id WHERE seasons.season =:season_name');
  $fmeanings->bindValue(':season_name', $_GET['season'], PDO::PARAM_STR);
  $fmeanings->execute();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>今の気分は？</title>
</head>
<body>
  <head>
    <h1>今の気分は？</h1>
    <p><?php echo print(htmlspecialchars($_GET['season'], ENT_QUOTES)); ?></p>
    <div>
      <?php foreach ($fmeanings as $fmeaning): ?>
        <form action="../items/item.php" method="get">
          <input type="hidden" name="flower_id" value="<?php echo $fmeaning['id'] ?>">
          <input type="submit" value="<?php echo htmlspecialchars($fmeaning['meaning'], ENT_QUOTES); ?>">
        </form>
      <?php endforeach; ?>
    </div>
  </head>
  <main>
  </main>
</body>
</html>