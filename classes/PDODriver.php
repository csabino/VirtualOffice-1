<?php

    class PDODriver extends Database Implements DBInterface{

        private $host;
        private $uid;
        private $password;
        private $db;

        public $pdo_conn;

        // Constructor
        public function __construct($host, $uid, $password, $db){
            parent::__construct($host, $db, $uid, $password);
            $this->host = $host;
            $this->db = $db;
            $this->uid = $uid;
            $this->password = $password;
        }

        //Establish Database connection
        public function db_connect(){
            //$this->pdo_conn = null;

            if ($this->pdo_conn){
                  return $this->pdo_conn;
            }else{
                  try{
                      $this->pdo_conn = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->uid, $this->password);
                      $this->pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                      return $this->pdo_conn;
                  }catch(PDOException $e){
                      echo "Connection Error: ".$e->getMessage();
                      print_r($e);
                  }
            }

        }

    }

 ?>
