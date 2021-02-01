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

      public function generate_password()
      {
          $code = '';
          $i = 0;
          $characters = "012345689abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
          $character_length = strlen($characters);

           $randIndex = mt_rand(0, $character_length-1);
           for($i=0; $i<8; $i++ ){
              $randIndex = mt_rand(0, $character_length-1);
              $code .= $characters[$randIndex];
           }
           return $code;
      }


      public function insert_auth_password($fileno, $password_encrypt){
          // $sqlQuery
          $sqlQuery = "Update auth set password=:password where file_no=:file_no";

          // PDO object
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          // bind params
          $stmt->bindParam(":password", $password_encrypt);
          $stmt->bindParam(":file_no", $fileno);

          // execute
          $stmt->execute();

          return $stmt;

      }




  }



 ?>
