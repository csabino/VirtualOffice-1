<?php
    
    class MySQLDriver extends Database Implements DBInterface{

        private $host;
        private $uid;
        private $password;
        private $db;

        // Constructor
        public function __construct($host, $uid, $password, $db){
            parent::__construct($host, $db, $uid, $password);
            $this->host = $host;
            $this->db = $db;
            $this->uid = $uid;
            $this->password;
        }

        //Establish Database connection
        public function db_connect(){
            $mysqli = new mysqli($this->host, $this->uid, $this->password, $this->db);
            return $mysqli;
        }

    }

 ?>
