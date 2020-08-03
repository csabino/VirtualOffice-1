<?php

  class General_Room{
      private $cell_id;
      private $user_id;
      private $post;

      public function new_post($fields){
          $this->cell_id = $fields['cell_id'];
          $this->user_id = $fields['user_id'];
          $this->post = $fields['post'];

          $sqlQuery = "Insert into general_rooms set cell_id=:cell_id, user_id=:user_id, message=:post";

          //pdo Object
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          //bind parameters
          $stmt->bindParam(":cell_id", $this->cell_id);
          $stmt->bindParam(":user_id", $this->user_id);
          $stmt->bindParam(":post", $this->post);

          //execute pdo Object
          $stmt->execute();
          return $stmt;
      }

  }

?>
