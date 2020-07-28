<?php

  require_once('MySQLDriver.php');
  class MySQL_QueryExecutor{

      private static $host = '127.0.0.1';
      private static $uid = 'root';
      private static $password = '';
      private static $db = 'workplace';

      public static function customQuery($sqlQuery){

          try{
              $mysql = new MySQLDriver(self::$host, self::$uid, self::$password, self::$db);
              $connection = $mysql->db_connect();
              $result = $connection->query($sqlQuery) or die(mysqli_error($connection));
              $connection->close();

              return $result;
              $result->close();

          }catch(Exception $e){
              echo 'Message'.$e->getMessage();
          }
      }



  }

 ?>
