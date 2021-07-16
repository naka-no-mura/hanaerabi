<?php

require('../../app/db/dbconnect.php');

if ($_GET['flower_id']) {
  $flowers = $db->prepare(
    'SELECT seasons.season, flowers.name, flowers.image, GROUP_CONCAT(meanings.meaning)
     FROM `seasons`
     JOIN categorization ON seasons.id = categorization.season_id
     JOIN flowers ON categorization.flower_id = flowers.id
     JOIN language ON flowers.id = language.flower_id
     JOIN meanings ON language.meaning_id = meanings.id
     GROUP BY flowers.id, seasons.season
     HAVING flowers.id = :flower_num AND seasons.season = :season_name'
  );
  $flowers->bindValue(':flower_num', $_GET['flower_id'], PDO::PARAM_INT);
  $flowers->bindValue(':season_name', $_GET['season'], PDO::PARAM_STR);
  $flowers->execute();
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
    <h1>そんなあなたへは</h1>
  </head>
  <main>
    <div>
      <?php foreach($flowers as $flower): ?>
        <p><?php echo htmlspecialchars($flower['name'], ENT_QUOTES); ?></p>
        <p><?php echo htmlspecialchars($flower['GROUP_CONCAT(meanings.meaning)'], ENT_QUOTES); ?></p>
        <img src="<?php echo htmlspecialchars($flower['image'], ENT_QUOTES); ?>" alt="">
      <?php endforeach; ?>
    </div>
  </main>
</body>
</html>