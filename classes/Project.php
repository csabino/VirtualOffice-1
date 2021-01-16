<?php

  class Project implements ProjectInterface{
      private $cell_id;
      private $user_id;
      private $author;
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
      private $comment;
      private $comment_id;
      private $project_update_id;



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


           if ($new_project_id!=''){
              $sqlQuery = "Update projects set title=:title, description=:description, cell_id=:cell_id, creator=:user_id,
              start_date=:start_date, end_date=:end_date, source=:source where id=:new_project_id";

              // pdo object
              $QueryExecutor = new PDO_QueryExecutor();
              $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

              // binding pdo parameters
              $stmt->bindParam(":title", $this->title);
              $stmt->bindParam(":description", $this->description);
              $stmt->bindParam(":cell_id", $this->cell_id);
              $stmt->bindParam(":user_id", $this->user_id);
              $stmt->bindParam(":start_date", $this->start_date);
              $stmt->bindParam(":end_date", $this->end_date);
              $stmt->bindParam(":source", $this->source);
              $stmt->bindParam(":new_project_id", $new_project_id);


              // pdo object execute
              $stmt->execute();

              if ($stmt->rowCount()){
                  $response = array('status'=>'success', 'msg'=>'The Project has been successfully updated.');
              }else{
                  $response = array('status'=>'failed', 'msg'=>'An error occurred updating the Project.');
              }
           }else{
                $response = array('status'=>'failed', 'msg'=>'No Project has been created or selected');
           }

           return $response;
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

            $sqlQuery = "Select * from projects_updates where project_id=:project_id order by id desc ";

            // pdo object
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // pdo parameters
            $stmt->bindParam(":project_id", $this->project_id);

            // pdo object execute
            $stmt->execute();
            return $stmt;
        }


        public function get_projects_updates_by_id($project_updates_id){
          $sqlQuery = "Select * from projects_updates where id=:id";

          // pdo object
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          // bind parameter to pdo object
          $stmt->bindParam(":id", $project_updates_id);

          // execute pdo object
          $stmt->execute();
          return $stmt;
        }


        public function projects_updates_comments($fields)
        {
            $this->author = $fields['user_id'];
            $this->comment = $fields['comment'];
            $this->project_update_id = $fields['project_update_id'];

            // to get time-stamp for 'created' field
            $timestamp = date('Y-m-d H:i:s');
            $date_posted = $timestamp;

            // sqlQuery
            $sqlQuery = "Insert into projects_updates_comments set project_update_id=:project_update_id,
            author=:author, comment=:comment, date_posted=:date_posted";

            // pdo object
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            //bind parameter to pdo object
            $stmt->bindParam(":project_update_id", $this->project_update_id);
            $stmt->bindParam(":author", $this->author);
            $stmt->bindParam(":comment", $this->comment);
            $stmt->bindParam(":date_posted", $date_posted);

            // execute pdo objects
            $stmt->execute();

            return $stmt;
        }

        public function get_projects_updates_comments($project_update_id){

            $this->project_update_id = $project_update_id;

            // sql Query
            $sqlQuery = "Select puc.id, puc.project_update_id, puc.author, puc.comment,
            u.file_no, u.title, u.first_name, u.last_name, u.other_names, u.avatar, puc.date_posted from projects_updates_comments puc
            inner join users u on puc.author=u.id where puc.project_update_id=:project_update_id order by puc.id desc";

            // pdo object
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // bind parameters
            $stmt->bindParam(":project_update_id", $this->project_update_id);


            // execute pdo objects
            $stmt->execute();

            return $stmt;

        }


        public function get_projects_updates_comments_range($project_update_id, $start, $count){

            $this->project_update_id = $project_update_id;

            // sql Query
            $sqlQuery = "Select puc.id, puc.project_update_id, puc.author, puc.comment,
            u.file_no, u.title, u.first_name, u.last_name, u.other_names, u.avatar, puc.date_posted from projects_updates_comments puc
            inner join users u on puc.author=u.id where project_update_id=:project_update_id and puc.id>{$start} order by puc.id desc";

            // pdo object
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            //bind parameters
            $stmt->bindParam(":project_update_id", $this->project_update_id);

            // execute pdo objects
            $stmt->execute();

            return $stmt;

        }


        public function delete_project_update_comment($fields){
            //fields
            $this->comment_id = $fields['comment_id'];
            $this->user_id = $fields['user_id'];
            $this->project_update_id = $fields['project_update_id'];

            // sql Query
            $sqlQuery = "Delete from projects_updates_comments where id=:id";

            // pdo Query
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // bind parameters
            $stmt->bindParam(":id", $this->comment_id);

            // execute
            $stmt->execute();

            return $stmt;
        }


        public function create_project_checklist($fields){
            //fields
            $project_id = $fields['project_id'];
            $user_id = $fields['user_id'];
            $checklist_item = $fields['checklist_item'];
            $checklist_description = $fields['checklist_description'];

            // to get time-stamp for 'date created' field
            $timestamp = date('Y-m-d H:i:s');
            $date_created = $timestamp;

            // get time-stamp for 'date modified' field
            $date_modified = $timestamp;

            // sqlQuery
            $sqlQuery = "Insert into project_checklists set project_id=:project_id, user_id=:user_id, item=:item, description=:description,
            date_created=:date_created, date_modified=:date_modified";

            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // bind parameters
            $stmt->bindParam(":project_id", $project_id);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":item", $checklist_item);
            $stmt->bindParam(":description", $checklist_description);
            $stmt->bindParam(":date_created", $date_created);
            $stmt->bindParam(":date_modified", $date_modified);

            // execute pdo object
            $stmt->execute();

            // return pdo object
            return $stmt;
        }


        public function getUserLastProject($user_id){
            $sqlQuery = "Select * from projects where creator=:creator order by id desc limit 1";

            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // bind parameters
            $stmt->bindParam(":creator", $user_id);

            // execute pdo
            $stmt->execute();

            return $stmt;
        }

        public function getCheckListByUserAndProjectId($new_project_id, $user_id){

            // $sqlQuery
            $sqlQuery = "Select * from project_checklists where user_id=:user_id and project_id=:project_id";

            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // bind parameters
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":project_id", $new_project_id);

            // execute pdo
            $stmt->execute();

            return $stmt;

        }

        public function getLastCheckListByUserAndProjectId($new_project_id, $user_id){

            // $sqlQuery
            $sqlQuery = "Select * from project_checklists where user_id=:user_id and project_id=:project_id order by id desc limit 1";

            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // bind parameters
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":project_id", $new_project_id);

            // execute pdo
            $stmt->execute();

            return $stmt;

        }

        public function delete_project_checklist($checklist_id){

          // sql Query
          $sqlQuery = "Delete from project_checklists where id=:checklist_id";

          // pdo object
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          // bind parameters
          $stmt->bindParam(":checklist_id", $checklist_id);

          // execute PDO
          $stmt->execute();

          return $stmt;
        }


        public function create_project_milestone($fields){
            //fields
            $project_id = $fields['project_id'];
            $user_id = $fields['user_id'];
            $milestone_title = $fields['milestone_title'];
            $description = $fields['description'];
            $milestone_date = $fields['milestone_date'];

            // to get time-stamp for 'date created' field
            $timestamp = date('Y-m-d H:i:s');
            $date_created = $timestamp;

            // get time-stamp for 'date modified' field
            $date_modified = $timestamp;

            // sqlQuery
            $sqlQuery = "Insert into project_milestones set project_id=:project_id, user_id=:user_id, title=:title, description=:description,
            milestone_date=:milestone_date, date_created=:date_created, date_modified=:date_modified";

            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // bind parameters
            $stmt->bindParam(":project_id", $project_id);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":title", $milestone_title);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":milestone_date", $milestone_date);
            $stmt->bindParam(":date_created", $date_created);
            $stmt->bindParam(":date_modified", $date_modified);

            // execute pdo object
            $stmt->execute();

            // return pdo object
            return $stmt;
        }


        public function getLastMilestoneByUserAndProjectId($new_project_id, $user_id){
          // $sqlQuery
          $sqlQuery = "Select * from project_milestones where user_id=:user_id and project_id=:project_id order by id desc limit 1";

          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          // bind parameters
          $stmt->bindParam(":user_id", $user_id);
          $stmt->bindParam(":project_id", $new_project_id);

          // execute pdo
          $stmt->execute();

          //echo $stmt->rowCount();
          return $stmt;

        }

        public function delete_project_milestone($milestone_id){

          // sql Query
          $sqlQuery = "Delete from project_milestones where id=:milestone_id";

          // pdo object
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          // bind parameters
          $stmt->bindParam(":milestone_id", $milestone_id);

          // execute PDO
          $stmt->execute();

          return $stmt;
        }



  } //end of class






?>
