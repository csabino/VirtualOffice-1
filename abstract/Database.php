 <?php
  abstract class Database{
      private $host;
      private $db;
      private $uid;
      private $password;

      public function __construct($host, $db, $uid, $password){
          $this->host = $host;
          $this->dbname = $db;
          $this->uid = $uid;
          $this->password = $password;

      }

  }

?>
