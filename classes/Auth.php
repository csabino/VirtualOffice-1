<?php


  class Auth implements AuthInterface{

      //private date_created;

      public function login($username, $password){
          $sqlQuery  = "Select id, user_id, file_no, email, role from auth where (file_no=:username or email=:username) and password=:password";
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor::customQuery()->prepare($sqlQuery);

          //$this->date_created = date('Y-m-d H:i:s');

          $stmt->bindParam(":username",$username);
          $stmt->bindParam(":password",$password);

          $stmt->execute();
          return $stmt;
      }// end of logged


      public function is_firstLogin($userid){
          //check the Auth login table for first time login to
          //know if the onboarding message is to be displayed
          $sqlQuery = "Select id from auth_log where user_id=:userid limit 1";
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor::customQuery()->prepare($sqlQuery);

          $stmt->bindParam(":userid",$userid);

          $stmt->execute();
          return $stmt;
      }

    


  }



 ?>
