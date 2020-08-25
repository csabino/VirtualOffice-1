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

      private $project_id;
      private $message;
      private $file_upload_type;
      private $file;




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



      public function get_projects_by_cell($cell){

          $this->cell_id = $cell;
          $sqlQuery = "Select p.id, p.title as project_title, p.description, p.cell_id, p.creator, u.title as user_title, u.last_name, u.first_name,
                       p.start_date, p.end_date, p.source, p.completed, p.date_created, p.date_modified
                       from projects p inner join users u on p.creator=u.id where p.cell_id=:cell_id order by id desc";

          // pdo object
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          // pdo parameters
          $stmt->bindParam(":cell_id", $this->cell_id);

          // execute pdo
          $stmt->execute();
          return $stmt;
      }


      public function get_project_by_id($project_id){

        $sqlQuery = "Select p.id, p.title as project_title, p.description, p.cell_id, p.creator, u.title as user_title, u.last_name, u.first_name,
                     p.start_date, p.end_date, p.source, p.completed, p.date_created, p.date_modified
                     from projects p inner join users u on p.creator=u.id where p.id=:project_id order by id desc";

        // pdo object
        $QueryExecutor = new PDO_QueryExecutor();
        $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

        // pdo parameters
        $stmt->bindParam(":project_id", $project_id);

        // execute pdo
        $stmt->execute();
        return $stmt;
      }



      public function new_projects_update($fields){
          $this->cell_id = $fields['cell'];
          $this->user_id = $fields['sender'];
          $this->project_id = $fields['project'];
          $this->message = $fields['message'];
          $this->source = $fields['source'];
          $this->file_upload_type = $fields['file_upload_type'];
          $this->file = $fields['file'];

          // sqlQuery
          $sqlQuery = "Insert into projects_updates set cell_id=:cell_id, user_id=:user_id, project_id=:project_id,
                      message=:message, source=:source, file_type=:file_type, file=:file";

          // pdo objects
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          // pdo parameters
          $stmt->bindParam(":cell_id", $this->cell_id);
          $stmt->bindParam(":user_id", $this->user_id);
          $stmt->bindParam(":project_id", $this->project_id);
          $stmt->bindParam(":message", $this->message);
          $stmt->bindParam(":source", $this->source);
          $stmt->bindParam(":file_type", $this->file_upload_type);
          $stmt->bindParam(":file", $this->file);

          // pdo object execute
          $stmt->execute();
          return $stmt;
        }


        public function get_projects_updates_by_project($project_id){
            $this->project_id = $project_id;

            $sqlQuery = "Select * from projects_updates where project_id=:project_id";

            // pdo object
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // pdo parameters
            $stmt->bindParam(":project_id", $this->project_id);

            // pdo object execute
            $stmt->execute();
            return $stmt;
        }







  } //end of class






?>
