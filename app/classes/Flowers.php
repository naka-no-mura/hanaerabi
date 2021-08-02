<?php

class Flowers {

  private static $name;
  private static $image;
  private static $meaning;

  public static function getFlowers($pdo) {
    self::$meaning = $_GET['meaning'];
    if ($_GET['flower_id']) {
      $stmt = $pdo->prepare(
        'SELECT seasons.season, flowers.name, flowers.image, GROUP_CONCAT(meanings.meaning)
        FROM `seasons`
        JOIN categorization ON seasons.id = categorization.season_id
        JOIN flowers ON categorization.flower_id = flowers.id
        JOIN language ON flowers.id = language.flower_id
        JOIN meanings ON language.meaning_id = meanings.id
        GROUP BY flowers.id, seasons.season
        HAVING flowers.id = :flower_num AND seasons.season = :season_name'
      );
      $stmt->bindValue(':flower_num', $_GET['flower_id'], PDO::PARAM_INT);
      $stmt->bindValue(':season_name', $_GET['season'], PDO::PARAM_STR);
      $stmt->execute();
      $flowers = $stmt->fetchAll();
      self::$name = $flowers[0]['name'];
      self::$image = $flowers[0]['image'];
      return $flowers;
    }
  }

  public static function getName() {
    return self::$name;
  }

  public static function getImage() {
    return self::$image;
  }

  public static function getMeaning() {
    return self::$meaning;
  }
}

?>