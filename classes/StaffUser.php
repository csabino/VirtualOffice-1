<?php

  class StaffUser extends User implements UserInterface {

      // public function __construct($file_no, $title, $firstname, $lastname, $othernames, $avatar){
      //     parent::__construct($file_no, $title, $firstname, $lastname, $othernames, $avatar);
      // }

      public function getUserById($user_id){
          $this->user_id = $user_id;
          $sqlQuery =  "Select * from users where id=:id";
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor::customQuery()->prepare($sqlQuery);

          $stmt->bindParam(":id",$this->user_id);

          $stmt->execute();

          return $stmt;
      }

      public function get_all_staff(){

          // sql statement
          $sqlQuery = "Select u.id, u.file_no, u.title, u.first_name, u.last_name,
                      u.other_names, u.position, u.avatar, u.date_created, u.date_modified, a.email, a.role from
                      users u inner join auth a on u.id=a.user_id where a.role='staff' ";

          // PDOStatement, prepare and execute
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);
          $stmt->execute();
          return $stmt;

      }


      public function email_exist($email){
          $this->email = $email;

          // sql statement
          $sqlQuery = "Select * from auth where email=:email";

          // pdo object, prepare
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          // bind parameters
          $stmt->bindParam(":email", $this->email);

          // execute $stmt
          $stmt->execute();
          return $stmt;
      }



  }


 ?>
