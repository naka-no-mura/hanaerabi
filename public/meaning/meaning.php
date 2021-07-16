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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@400;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../app/assets/stylesheets/style.css" type="text/css">
  <title>ハナエラビ</title>
</head>
<body>
  <head>
    <h1>今の気分は？</h1>
  </head>
  <main>
    <p><?php echo print(htmlspecialchars($_GET['season'], ENT_QUOTES)); ?></p>
    <div>
      <?php foreach ($fmeanings as $fmeaning): ?>
        <form action="../items/item.php" method="get" class="meanings">
          <input type="hidden" name="flower_id" value="<?php echo $fmeaning['id'] ?>">
          <input type="submit" class="meaning" value="<?php echo htmlspecialchars($fmeaning['meaning'], ENT_QUOTES); ?>">
        </form>
      <?php endforeach; ?>
    </div>
  </main>
</body>
</html>