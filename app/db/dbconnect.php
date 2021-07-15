<?php

try {
  $db = new PDO('mysql:dbname=hanaerabi;host=localhost;charset=utf8', 'root', 'root');
} catch(PDOException $e) {
  print_r('DB接続エラー:' . $e->getMessage());
}

?>