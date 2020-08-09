<?php

  class Project implements ProjectInterface{
      private $cell_id;
      private $user_id;
      private $title;
      private $description;
      private $start_date;
      private $end_date;
      private $source;
      private $operation;




      public function new_project($fields){
           $this->cell_id = $fields['cell_id'];
           $this->user_id = $fields['creator'];
           $this->title = $fields['title'];
           $this->description = $fields['description'];
           $this->start_date = $fields['start_date'];
           $this->end_date = $fields['end_date'];
           $this->source = $fields['source'];
           $this->operation = $fields['operation'];

           $already_created = $this->is_already_created($this->title)->rowCount();

           $response = '';

          if ($already_created==0){
                $sqlQuery = "Insert into projects set title=:title, description=:description, cell_id=:cell_id,
                 creator=:user_id, start_date=:start_date, end_date=:end_date, source=:source";

                 $QueryExecutor = new PDO_QueryExecutor();
                 $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

                 //pdo parameters
                 $stmt->bindParam(":title", $this->title);
                 $stmt->bindParam(":description", $this->description);
                 $stmt->bindParam(":cell_id", $this->cell_id);
                 $stmt->bindParam(":user_id", $this->user_id);
                 $stmt->bindParam(':start_date', $this->start_date);
                 $stmt->bindParam(':end_date', $this->end_date);
                 $stmt->bindParam(':source', $this->source);


                 // pdo object execute
                 $stmt->execute();


                 if ($stmt->rowCount())
                 {
                    $project_id = $this->get_new_project_id($this->title);
                    $response = array('status'=>'success', 'msg'=>"The Project has been successfully created.",
                                      'new_project_id'=>$project_id);
                 }else{
                    $reponse = array('status'=>'failed', 'msg'=>"An error occurred creating the Project <strong>'".$this->title."'</strong>");
                 }



          }else{
                  $response = array('status'=>'failed', 'msg'=>"The Project exist and cannot be duplicated.");

          }


          // return response
          return $response;

      }


      private function is_already_created($title){

          $sqlQuery = "Select * from projects where title=:title";

          // create pdo objects
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          // define parameters
          $stmt->bindParam(":title", $title);

          // execute sql objects
          $stmt->execute();
          return $stmt;
      }




      private function get_new_project_id($title){

          $new_project_id = '';
          $sqlQuery = "Select id from projects where title=:title";

          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          //pdo parameters
          $stmt->bindParam(":title", $title);

          //pdo statement
          $stmt->execute();

          if ($stmt->rowCount()){
                foreach($stmt as $row){
                    $new_project_id = $row['id'];
                }
          } else {
                $new_project_id = '';
          }// end of if statement

          return $new_project_id;
      }



      public function update_project($fields){
           $this->cell_id = $fields['cell_id'];
           $this->user_id = $fields['creator'];
           $this->title = $fields['title'];
           $this->description = $fields['description'];
           $this->start_date = $fields['start_date'];
           $this->end_date = $fields['end_date'];
           $this->source = $fields['source'];
           $new_project_id = $fields['new_project_id'];

           $response = '';

      }


  } //end of class






?>
