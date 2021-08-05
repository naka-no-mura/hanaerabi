<?php
session_start();

require_once(__DIR__ . '/../../app/config/config.php');

$pdo = getPdoInstance($pdo);


if ($_POST['record']) {

  $created_at = filter_input(INPUT_POST, 'created_at');
  $flower_name = filter_input(INPUT_POST, 'flower_name');
  $selected_meaning = filter_input(INPUT_POST, 'selected_meaning');
  $flower_image = filter_input(INPUT_POST, 'flower_image');
  $comment = filter_input(INPUT_POST, 'comment');
  $user_id = $_SESSION['user_id'];

  $stmt = $pdo->prepare(
    'INSERT INTO records (created_at, flower_name, selected_meaning, flower_image, comment, user_id)
    VALUES(:created_at, :flower_name, :selected_meaning, :flower_image, :comment, :user_id)');
  $stmt->execute([
    'created_at' => $created_at,
    'flower_name' => $flower_name,
    'selected_meaning' => $selected_meaning,
    'flower_image' => $flower_image,
    'comment' => $comment,
    'user_id' => $user_id,
  ]);

  echo 'recordsテーブルにINSERTしました';
} else {
  echo 'INSERTに失敗しました';
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
  <link rel="stylesheet" href="../assets/stylesheets/style.css" type="text/css">
  <title>私の記録</title>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-170627472-4"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-170627472-4');
  </script>
</head>
<body>
  <head>
    <h1>私の記録</h1>
  </head>
  <main>
  </main>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script charset="utf-8" src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>
  <script>
    liff
    .init({
        liffId: '1656216720-24XArQJK'
    })
    .then(() => {
      $(function() {
        const idToken = liff.getIDToken();
        $.ajax({
          type: "POST",
          url: "records.php",
          data: {
            id_token: idToken
          },
          success:function(data) {
            console.log(data);
          },
          error:function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
          }
        })
      })
    })
  </script>
</body>
</html>