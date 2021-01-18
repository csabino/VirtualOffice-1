<?php

  class GeneralRoom implements GeneralRoomInterface{
      private $cell_id;
      private $user_id;
      private $post;
      private $last_post_id;

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

      public function getPostsByCell($cell_id){

        // $sqlQuery
        $sqlQuery = "Select gr.id, gr.cell_id, gr.user_id, gr.message, gr.date_created,
                    u.title, u.first_name, u.last_name, u.avatar from general_rooms gr inner join users u on
                    gr.user_id=u.id where gr.cell_id=:cell_id";

        // pdo object
        $QueryExecutor = new PDO_QueryExecutor();
        $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

        // bind Params
        $stmt->bindParam(":cell_id", $cell_id);

        // execute $stmt
        $stmt->execute();

        return $stmt;

      }

      public function get_new_messages($fields){
        $this->cell_id = $fields['cell_id'];
        $this->last_post_id = $fields['last_post_id'];

        // $sqlQuery
        $sqlQuery = "Select gr.id, gr.cell_id, gr.user_id, gr.message, gr.date_created,
                    u.title, u.first_name, u.last_name, u.avatar from general_rooms gr inner join users u on
                    gr.user_id=u.id where gr.cell_id=:cell_id and gr.id>:post_id";

        //pdo objects
        $QueryExecutor = new PDO_QueryExecutor();
        $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

        // bind Params
        $stmt->bindParam(":cell_id", $this->cell_id);
        $stmt->bindParam(":post_id", $this->last_post_id);

        // pdo execute
        $stmt->execute();

        return $stmt;
      }

  }

?>
