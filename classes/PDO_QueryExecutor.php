<?php

  require_once('PDODriver.php');
  class PDO_QueryExecutor{

      private static $host = '127.0.0.1';
      private static $uid = 'root';
      private static $password = '';
      private static $db = 'workplace';

      public static function customQuery(){
          try{
              $pdo = new PDODriver(self::$host, self::$uid, self::$password, self::$db);
              $connection = $pdo->db_connect();

              return $connection;

          }catch(Exception $e){
              echo 'Message'.$e->getMessage();
          }
      }



  }

 ?>
