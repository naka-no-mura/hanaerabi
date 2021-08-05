<?php
session_start();

class Users {

  public static function getUserIdFromLineIdToken($pdo) {

    $line_id_token = filter_input(INPUT_POST, 'id_token');

    if ($line_id_token) {

      // line_id_tokenをもとにusersテーブルにすでにidが存在するか確認
      $stmt = $pdo->prepare('SELECT id FROM users WHERE line_id_token = :line_id_token');
      $stmt->bindValue(':line_id_token', $line_id_token, PDO::PARAM_STR);
      $stmt->execute();
      $res = $stmt->fetch();
      $_SESSION['user_id'] = $res['id'];

      // usersテーブルにidが存在しない場合は初めてのログインなのでINSERT
      if ($_SESSION['user_id']) {
        $stmt = $pdo->prepare('INSERT INTO users (line_id_token) VALUES(?)');
        $stmt->execute([
          $line_id_token
        ]);

        // usersテーブルからidを取得して$user_idに格納
        $stmt = $pdo->prepare('SELECT id FROM users WHERE line_id_token = :line_id_token');
        $stmt->bindValue(':line_id_token', $line_id_token, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch();
        $_SESSION['user_id'] = $res['id'];
      }

    } else {
      echo 'LINE IDトークンを取得できませんでした。ログインしてください。';
    }
  }
}

?>