<?php
session_start();

require_once(__DIR__ . '/../../vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

class Users {

  public static function getUserIdFromLineIdToken($pdo) {

    $line_id_token = filter_input(INPUT_POST, 'id_token');

    if ($line_id_token) {
      // line_id_tokenをもとにユーザー情報をLINEプラットフォームから取得
      $base_url = 'https://api.line.me/oauth2/v2.1/verify';
      $params = [
        'id_token' => $line_id_token,
        'client_id' => $_ENV['LINE_CLIENT_ID']
      ];
      $query_params = http_build_query($params);

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $base_url);
      curl_setopt($ch, CURLOPT_POST, TRUE);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $query_params);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $return_value = curl_exec($ch);
      curl_close($ch);

      $ary_return_value = json_decode($return_value, true);
      $line_id = $ary_return_value['sub'];

      // line_id_tokenをもとにusersテーブルにすでにidが存在するか確認
      $stmt = $pdo->prepare('SELECT id FROM users WHERE line_id = :line_id');
      $stmt->bindValue(':line_id', $line_id, PDO::PARAM_STR);
      $stmt->execute();
      $res = $stmt->fetch();
      $_SESSION['user_id'] = $res['id'];

      // usersテーブルにidが存在しない場合は初めてのログインなのでINSERT
      if (empty($_SESSION['user_id'])) {
        $stmt = $pdo->prepare('INSERT INTO users (line_id) VALUES(?)');
        $stmt->execute([
          $line_id
        ]);

        // usersテーブルからidを取得して$user_idに格納
        $stmt = $pdo->prepare('SELECT id FROM users WHERE line_id = :line_id');
        $stmt->bindValue(':line_id', $line_id, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch();
        $_SESSION['user_id'] = $res['id'];
      }

    } else {
      return $res['error'] = 'ハナエラビのLINE公式アカウントからログインしてください';
    }
  }
}

?>