<?php

namespace Library;

/**
 * Description of PDOFactory
 *
 * @author Markus-Strike
 */
class PDOFactory {
    public static function getMysqlConnexion()
     {
      $db = new \PDO('mysql:host=localhost;dbname=gestion_news', 'adminUser', '');
      $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      return $db;
    }
}
