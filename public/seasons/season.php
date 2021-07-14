<?php

// $seasons = [
//   '春' => 'spring.php',
//   '夏' => 'summer.php',
//   '秋' => 'autumn.php',
//   '冬' => 'winter.php'
// ];
$seasons = ['春', '夏', '秋', '冬'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>今の季節は？</title>
</head>
<body>
  <head>
    <h1>今の季節は？</h1>
  </head>
  <main>
    <?php foreach ($seasons as $season): ?>
      <form action="../meaning/meaning.php" method="get">
        <input type="hidden" name="season" value="<?php echo $season; ?>">
        <input type="submit" value="<?php echo $season; ?>" >
      </form>
    <?php endforeach; ?>
  </main>
</body>
</html>