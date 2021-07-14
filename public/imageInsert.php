<?php

require('../app/db/dbconnect.php');

if (!empty($_POST)) {
  $stmt = $db->prepare("INSERT INTO flowers SET season_id=?, name=?, meaning=?,image=?");
  $stmt->execute(array(
    $_POST['season_id'],
    $_POST['name'],
    $_POST['meaning'],
    $_FILES['image']
  ));

  header('Location: imageInsert.php');
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ハナエラビ</title>
</head>

<body>
  <head>
    <h1>画像挿入</h1>
  </head>
  <main>
    <form action="" method="post" enctype="multipart/form-data">
      <dl>
        <dt>花の名前</dt>
        <dd><input type="text" name="name"></dd>
        <dt>季節id</dt>
        <dd><input type="text" name="season_id"></dd>
        <dt>花言葉</dt>
        <dd><input type="text" name="meaning"></dd>
        <dt>写真</dt>
        <dd><input type="file" name="image"></dd>
      </dl>
      <input type="submit" value="リクエストを送信">
    </form>
  </main>
</body>
</html>