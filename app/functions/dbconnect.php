<?php

// 本番環境用
// function getPdoInstance($pdo) {
//   try {
//     $pdo = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
//     $pdo['dbname'] = ltrim($pdo['path'], '/');
//     $dsn = "mysql:host={$pdo['host']};dbname={$pdo['dbname']};charset=utf8";
//     $user = $pdo['user'];
//     $pass = $pdo['pass'];
//     $options = [
//       PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//       PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//       PDO::MYSQL_ATTR_USE_BUFFERED_QUERY =>true,
//     ];
//     $pdo = new PDO($dsn, $user, $pass, $options);
//     return $pdo;
//   } catch (PDOException $e) {
//     echo $e->getMessage();
//     exit();
//   }
// }

// 開発環境用
function getPdoInstance($pdo) {
  try {
    $dsn = "mysql:dbname=hanaerabi;host=localhost;charset=utf8";
    $user = 'root';
    $pass = 'root';
    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::MYSQL_ATTR_USE_BUFFERED_QUERY =>true,
    ];
    $pdo = new PDO($dsn, $user, $pass, $options);
    return $pdo;
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit();
  }
}

?>