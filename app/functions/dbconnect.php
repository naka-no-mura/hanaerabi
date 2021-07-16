<?php

function getPdoInstance($pdo) {
  try {
    $pdo = new PDO(
      DSN,
      DB_USER,
      DB_PASS,
      [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      ]
    );

    return $pdo;
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit();
  }
}

?>